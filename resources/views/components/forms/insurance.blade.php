<div><div class="contact-form">
    <div class="contact-form-title">
        <h3 class="text-anime-style-3 text-center mb-3" data-cursor="-opaque" style="perspective: 400px;">
            Service History & Claim Details
        </h3>
        <p class="text-center mb-4">Get the truth about any car's past.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
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

   
    <div class="mb-5">
        <h5 class="text-center mb-3">Service Fee per Report</h5>
        <div class="table-responsive">
            <table class="table table-bordered text-center small">
                <thead class="table-dark">
                    <tr>
                        <th>Car Segment</th>
                        <th>Full Report Fee</th>
                        <th>Booking Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Standard (Hatch/Sedan)</td><td>₹999</td><td>₹500</td></tr>
                    <tr><td>Premium (SUV/Luxury)</td><td>₹1,999</td><td>₹500</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <form id="historyBooking" novalidate action="{{ route('insurance.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="customer_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                    <input required type="text" name="customer_name" id="customer_name" placeholder="Enter your name"
                        class="form-control" value="{{ old('customer_name') }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="customer_mobile" class="form-label">Mobile Number <span class="text-danger">*</span></label>
                    <input required type="text" name="customer_mobile" id="phone" placeholder="10-digit mobile"
                        class="form-control" value="{{ old('customer_mobile') }}">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group mb-4">
                    <label for="vehicle_reg_no" class="form-label">Vehicle Registration Number <span class="text-danger">*</span></label>
                    <input required type="text" name="vehicle_reg_no" id="vehicle_reg_no"
                        placeholder="e.g. DL 01 CA 1234" class="form-control" value="{{ old('vehicle_reg_no') }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="rc_photo" class="form-label">Upload RC Copy <span class="text-danger">*</span></label>
                    <input required type="file" name="rc_photo" id="rc_photo" class="form-control" accept="image/*,.pdf">
                    <div class=" small mt-1">Clear photo of the Front RC</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="insurance_photo" class="form-label">Latest Insurance Policy <span class="text-danger">*</span></label>
                    <input required type="file" name="insurance_photo" id="insurance_photo" class="form-control" accept="image/*,.pdf">
                    <div class="small mt-1">Required for claim history</div>
                </div>
            </div>

            <div class="form-group col-md-12 mb-4 ">
                <div class="cf-turnstile d-inline-block" data-sitekey="{{ config('services.turnstile.site_key') }}" data-theme="dark"></div>
                @error('cf-turnstile-response')
                    <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="alert alert-light small p-2 px-3 w-fit d-block  mb-4 " data-bs-theme="dark">
            Pay <strong>₹500</strong> to initiate the search. Our experts will call you within 3 working hours.
        </div>

        <div class="text-center mt-3">
            <button type="submit" class="btn-default">
             One Call. Clear Answers.
            </button>
        </div>
    </form>
</div></div>
