<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processing Payment...</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font-family: sans-serif;
        }
        .payment-card {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            max-width: 450px;
            width: 90%;
            text-align: center;
        }
        .spinner-border { width: 3rem; height: 3rem; }
    </style>
</head>
<body>

<div class="payment-card">
    <div id="payment-status-container">
        <div id="loading-ui">
            <div class="spinner-border text-primary mb-4" role="status"></div>
            <h3 class="fw-bold">Securing Your Consultation</h3>
            <p class="text-muted">Opening secure payment gateway...</p>
        </div>

        <div id="action-ui" class="d-none">
            <div class="text-warning mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                  <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
                </svg>
            </div>
            <h3 class="fw-bold">Payment Interrupted</h3>
            <p class="text-muted">You closed the payment window before completing the transaction.</p>
            <div class="d-grid gap-2 mt-4">
                <button id="pay-btn" class="btn btn-primary btn-lg">Retry Payment</button>
                <a href="{{ url('/') }}" class="btn btn-link text-decoration-none">Cancel and Go Back</a>
            </div>
        </div>
    </div>

    {{-- Updated Form Action for Verification --}}
    <form id="razorpay-form" action="{{ route('call-consultation.payment.verify') }}" method="POST">
        @csrf
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
        <input type="hidden" name="razorpay_order_id" value="{{ $payment->order_id }}">
        <input type="hidden" name="razorpay_signature" id="razorpay_signature">
    </form>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    const options = {
        key: "{{ $razorpayKey }}",
        amount: "{{ $payment->amount }}",
        currency: "INR",
        name: "AutoGenius",
        description: "{{ $consultation->selected_service }}", {{-- Shows the actual service selected --}}
        order_id: "{{ $payment->order_id }}",
        handler: function (response) {
            document.getElementById('payment-status-container').innerHTML = `
                <div class="spinner-border text-success mb-4" role="status"></div>
                <h3 class="fw-bold">Verifying Payment</h3>
                <p class="text-muted">Transaction successful! Confirming your expert call...</p>
            `;
            
            document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
            document.getElementById('razorpay_signature').value = response.razorpay_signature;
            document.getElementById('razorpay-form').submit();
        },
        prefill: {
            name: "{{ $consultation->customer_name }}",
            contact: "{{ $consultation->customer_mobile }}",
            email: "{{ $consultation->customer_email }}"
        },
        theme: { color: "#0d6efd" },
        modal: {
            ondismiss: function() {
                document.getElementById('loading-ui').classList.add('d-none');
                document.getElementById('action-ui').classList.remove('d-none');
            }
        }
    };

    const rzp = new Razorpay(options);

    document.getElementById('pay-btn').onclick = function(e) {
        e.preventDefault();
        rzp.open();
    };

    window.onload = function () {
        rzp.open();
    };
</script>

</body>
</html>