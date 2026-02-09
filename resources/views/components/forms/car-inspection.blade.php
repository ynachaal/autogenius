<div>
    <div class="contact-form">
        <div class="contact-form-title">
            <h3 class="text-anime-style-3 text-center mb-3" data-cursor="-opaque" style="perspective: 400px;">
                Book PDI Inspection - AutoGenius
            </h3>
        </div>

        @if(session('success'))
            <div id="sell-car-success" class="alert alert-success alert-dismissible fade show" role="alert">
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

        <form id="pdiBooking" novalidate action="{{ route('pdi.submit') }}" method="POST">
            @csrf
            <div class="row">
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
                        <input required type="text" name="customer_mobile" id="phone" placeholder="Phone Number"
                            class="form-control" value="{{ old('customer_mobile') }}">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group mb-4">
                        <label for="customer_email" class="form-label">Email Address <span
                                class="text-danger">*</span></label>
                        <input required type="email" name="customer_email" id="customer_email"
                            placeholder="Email Address" class="form-control" value="{{ old('customer_email') }}">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group mb-4">
                        <label for="vehicle_name" class="form-label">Vehicle Name <span
                                class="text-danger">*</span></label>
                        <input required type="text" name="vehicle_name" id="vehicle_name"
                            placeholder="e.g. Toyota Fortuner" class="form-control" value="{{ old('vehicle_name') }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="pdi_date" class="form-label">Preferred Date (DDMMYY) <span
                                class="text-danger">*</span></label>
                        <input required type="text" name="pdi_date" id="datepicker" placeholder="e.g. 251226"
                            maxlength="6" class="form-control" value="{{ old('pdi_date') }}">
                     
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="pdi_location" class="form-label">Inspection Location <span
                                class="text-danger">*</span></label>
                        <input required type="text" name="pdi_location" id="pdi_location"
                            placeholder="Dealership or City Name" class="form-control"
                            value="{{ old('pdi_location') }}">
                    </div>
                </div>

                <div class="form-group col-md-12 mb-4">
                    <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}"
                        data-theme="dark"></div>
                    @error('cf-turnstile-response')
                        <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror
                    <div id="turnstile-error" class="text-danger mt-1 small" style="display:none;">
                        Please verify that you are not a robot.
                    </div>
                </div>
            </div>
            <div class="alert alert-light small p-2 px-3 w-fit d-block mb-4" data-bs-theme="dark">
                Pay ₹500 to register.
            </div>
            <div class="text-center mt-3">
                <button type="submit" class="btn-default">Book Your Car Inspection</button>
            </div>
        </form>
    </div>
</div>