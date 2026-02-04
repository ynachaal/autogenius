@extends('layouts.front')
@section('content')
    <div class="page-header bg-section parallaxie1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Page Header Box Start -->
                    <div class="page-header-box">
                        <h1 class="text-anime-style-3" data-cursor="-opaque" aria-label="Smart Car Requirement" style="perspective: 400px;">Smart Car Requirement</h1>
                    </div>
                    <!-- Page Header Box End -->
                </div>
            </div>
        </div>
    </div>
    <style>
        .step { display:none; }
        .step.active { display:block; }
        .step-indicator {
            font-size:14px;
            color:#888;
            margin-bottom:20px;
        }
    </style>
    <section class="page-contact-us">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <div class="contact-form">
                        <div class="contact-form-title">
                            <h3 class="text-anime-style-3 text-center mb-3" data-cursor="-opaque" style="perspective: 400px;">Car Buying Consultation</h3>
                        </div>
                        <form id="carForm">
                            <!-- ================= STEP 1 ================= -->
                            <div class="step active" data-step="1">
                                <div class="section-title mb-3 text-center">
                                    <h3 class="wow fadeInUp">Get Started</h3>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                            <input required placeholder="Full Name" name="name" id="name" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label for="mobile" class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                            <input required placeholder="Mobile Number" name="mobile" id="mobile" type="tel" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-4">
                                            <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                                            <input required placeholder="City" name="city" id="city" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <p class="fw-normal">Service Required <span class="text-danger">*</span></p>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="service" id="1new" value="new" required>
                                                <label class="form-check-label" for="1new">New Car Consultation</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="service" id="2pre" value="inspection">
                                                <label class="form-check-label" for="2pre">Pre-Owned Car Inspection</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="service" value="testing" id="3pre">
                                                <label class="form-check-label" for="3pre">Pre-Owned Car Consultation & Unlimited Testing</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="4pre" name="service" value="selling">
                                                <label class="form-check-label" for="4pre">Pre-Owned Car Certification & Selling</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <p class="fw-normal">Preferred Contact <span class="text-danger">*</span></p>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="contact" id="whatsapp" value="whatsapp" required>
                                                <label class="form-check-label" for="whatsapp">WhatsApp</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="contact" value="call" id="Call">
                                                <label class="form-check-label" for="Call">Call</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn-default text-center mx-auto w-fit next">Continue <i class="fa-solid fa-arrow-right"></i></button>
                            </div>
                            <!-- ================= STEP 2 ================= -->
                            <div class="step" data-step="2">
                                <div class="section-title mb-3 text-center">
                                    <h3 class="wow fadeInUp">Your Budget & Ownership Plan</h3>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="budget" class="form-label">Budget <span class="text-danger">*</span></label>
                                    <input required type="number" name="budget" id="budget" placeholder="₹ e.g. 10,00,000" class="form-control">
                                </div>
                                <div class="form-group mb-4">
                                    <label for="stretch_budget" class="form-label">Max Stretch Budget (Optional)</label>
                                    <input type="number" name="stretch_budget" placeholder="₹ only if right car found" class="form-control">
                                </div>
                                <div class="form-group mb-4">
                                    <label for="ownership" class="form-label">Expected Ownership Period <span class="text-danger">*</span></label>
                                    <select required name="ownership" id="ownership" class="form-select">
                                        <option value="">Please Select</option>
                                        <option>Less than 2 years</option>
                                        <option>3–5 years</option>
                                        <option>More than 5 years</option>
                                    </select>
                                </div>
                                <div class="d-flex justify-content-between align-content-center">
                                    <button class="btn-primary w-fit prev"><i class="fa-solid fa-arrow-left"></i> Back</button>
                                    <button class="btn-default text-center w-fit next">Continue <i class="fa-solid fa-arrow-right"></i></button>
                                </div>
                            </div>
                            <!-- ================= STEP 3 ================= -->
                            <div class="step" data-step="3">
                                <div class="section-title mb-3 text-center">
                                    <h3 class="wow fadeInUp">How Will You Use the Car?</h3>
                                </div>
                                <div class="form-group mb-4">
                                    <p class="fw-normal">Primary Usage</p>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="usage" id="city1" value="city" required>
                                        <label class="form-check-label" for="city1">City <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="usage" value="highway" id="highway">
                                        <label class="form-check-label" for="highway">Highway <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="usage" value="mixed" id="mixed">
                                        <label class="form-check-label" for="mixed">Mixed <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <p class="form-label">Running Pattern <span class="text-danger">*</span></p>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="running_pattern" value="daily" id="daily" required>
                                        <label class="form-check-label" for="daily">Everyday</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="running_pattern" value="monthly" id="monthly">
                                        <label class="form-check-label" for="monthly">Monthly</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="running_pattern" value="yearly" id="yearly">
                                        <label class="form-check-label" for="yearly">Yearly</label>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="running_km" class="form-label">Approx KM</label>
                                    <input type="number" name="running_km" id="running_km" placeholder="km/day / km/month / km/year" class="form-control">
                                </div>
                                <div class="form-group mb-4">
                                    <p class="form-label">No. of Passengers Usually</p>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="passengers_usually" value="1-2" id="1-2">
                                        <label class="form-check-label" for="1-2">1-2</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="passengers_usually" value="3–4" id="3–4">
                                        <label class="form-check-label" for="3–4">3–4</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="passengers_usually" value="5+" id="5+">
                                        <label class="form-check-label" for="5+">5+</label>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-content-center">
                                    <button class="btn-primary w-fit prev"><i class="fa-solid fa-arrow-left"></i> Back</button>
                                    <button class="btn-default text-center w-fit next">Continue <i class="fa-solid fa-arrow-right"></i></button>
                                </div>
                            </div>
                            <!-- ================= STEP 4 ================= -->
                            <div class="step" data-step="4">
                                <div class="section-title mb-3 text-center">
                                    <h3 class="wow fadeInUp">Your Preferences</h3>
                                </div>
                                <div class="form-group mb-4">
                                    <p class="fw-normal">Preferred Body Type</p>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="body_type" value="Hatchback" id="Hatchback">
                                        <label class="form-check-label" for="Hatchback">Hatchback</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="body_type" value="Sedan" id="Sedan">
                                        <label class="form-check-label" for="Sedan">Sedan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="body_type" value="Compact SUV" id="compact_suv">
                                        <label class="form-check-label" for="compact_suv">Compact SUV</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="body_type" value="suv_muv" id="suv_muv">
                                        <label class="form-check-label" for="suv_muv">SUV / MUV</label>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <p class="fw-normal">Fuel Preference</p>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="fuel[]" value="Petrol" id="Petrol">
                                        <label class="form-check-label" for="Petrol">Petrol</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="fuel[]" value="Diesel" id="Diesel">
                                        <label class="form-check-label" for="Diesel">Diesel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="fuel[]" value="CNG" id="CNG">
                                        <label class="form-check-label" for="CNG">CNG</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="fuel[]" value="Electric" id="Electric">
                                        <label class="form-check-label" for="Electric">Electric</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="fuel[]" value="Hybrid" id="Hybrid">
                                        <label class="form-check-label" for="Hybrid">Hybrid</label>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <p class="fw-normal">Gearbox Preference</p>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gearbox_preference" value="Manual" id="Manual">
                                        <label class="form-check-label" for="Manual">Manual</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gearbox_preference" value="Automatic" id="Automatic">
                                        <label class="form-check-label" for="Automatic">Automatic</label>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <p class="fw-normal">Ride Comfort Priority</p>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="comfort_priority" value="Comfort" id="Comfort">
                                        <label class="form-check-label" for="Comfort">Comfort</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="comfort_priority" value="Balanced" id="Balanced">
                                        <label class="form-check-label" for="Balanced">Balanced</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="comfort_priority" value="Performance" id="Performance">
                                        <label class="form-check-label" for="Performance">Performance</label>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <p class="fw-normal">Feature Priority</p>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="feature_priority" value="Safety" id="Safety">
                                        <label class="form-check-label" for="Safety">Safety</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="feature_priority" value="Comfort" id="Comfort">
                                        <label class="form-check-label" for="Comfort">Comfort</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="feature_priority" value="Technology" id="Technology">
                                        <label class="form-check-label" for="Technology">Technology</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="feature_priority" value="Performance" id="Performance">
                                        <label class="form-check-label" for="Performance">Performance</label>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <p class="fw-normal">Noise Sensitivity</p>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="feature_priority" value="Important" id="Important">
                                        <label class="form-check-label" for="Important">Important</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="feature_priority" value="Not Important" id="Not-Important">
                                        <label class="form-check-label" for="Not-Important">Not Important</label>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <p class="fw-normal">Noise Sensitivity</p>
                                    <div class="form-group">
                                        <label class="form-label" for="Colour">Colour Preference <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="Colour" id="Colour" placeholder="Colour Preference">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-content-center">
                                    <button class="btn-primary w-fit prev"><i class="fa-solid fa-arrow-left"></i> Back</button>
                                    <button class="btn-default text-center w-fit next">Continue <i class="fa-solid fa-arrow-right"></i></button>
                                </div>
                            </div>
                            <!-- ================= STEP 5 (Conditional) ================= -->
                            <div class="step" data-step="5" id="preOwnedStep">
                                <div class="section-title mb-3 text-center">
                                    <h3 class="wow fadeInUp">Pre-Owned Car Preferences</h3>
                                </div>
                                <div class="form-group mb-4">
                                    <p class="fw-normal">Max Acceptable Owners</p>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="max_acceptable" value="1max" id="m1">
                                        <label class="form-check-label" for="m1">1st Owner</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="max_acceptable" value="2max" id="m2">
                                        <label class="form-check-label" for="m2">2nd Owner</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="max_acceptable" value="any" id="any">
                                        <label class="form-check-label" for="any">Any</label>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <p class="fw-normal">Accident History Preference</p>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="History" value="1" id="zero">
                                        <label class="form-check-label" for="zero">Zero Tolerance</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="History" value="2" id="Minor">
                                        <label class="form-check-label" for="Minor">Minor Acceptable</label>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <p class="fw-normal">Insurance Preference</p>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="Preference" value="Comprehensive" id="Comprehensive">
                                        <label class="form-check-label" for="Comprehensive">Comprehensive</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="Preference" value="Third-party" id="Third-party">
                                        <label class="form-check-label" for="Third-party">Third-party acceptable</label>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <p class="fw-normal">Purchase Timeline</p>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="Purchase" value="Immediate" id="Immediate">
                                        <label class="form-check-label" for="Immediate">Immediate (0–7 days)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="Purchase" value="weeks" id="weeks">
                                        <label class="form-check-label" for="weeks">2–4 weeks</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="Purchase" value="months" id="months">
                                        <label class="form-check-label" for="months">1–3 months</label>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-content-center">
                                    <button class="btn-primary w-fit prev"><i class="fa-solid fa-arrow-left"></i> Back</button>
                                    <button class="btn-default text-center w-fit next">Continue <i class="fa-solid fa-arrow-right"></i></button>
                                </div>
                            </div>
                            <!-- ================= STEP 6 ================= -->
                            <div class="step" data-step="6">
                                <div class="section-title mb-3 text-center">
                                    <h3 class="wow fadeInUp">Final Details</h3>
                                </div>
                                <div class="form-group mb-4">
                                    <p class="fw-normal">Decision Maker</p>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="Decision" value="Self" id="Self">
                                        <label class="form-check-label" for="Self">Self</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="Decision" value="Family" id="Family">
                                        <label class="form-check-label" for="Family">Family</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="Decision" value="Company" id="Company">
                                        <label class="form-check-label" for="Company">Company</label>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="Existing">Existing Car Owned (if any) <span class="text-danger">*</span></label>
                                    <input class="form-control" id="Existing" name="Existing" placeholder="Existing Car Owned (if any)*">
                                </div>
                                <div class="form-group mb-4">
                                    <label for="Reason" class="form-label">Reason for Upgrade / Change</label>
                                    <textarea id="Reason" placeholder="Reason for Upgrade / Change" class="form-control"></textarea>
                                </div>
                                <div class="form-check mb-4">
                                    <input required type="checkbox" class="form-check-input" id="confirm">
                                    <label class="form-check-label" for="confirm">I confirm details are correct</label>
                                </div>
                                <div class="d-flex justify-content-between align-content-center">
                                    <button class="btn-primary w-fit prev"><i class="fa-solid fa-arrow-left"></i> Back</button>
                                    <button type="submit" class="btn-default text-center w-fit next">Submit & Get Expert Call</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="book-appointment-image wow fadeInUp">
                        <div class="book-appointment-img">
                            <figure>
                                <img src="{{ asset('images/book-appointment-image.jpg') }}" class="img-fluid" alt="">
                            </figure>
                        </div>
                        <div class="customer-services-box">
                            <div class="customer-services-item">
                                <div class="customer-services-item-header">
                                    <div class="customer-services-header-title">
                                        <h3>Working Hours</h3>
                                    </div>
                                </div>
                                <div class="customer-services-item-body">
                                    <ul>
                                        <li>Mon - Sat: <span>8 AM -7 PM</span></li>
                                        <li>Sunday: <span>Closed</span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="customer-services-item">
                                <div class="customer-services-item-header">
                                    <div class="customer-services-header-title">
                                        <h3>Customer Service</h3>
                                    </div>
                                </div>
                                <div class="customer-services-item-body">
                                    <ul>
                                        <li><i class="fa-solid fa-phone"></i> <span><a href="tel:+123456789">(+123) 456 789</a></span></li>
                                        <li><i class="fa-solid fa-envelope"></i> <span><a href="mailto:support@domain.com">support@domain.com</a></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        let current = 1;

        function showStep(step){
            $(".step").removeClass("active");
            $('.step[data-step="'+step+'"]').addClass("active");
            current = step;
        }

        /* NEXT BUTTON */
        $(".next").click(function(){

            // validation
            let valid = true;
            $('.step[data-step="'+current+'"] [required]').each(function(){
                if(!this.value) valid = false;
            });

            if(!valid){
                alert("Please fill required fields");
                return;
            }

            /* STEP 1 SAVE LEAD */
            if(current === 1){
                $.post("save-lead.php", $("#carForm").serialize());
            }

            /* skip preowned step if new car */
            if(current === 4){
                let service = $("input[name=service]:checked").val();
                if(service === "new"){
                    showStep(6);
                    return;
                }
            }

            showStep(current+1);
        });

        /* PREV */
        $(".prev").click(function(){
            showStep(current-1);
        });

        /* FINAL SUBMIT */
        $("#carForm").submit(function(e){
            e.preventDefault();

            $.post("submit-form.php", $(this).serialize(), function(){
                window.location.href="/";
            });
        });
    </script>

@endsection
