<div class="payment-card">
    <div id="payment-status-container">
        </div>

    <form id="razorpay-form" action="{{ route('inspection.payment.verify') }}" method="POST">
        @csrf
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
        <input type="hidden" name="razorpay_order_id" value="{{ $inspection->razorpay_order_id }}">
        <input type="hidden" name="razorpay_signature" id="razorpay_signature">
    </form>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    const options = {
        key: "{{ $razorpayKey }}",
        // 3. Update variables to $inspection
        amount: "{{ $inspection->amount_paid }}", 
        currency: "INR",
        name: "AutoGenius",
        description: "PDI Car Inspection Fee", // Specific description
        order_id: "{{ $inspection->razorpay_order_id }}",
        handler: function (response) {
            document.getElementById('payment-status-container').innerHTML = `
                <div class="spinner-border text-success mb-4" role="status"></div>
                <h3 class="fw-bold">Verifying Payment</h3>
                <p class="text-muted">Transaction successful! Confirming your inspection...</p>
            `;
            
            document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
            document.getElementById('razorpay_signature').value = response.razorpay_signature;
            document.getElementById('razorpay-form').submit();
        },
        modal: {
            ondismiss: function() {
                document.getElementById('loading-ui').classList.add('d-none');
                document.getElementById('action-ui').classList.remove('d-none');
            }
        },
        prefill: {
            // 4. Matches CarInspection model fields
            name: "{{ $inspection->customer_name }}",
            contact: "{{ $inspection->customer_mobile }}",
            email: "{{ $inspection->customer_email }}"
        },
        theme: { color: "#0d6efd" }
    };

    window.onload = function () {
        rzp.open();
    };
</script>

</body>
</html>