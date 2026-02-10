<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarInspection;
use App\Models\Payment; // Import the Payment model
use App\Services\EmailService; // Import the EmailService
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Log;

class CarInspectionController extends Controller
{
    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = CarInspection::with('payments');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_mobile', 'like', "%{$search}%")
                    ->orWhere('vehicle_name', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $inspections = $query->latest()->paginate(15);

        return view('admin.car-inspections.index', compact('inspections', 'search', 'status'));
    }

    public function show(CarInspection $car_inspection)
    {
        $car_inspection->load('payments');
        return view('admin.car-inspections.show', ['inspection' => $car_inspection]);
    }

    /**
     * Verify payment for a car inspection
     */
public function verifyPayment(CarInspection $car_inspection, Payment $payment)
{
    try {
        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        $razorOrder = $api->order->fetch($payment->order_id);
        // Get all payments associated with this order
        $razorPayments = $razorOrder->payments(); 

        $isPaid = false;
        $verifiedPaymentId = null;

        // Iterate through all payment attempts for this order
        foreach ($razorPayments->items as $rp) {
            if ($rp->status === 'captured') {
                $isPaid = true;
                $verifiedPaymentId = $rp->id; // Grab the actual Payment ID (pay_XXXXX)
                break;
            }
        }

        // Alternative check: If order is paid but no 'captured' payment found in loop (edge case)
        if ($razorOrder->status === 'paid') {
            $isPaid = true;
        }

        if ($isPaid) {
            $payment->update([
                // If loop found a payment ID, use it. Otherwise, keep existing.
                'payment_id' => $verifiedPaymentId ?? $payment->payment_id, 
                'status'     => 'paid',
                'paid_at'    => now(),
            ]);

            $car_inspection->update(['status' => 'confirmed']);

            $this->emailService->carInspectionAdminNotification($car_inspection);

            if (method_exists($this->emailService, 'carInspectionUserConfirmation')) {
                $this->emailService->carInspectionUserConfirmation($car_inspection);
            }

            return back()->with('success', 'Inspection payment verified and confirmed!');
        }

        return back()->with('error', 'No captured payment found. Razorpay Order status: ' . strtoupper($razorOrder->status));

    } catch (\Exception $e) {
        Log::error('Inspection Verify Error: ' . $e->getMessage());
        return back()->with('error', 'Verification failed: ' . $e->getMessage());
    }
}

    public function destroy(CarInspection $car_inspection)
    {
        $car_inspection->delete();
        return redirect()->route('admin.car-inspections.index')->with('success', 'Inspection record deleted.');
    }
}