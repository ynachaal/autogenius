<div>
    <div class="contact-form">
        <div class="contact-form-title">
            <h3 class="text-anime-style-3 text-center mb-3" data-cursor="-opaque" style="perspective: 400px;">
                Car Consultation - AutoGenius
            </h3>
        </div>

        @if(session('success'))
            <div id="service-booking-success" class="alert alert-success alert-dismissible fade show" role="alert">
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

        {{-- UPDATED: Added action URL --}}
        <form id="serviceBooking" action="{{ route('service.submit') }}" novalidate method="POST">
            @csrf

            {{-- UPDATED: Changed name to service_type --}}
            <input type="hidden" name="service_type" value="{{ $slug ?? request()->segment(count(request()->segments())) }}">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="customer_name" class="form-label">Your Name <span class="text-danger">*</span></label>
                        <input required type="text" name="customer_name" id="customer_name" placeholder="Full Name"
                            class="form-control" value="{{ old('customer_name') }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="customer_mobile" class="form-label">Mobile Number <span class="text-danger">*</span></label>
                        <input required type="text" name="customer_mobile" id="phone" placeholder="Phone Number"
                            class="form-control" value="{{ old('customer_mobile') }}">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group mb-4">
                        <label for="customer_email" class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input required type="email" name="customer_email" id="customer_email"
                            placeholder="Email Address" class="form-control" value="{{ old('customer_email') }}">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group mb-4">
                        <label for="selected_service" class="form-label">Select Service <span class="text-danger">*</span></label>
                        <select required name="selected_service" id="selected_service" class="form-select form-control">
                            <option value="" selected disabled>Choose a service...</option>
                            <option value="New Car Guidance" {{ old('selected_service') == 'New Car Guidance' ? 'selected' : '' }}>Personalized Car buying guidance for New car</option>
                            <option value="Used Car Guidance" {{ old('selected_service') == 'Used Car Guidance' ? 'selected' : '' }}>Personalized Car buying guidance for Used car</option>
                            <option value="Expert Talk" {{ old('selected_service') == 'Expert Talk' ? 'selected' : '' }}>Talk to an Expert About Your Shortlisted Cars</option>
                            <option value="Repair Second Opinion" {{ old('selected_service') == 'Repair Second Opinion' ? 'selected' : '' }}>Second opinion on repairs & estimates</option>
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-12 mb-4">
                    <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}" data-theme="dark"></div>
                    @error('cf-turnstile-response')
                        <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="alert alert-light small p-2 px-3 w-fit d-block mb-4" data-bs-theme="dark">
                Pay <strong>₹499</strong> to register.
            </div>

            <div class="text-center mt-3">
                <button type="submit" class="btn-default">One Call. Clear Answers.</button>
            </div>
        </form>
    </div>
</div>