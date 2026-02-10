<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceInsuranceClaim;
use App\Models\Payment;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Log;

class ServiceInsuranceClaimController extends Controller
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

        $query = ServiceInsuranceClaim::with('payments');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_mobile', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $claims = $query->latest()->paginate(15);

        // Updated view path to match folder name
        return view('admin.service-insurance-claims.index', compact('claims', 'search', 'status'));
    }

    public function show(ServiceInsuranceClaim $service_insurance_claim)
    {
        $service_insurance_claim->load('payments');
        
        // Updated view path to match folder name
        return view('admin.service-insurance-claims.show', ['claim' => $service_insurance_claim]);
    }

    public function verifyPayment(ServiceInsuranceClaim $service_insurance_claim, Payment $payment)
    {
        try {
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

            $razorOrder = $api->order->fetch($payment->order_id);
            $razorPayments = $razorOrder->payments(); 

            $isPaid = false;
            $verifiedPaymentId = null;

            foreach ($razorPayments->items as $rp) {
                if ($rp->status === 'captured') {
                    $isPaid = true;
                    $verifiedPaymentId = $rp->id;
                    break;
                }
            }

            if ($razorOrder->status === 'paid') {
                $isPaid = true;
            }

            if ($isPaid) {
                $payment->update([
                    'payment_id' => $verifiedPaymentId ?? $payment->payment_id, 
                    'status'     => 'paid',
                    'paid_at'    => now(),
                ]);

                $service_insurance_claim->update(['status' => 'confirmed']);

                // If you have this method ready in EmailService:
                // $this->emailService->insuranceClaimAdminNotification($service_insurance_claim);

                return back()->with('success', 'Claim payment verified and confirmed!');
            }

            return back()->with('error', 'No captured payment found. Razorpay Status: ' . strtoupper($razorOrder->status));

        } catch (\Exception $e) {
            Log::error('Insurance Verify Error: ' . $e->getMessage());
            return back()->with('error', 'Verification failed: ' . $e->getMessage());
        }
    }

    public function destroy(ServiceInsuranceClaim $service_insurance_claim)
    {
        $service_insurance_claim->delete();
        
        // Updated route name to match folder/route naming convention
        return redirect()->route('admin.service-insurance-claims.index')->with('success', 'Claim record deleted.');
    }
}