<div>
    <div class="contact-form">
        <div class="contact-form-title">
            <h3 class="text-anime-style-3 text-center mb-3" data-cursor="-opaque" style="perspective: 400px;">
                Sell Your Car - AutoGenius
            </h3>
        </div>
        @if(session('success'))
            <div class="sell-car-success alert alert-success alert-dismissible fade show" role="alert">
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

        <form id="sellCar" novalidate action="{{ route('car.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="vehicle_name" class="form-label">Vehicle Name <span
                                class="text-danger">*</span></label>
                        <input required type="text" name="vehicle_name" id="vehicle_name" placeholder="e.g. Honda Civic"
                            class="form-control" value="{{ old('vehicle_name') }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group mb-4">
                        <label for="year" class="form-label">Year <span class="text-danger">*</span></label>
                        <input required type="number" name="year" id="year" placeholder="2022" class="form-control"
                            value="{{ old('year') }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group mb-4">
                        <label for="kms_driven" class="form-label">Kms Driven <span class="text-danger">*</span></label>
                        <input required type="number" name="kms_driven" id="kms_driven" placeholder="e.g. 15000"
                            class="form-control" value="{{ old('kms_driven') }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group mb-4">
                        <label for="no_of_owners" class="form-label">No. of Owners <span
                                class="text-danger">*</span></label>
                        <input required type="number" name="no_of_owners" id="no_of_owners" placeholder="1"
                            class="form-control" value="{{ old('no_of_owners') }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group mb-4">
                        <label for="registration_number" class="form-label">Registration Number <span
                                class="text-danger">*</span></label>
                        <input required type="text" name="registration_number" id="registration_number"
                            placeholder="ABC-1234" class="form-control" value="{{ old('registration_number') }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group mb-4">
                        <label for="car_location" class="form-label">Car Location <span
                                class="text-danger">*</span></label>
                        <input required type="text" name="car_location" id="car_location" placeholder="City Name"
                            class="form-control" value="{{ old('car_location') }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="customer_name" class="form-label">Your Name <span
                                class="text-danger">*</span></label>
                        <input required type="text" name="customer_name" id="customer_name" placeholder="Full Name"
                            class="form-control" value="{{ old('customer_name') }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="customer_mobile" class="form-label">Mobile Number <span
                                class="text-danger">*</span></label>
                        <input required type="text" name="customer_mobile" id="phone"
                            placeholder="Phone Number" class="form-control" value="{{ old('customer_mobile') }}">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group mb-4">
                        <label for="car_photos" class="form-label">Car Photo (Optional)</label>
                        <input type="file" name="car_photos" id="car_photos" class="form-control">
                        <small>Max file size: 2MB (JPG, PNG)</small>
                    </div>
                </div>
                <div class="form-group col-md-12 mb-4">
                    <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}"
                        data-theme="dark"></div>
                    @error('cf-turnstile-response')
                        <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror
                    <div id="turnstile-error" class="text-danger mt-1 small" style="display:none;">Please verify that
                        you are not a robot.</div>
                </div>
            </div>
            <div class="text-center mt-3">
                <button type="submit" class="btn-default">Submit</button>
            </div>
        </form>
    </div>
</div>