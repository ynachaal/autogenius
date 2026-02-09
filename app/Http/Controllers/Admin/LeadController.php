<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;
use App\Models\Payment; // <--- ADD THIS LINE TO FIX THE ERROR
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Log;
class LeadController extends Controller
{
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

            // 1. Fetch the order details from Razorpay
            $razorOrder = $api->order->fetch($payment->order_id);

            // 2. Fetch payments associated with this order
            // Sometimes the Order status is 'created' but a payment inside it is 'captured'
            $razorPayments = $razorOrder->payments();

            $isPaid = false;
            $verifiedPaymentId = null;

           if ($razorOrder->status === 'paid') {
                $isPaid = true;
            } else {
                // FIX: Access the 'items' attribute directly from the collection
                // We also add a null check to prevent errors if no payments exist
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
                // 3. Update our database
                $payment->update([
                    'payment_id' => $verifiedPaymentId ?? $payment->payment_id,
                    'status' => 'paid',
                    'paid_at' => now(),
                ]);

                // 4. Trigger the Admin Notification now that we have confirmed payment


                return back()->with('success', 'Payment verified! Status updated to PAID and notification sent.');
            }

            return back()->with('error', 'Razorpay reports no successful payment for this order yet (Status: ' . strtoupper($razorOrder->status) . ').');

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