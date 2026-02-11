<div>
    <div class="contact-form">
        <div class="contact-form-title">
            <h3 class="text-anime-style-3 text-center mb-3" data-cursor="-opaque" style="perspective: 400px;">
                Service History & Claim Details
            </h3>
            <p class="text-center mb-4">Get the truth about any car's past.</p>
        </div>

        @if(session('success'))
            <div id="sell-car-success"  class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Dynamic Pricing Table --}}
       

        <form id="historyBooking" novalidate action="{{ route('service-insurance.submit') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="mb-5">
                <h5 class="text-center mb-3">Service Fee per Report</h5>
                <div class="table-responsive">
                    <table class="table table-bordered text-center small">
                        <thead class="table-dark">
                            <tr>
                                <th>Select</th> {{-- New Column --}}
                                <th>Car Segment</th>
                                <th>Full Report Fee</th>
                                <th>Booking Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($fees as $fee)
                                <tr>
                                    <td>
                                        {{-- Radio button to select the segment --}}
                                       <input type="radio" name="fee_id" value="{{ $fee->id }}" 
       data-amount="{{ number_format($fee->booking_amount, 0) }}" 
       class="fee-selector" 
       {{ $loop->first ? 'checked' : '' }}>
                                    </td>
                                    <td>{{ $fee->car_segment }}</td>
                                    <td>₹{{ number_format($fee->full_report_fee, 0) }}</td>
                                    <td>₹{{ number_format($fee->booking_amount, 0) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-3 text-muted">Pricing information currently unavailable.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{-- Error message for radio selection --}}
                    @error('fee_id')
                        <div class="text-danger small text-center">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="customer_name" class="form-label">Full Name <span
                                class="text-danger">*</span></label>
                        <input required type="text" name="customer_name" id="customer_name"
                            placeholder="Enter your name" class="form-control" value="{{ old('customer_name') }}">

                        <input type="hidden" name="page_slug"
                            value="{{ $slug ?? request()->segment(count(request()->segments())) }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="customer_email" class="form-label">Email Address <span
                                class="text-danger">*</span></label>
                        <input required type="email" name="customer_email" id="customer_email" placeholder="email@example.com"
                            class="form-control" value="{{ old('customer_email') }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="customer_mobile" class="form-label">Mobile Number <span
                                class="text-danger">*</span></label>
                        <input required type="text" name="customer_mobile" id="phone" placeholder="10-digit mobile"
                            class="form-control" value="{{ old('customer_mobile') }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="rc_photo" class="form-label">Upload RC Copy <span
                                class="text-danger">*</span></label>
                        <input required type="file" name="rc_photo" id="rc_photo" class="form-control"
                            >
                        <p >Clear photo of the Front RC</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="insurance_photo" class="form-label">Upload Latest Insurance Policy <span
                                class="text-danger">*</span></label>
                        <input required type="file" name="insurance_photo" id="insurance_photo" class="form-control"
                           >

                    </div>
                </div>

                <div class="form-group col-md-12 mb-4 ">
                    <div class="cf-turnstile d-inline-block" data-sitekey="{{ config('services.turnstile.site_key') }}"
                        data-theme="dark"></div>
                    @error('cf-turnstile-response')
                        <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

           {{-- Update the Alert Box --}}
<div class="alert alert-light small p-2 px-3 w-fit d-block mb-4" data-bs-theme="dark">
    Pay <strong id="display-amount">₹500</strong> to initiate the search. Our experts will call you within 3 working hours.
</div>

            <div class="text-center mt-3">
                <button type="submit" class="btn-default">
                    One Call. Clear Answers.
                </button>
            </div>
        </form>
    </div>
</div>