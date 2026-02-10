@extends('layouts.front')

@section('title', 'Payment Failed - AutoGenius')

{{-- Keeping your custom styles for the error card --}}
@push('styles')
<style>
    .error-card { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); max-width: 450px; width: 90%; text-align: center; margin: 50px auto; }
    .icon-circle { width: 80px; height: 80px; background: #fff5f5; color: #e53e3e; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; }
</style>
@endpush

@section('content')
<div class="container d-flex align-items-center justify-content-center py-5">
    <div class="error-card border">
        <div class="icon-circle">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
            </svg>
        </div>
        
        <h3 class="fw-bold text-dark">Payment Failed</h3>
        <p class="text-muted">We couldn't process your transaction. This could be due to incorrect details, insufficient funds, or a temporary connection issue.</p>

        <div class="alert alert-light border text-start small">
            <strong>Common reasons:</strong>
            <ul class="mb-0 ps-3 mt-1">
                <li>Transaction declined by your bank.</li>
                <li>Verification (OTP) was not completed.</li>
                <li>The payment session expired.</li>
            </ul>
        </div>
        
        <div class="d-grid gap-2 mt-4">
          
            <a href="{{ route('home') }}" class="btn btn-link text-decoration-none text-muted">Back to Homepage</a>
        </div>
        
        <p class="mt-4 small text-secondary">If the amount was deducted from your account, it will be refunded automatically within 5-7 business days.</p>
    </div>
</div>
@endsection