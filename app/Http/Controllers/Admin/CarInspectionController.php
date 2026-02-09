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
            $razorPayments = $razorOrder->payments();

            $isPaid = false;
            $verifiedPaymentId = null;

            if ($razorOrder->status === 'paid') {
                $isPaid = true;
            } else {
                // FIX: Access the 'items' attribute directly from the Razorpay collection
                $items = $razorPayments->items ?? [];

                foreach ($items as $rp) {
                    if ($rp->status === 'captured') {
                        $isPaid = true;
                        $verifiedPaymentId = $rp->id;
                        break;
                    }
                }
            }

            if ($isPaid) {
                $payment->update([
                    'payment_id' => $verifiedPaymentId ?? $payment->payment_id,
                    'status' => 'paid',
                    'paid_at' => now(),
                ]);

                // Update the inspection status if necessary
                $car_inspection->update(['status' => 'confirmed']);

                // Notify Admin (Make sure this method exists in your EmailService)
                $this->emailService->sendInspectionAdminNotification($car_inspection);

                return back()->with('success', 'Inspection payment verified and confirmed!');
            }

            return back()->with('error', 'Razorpay status: ' . strtoupper($razorOrder->status));

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