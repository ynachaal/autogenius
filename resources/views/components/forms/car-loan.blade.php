<div>
    <div class="contact-form">
        <div class="contact-form-title">
            <h3 class="text-anime-style-3 text-center mb-3" data-cursor="-opaque" style="perspective: 400px;">
                Get a Car Loan - AutoGenius
            </h3>
            <p class="text-center mb-4">Our experts will call you within 24 hours.</p>
        </div>

        @if(session('success'))
            <div id="loan-success" class="alert alert-success alert-dismissible fade show" role="alert">
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

        <form id="carLoanForm" novalidate action="{{ route('loan.submit') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group mb-4">
                        <label class="form-label d-block">Select Loan Type <span class="text-danger">*</span></label>
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="loan_type" id="new_car" value="New Car Loan" checked>
                                <label class="form-check-label" for="new_car">New Car Loan</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="loan_type" id="used_car" value="Used Car Loan">
                                <label class="form-check-label" for="used_car">Used Car Loan</label>
                            </div>
                        </div>
                    </div>
                </div>

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
                        <input required type="text" name="customer_mobile" id="phone"
                            placeholder="Phone Number" class="form-control" value="{{ old('customer_mobile') }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="customer_email" class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input required type="email" name="customer_email" id="customer_email"
                            placeholder="email@example.com" class="form-control" value="{{ old('customer_email') }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                        <input required type="text" name="city" id="city" placeholder="Enter your city"
                            class="form-control" value="{{ old('city') }}">
                    </div>
                </div>

                <div class="form-group col-md-12 mb-4">
                    <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}" data-theme="dark"></div>
                    @error('cf-turnstile-response')
                        <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="text-center mt-3">
                  <button type="submit" class="btn-default">Submit</button>
            </div>
        </form>
    </div>
</div>