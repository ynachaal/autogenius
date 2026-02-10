<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CallConsultation;
use App\Models\Payment;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Log;

class CallConsultationController extends Controller
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

        $query = CallConsultation::with('payments');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_mobile', 'like', "%{$search}%")
                    ->orWhere('selected_service', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $consultations = $query->latest()->paginate(15);

        return view('admin.call-consultations.index', compact('consultations', 'search', 'status'));
    }

    public function show(CallConsultation $call_consultation)
    {
        $call_consultation->load('payments');
        return view('admin.call-consultations.show', ['consultation' => $call_consultation]);
    }

    public function verifyPayment(CallConsultation $call_consultation, Payment $payment)
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
                    'status' => 'paid',
                    'paid_at' => now(),
                ]);

                $call_consultation->update(['status' => 'confirmed']);

                if (method_exists($this->emailService, 'callConsultationAdminNotification')) {
                    $this->emailService->callConsultationAdminNotification($call_consultation);
                }

                // 2. Notify User (ADD THIS)
                if (method_exists($this->emailService, 'callConsultationUserConfirmation')) {
                    $this->emailService->callConsultationUserConfirmation($call_consultation);
                }

                return back()->with('success', 'Consultation payment verified and confirmed!');
            }

            return back()->with('error', 'No captured payment found. Razorpay Order status: ' . strtoupper($razorOrder->status));

        } catch (\Exception $e) {
            Log::error('Consultation Verify Error: ' . $e->getMessage());
            return back()->with('error', 'Verification failed: ' . $e->getMessage());
        }
    }

    public function destroy(CallConsultation $call_consultation)
    {
        $call_consultation->delete();
        return redirect()->route('admin.call-consultations.index')->with('success', 'Consultation record deleted.');
    }
}