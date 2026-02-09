<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;
use App\Models\Payment;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Log;
use App\Services\EmailService; // 1. Import the EmailService

class LeadController extends Controller
{
    protected $emailService; // 2. Define the property

    // 3. Add the constructor for Dependency Injection
    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $usage = $request->input('usage');

        $query = Lead::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%");
            });
        }

        if ($usage) {
            $query->where('primary_usage', $usage);
        }

        $sortBy = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');

        $submissions = $query->orderBy($sortBy, $sortDirection)->paginate(15);

        return view('admin.leads.index', compact('submissions', 'search', 'usage'));
    }

    public function show(Lead $lead)
    {
        $lead->load('payments');
        return view('admin.leads.show', compact('lead'));
    }

   public function verifyPayment(Lead $lead, Payment $payment)
{
    try {
        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        $razorOrder = $api->order->fetch($payment->order_id);
        $razorPayments = $razorOrder->payments();

        $isPaid = false;
        $verifiedPaymentId = null;

        // ALWAYS loop through payments to find the successful Payment ID
        // This ensures payment_id is never null if a captured payment exists
        $items = $razorPayments->items ?? [];
        foreach ($items as $rp) {
            if ($rp->status === 'captured') {
                $isPaid = true;
                $verifiedPaymentId = $rp->id; // This captures pay_XXXXXXXX
                break;
            }
        }

        // Fallback: Check order status if loop didn't find a captured item for some reason
        if (!$isPaid && $razorOrder->status === 'paid') {
            $isPaid = true;
        }

        if ($isPaid) {
            $payment->update([
                'payment_id' => $verifiedPaymentId ?? $payment->payment_id,
                'status'     => 'paid',
                'paid_at'    => now(),
            ]);

            // Trigger the Admin Notification
            if ($lead->declaration) {
                $this->emailService->sendLeadAdminNotification($lead);
            }

            return back()->with('success', 'Payment verified! Status updated and admin email sent.');
        }

        return back()->with('error', 'Razorpay reports no successful payment yet (Status: ' . strtoupper($razorOrder->status) . ').');

    } catch (\Exception $e) {
        Log::error('Manual Verify Error: ' . $e->getMessage());
        return back()->with('error', 'Could not verify with Razorpay: ' . $e->getMessage());
    }
}

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->route('admin.leads.index')->with('success', 'Lead deleted.');
    }
}