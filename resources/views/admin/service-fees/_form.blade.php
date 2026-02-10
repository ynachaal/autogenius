<div class="card shadow-sm rounded-lg p-4">
    <form action="{{ $action }}" method="POST" id="serviceFeeForm">
        @csrf
        {!! $method ?? '' !!}

        <div class="mb-3">
            <label for="car_segment" class="form-label fw-medium text-dark">Car Segment (e.g., SUV, Hatchback)</label>
            <input type="text" name="car_segment" id="car_segment" value="{{ old('car_segment', $serviceFee->car_segment ?? '') }}"
                   class="form-control @error('car_segment') is-invalid @enderror" required>
            @error('car_segment') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="full_report_fee" class="form-label fw-medium text-dark">Full Report Fee</label>
                <div class="input-group">
                    <span class="input-group-text">₹</span>
                    <input type="number" step="0.01" name="full_report_fee" id="full_report_fee" 
                           value="{{ old('full_report_fee', $serviceFee->full_report_fee ?? '') }}"
                           class="form-control @error('full_report_fee') is-invalid @enderror" required>
                </div>
                @error('full_report_fee') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="booking_amount" class="form-label fw-medium text-dark">Booking Amount</label>
                <div class="input-group">
                    <span class="input-group-text">₹</span>
                    <input type="number" step="0.01" name="booking_amount" id="booking_amount" 
                           value="{{ old('booking_amount', $serviceFee->booking_amount ?? '') }}"
                           class="form-control @error('booking_amount') is-invalid @enderror" required>
                </div>
                @error('booking_amount') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="mb-3 form-check form-switch">
            <input type="hidden" name="status" value="0">
            <input class="form-check-input" type="checkbox" name="status" id="status" value="1" 
                {{ old('status', $serviceFee->status ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="status">Active</label>
        </div>

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-primary">{{ $submitButtonText }}</button>
            <a href="{{ route('admin.service-fees.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $("#serviceFeeForm").validate({
            rules: {
                car_segment: { required: true, minlength: 2 },
                full_report_fee: { required: true, number: true, min: 0 },
                booking_amount: { required: true, number: true, min: 0 }
            },
            messages: {
                full_report_fee: {
                    required: "Please enter the report fee",
                    number: "Please enter a valid amount",
                    min: "Fee cannot be negative"
                },
                booking_amount: {
                    required: "Please enter the booking amount",
                    number: "Please enter a valid amount",
                    min: "Amount cannot be negative"
                }
            },
            errorElement: "div",
            errorClass: "invalid-feedback",
            highlight: function(element) { $(element).addClass("is-invalid"); },
            unhighlight: function(element) { $(element).removeClass("is-invalid"); },
            errorPlacement: function(error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent()); // Places error below the input group
                } else {
                    error.insertAfter(element);
                }
            }
        });
    });
</script>
@endpush