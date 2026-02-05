@extends('layouts.front')
@section('content')
    <div class="page-header bg-section parallaxie1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Page Header Box Start -->
                    <div class="page-header-box">
                        <h1 class="text-anime-style-3" data-cursor="-opaque" aria-label="Smart Car Requirement"
                            style="perspective: 400px;">Smart Car Requirement</h1>
                    </div>
                    <!-- Page Header Box End -->
                </div>
            </div>
        </div>
    </div>
    <style>
        .step {
            display: none;
        }

        .step.active {
            display: block;
        }

        .step-indicator {
            font-size: 14px;
            color: #888;
            margin-bottom: 20px;
        }
    </style>
    <section class="page-contact-us">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <div class="contact-form">
                        <div class="contact-form-title">
                            <h3 class="text-anime-style-3 text-center mb-3" data-cursor="-opaque"
                                style="perspective: 400px;">Car Buying Consultation</h3>
                        </div>
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form id="carForm" action="{{ route('lead.store') }}" method="POST">
                            @csrf
                            <!-- ================= STEP 1 ================= -->
                            <div class="step active" data-step="1">
                                <div class="section-title mb-3 text-center">
                                    <h3 class="wow fadeInUp">Get Started</h3>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label for="name" class="form-label">Full Name <span
                                                    class="text-danger">*</span></label>
                                            <input value="{{ old('name') }}" required placeholder="Full Name" name="name"
                                                id="name" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label for="mobile" class="form-label">Mobile Number <span
                                                    class="text-danger">*</span></label>
                                            <input value="{{ old('mobile') }}" required placeholder="Mobile Number"
                                                name="mobile" id="phone" type="tel" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-4">
                                            <label for="city" class="form-label">City <span
                                                    class="text-danger">*</span></label>
                                            <input value="{{ old('city') }}" required placeholder="City" name="city"
                                                id="city" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <p class="fw-normal">Service Required <span class="text-danger">*</span></p>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="service" id="1new"
                                                    value="New Car Consultation" required {{ old('service', 'New Car Consultation') == 'New Car Consultation' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="1new">New Car Consultation</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="service" id="2pre"
                                                    value="Pre-Owned Car Inspection" {{ old('service') == 'Pre-Owned Car Inspection' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="2pre">Pre-Owned Car Inspection</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="service" value="testing"
                                                    id="3pre" {{ old('service') == 'Pre-Owned Car Consultation & Unlimited Testing' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="3pre">Pre-Owned Car Consultation &
                                                    Unlimited Testing</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="4pre" name="service"
                                                    value="Pre-Owned Car Certification &
                                                    Selling" {{ old('service') == 'Pre-Owned Car Certification & Selling' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="4pre">Pre-Owned Car Certification &
                                                    Selling</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <p class="fw-normal">Preferred Contact <span class="text-danger">*</span></p>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="contact" id="whatsapp"
                                                    value="Whatsapp" required {{ old('contact', 'Whatsapp') == 'Whatsapp' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="whatsapp">WhatsApp</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="contact" value="Call"
                                                    id="Call" {{ old('contact') == 'Call' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="Call">Call</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn-default text-center mx-auto w-fit next">Continue <i
                                        class="fa-solid fa-arrow-right"></i></button>
                            </div>
                            <!-- ================= STEP 2 ================= -->
                            <div class="step" data-step="2">
                                <div class="section-title mb-3 text-center">
                                    <h3 class="wow fadeInUp">Your Budget & Ownership Plan</h3>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="budget" class="form-label">Budget <span class="text-danger">*</span></label>
                                    <input required type="number" name="budget" id="budget" placeholder="₹ e.g. 10,00,000"
                                        class="form-control" value="{{ old('budget') }}">
                                </div>
                                <div class="form-group mb-4">
                                    <label for="stretch_budget" class="form-label">Max Stretch Budget (Optional)</label>
                                    <input type="number" value="{{ old('stretch_budget') }}" name="stretch_budget"
                                        placeholder="₹ only if right car found" class="form-control">
                                </div>
                                <div class="form-group mb-4">
                                    <label for="ownership" class="form-label">
                                        Expected Ownership Period <span class="text-danger">*</span>
                                    </label>
                                    <select required name="ownership" id="ownership" class="form-select">
                                        <option value="">Please Select</option>

                                        <option value="Less than 2 years" {{ old('ownership') == 'Less than 2 years' ? 'selected' : '' }}>
                                            Less than 2 years
                                        </option>

                                        <option value="3–5 years" {{ old('ownership') == '3–5 years' ? 'selected' : '' }}>
                                            3–5 years
                                        </option>

                                        <option value="More than 5 years" {{ old('ownership') == 'More than 5 years' ? 'selected' : '' }}>
                                            More than 5 years
                                        </option>
                                    </select>
                                </div>
                                <div class="d-flex justify-content-between align-content-center">
                                    <button class="btn-primary w-fit prev"><i class="fa-solid fa-arrow-left"></i>
                                        Back</button>
                                    <button class="btn-default text-center w-fit next">Continue <i
                                            class="fa-solid fa-arrow-right"></i></button>
                                </div>
                            </div>
                            <!-- ================= STEP 3 ================= -->
                            <div class="step" data-step="3">
                                <div class="section-title mb-3 text-center">
                                    <h3 class="wow fadeInUp">How Will You Use the Car?</h3>
                                </div>
                                <div class="form-group mb-4">
                                    <p class="fw-normal">Primary Usage  <span
                                                class="text-danger">*</span></p>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="usage" id="city1" value="City"
                                            required {{ old('usage', 'City') == 'City' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="city1">City </label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="usage" value="Highway"
                                            id="highway" {{ old('usage') == 'Highway' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="highway">Highway </label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="usage" value="Mixed" id="mixed"
                                            {{ old('usage') == 'Mixed' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="mixed">Mixed</label>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <p class="form-label">Running Pattern <span class="text-danger">*</span></p>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="running_pattern" value="Everyday"
                                            id="daily" required {{ old('running_pattern', 'Everyday') == 'Everyday' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="daily">Everyday</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="running_pattern" value="Monthly"
                                            id="monthly" {{ old('running_pattern') == 'Monthly' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="monthly">Monthly</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="running_pattern" value="Yearly"
                                            id="yearly" {{ old('running_pattern') == 'Yearly' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="yearly">Yearly</label>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="running_km" class="form-label">Approx KM</label>
                                    <input type="number" name="running_km" id="running_km"
                                        placeholder="km/day / km/month / km/year" class="form-control"
                                        value="{{ old('running_km') }}">
                                </div>
                                <div class="form-group mb-4">
                                    <p class="form-label">No. of Passengers Usually</p>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="passengers_usually" value="1-2"
                                            id="1-2" {{ old('passengers_usually', '1-2') == '1-2' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="1-2">1-2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="passengers_usually" value="3–4"
                                            id="3–4" {{ old('passengers_usually') == '3–4' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="3–4">3–4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="passengers_usually" value="5+"
                                            id="5+" {{ old('passengers_usually') == '5+' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="5+">5+</label>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-content-center">
                                    <button class="btn-primary w-fit prev"><i class="fa-solid fa-arrow-left"></i>
                                        Back</button>
                                    <button class="btn-default text-center w-fit next">Continue <i
                                            class="fa-solid fa-arrow-right"></i></button>
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
                                    <input class="form-check-input" type="checkbox" name="body_type[]" value="Hatchback"
                                        id="Hatchback"
                                        {{ (is_array(old('body_type')) && in_array('Hatchback', old('body_type'))) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Hatchback">Hatchback</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="body_type[]" value="Sedan"
                                        id="Sedan"
                                        {{ (is_array(old('body_type')) && in_array('Sedan', old('body_type'))) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Sedan">Sedan</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="body_type[]" value="Compact SUV"
                                        id="compact_suv"
                                        {{ (is_array(old('body_type')) && in_array('Compact SUV', old('body_type'))) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="compact_suv">Compact SUV</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="body_type[]" value="SUV / MUV"
                                        id="suv_muv"
                                        {{ (is_array(old('body_type')) && in_array('SUV / MUV', old('body_type'))) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="suv_muv">SUV / MUV</label>
                                </div>
                            </div>
                               <div class="form-group mb-4">
                                <p class="fw-normal">Fuel Preference</p>
                                
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="fuel[]" value="Petrol"
                                        id="Petrol"
                                        {{ (is_array(old('fuel')) && in_array('Petrol', old('fuel'))) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Petrol">Petrol</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="fuel[]" value="Diesel"
                                        id="Diesel"
                                        {{ (is_array(old('fuel')) && in_array('Diesel', old('fuel'))) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Diesel">Diesel</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="fuel[]" value="CNG" 
                                        id="CNG"
                                        {{ (is_array(old('fuel')) && in_array('CNG', old('fuel'))) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="CNG">CNG</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="fuel[]" value="Electric"
                                        id="Electric"
                                        {{ (is_array(old('fuel')) && in_array('Electric', old('fuel'))) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Electric">Electric</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="fuel[]" value="Hybrid"
                                        id="Hybrid"
                                        {{ (is_array(old('fuel')) && in_array('Hybrid', old('fuel'))) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Hybrid">Hybrid</label>
                                </div>
                            </div>
                                <div class="form-group mb-4">
                                    <p class="fw-normal">Gearbox Preference</p>
                                    
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gearbox_preference"
                                            value="Manual" id="Manual"
                                            {{ old('gearbox_preference') == 'Manual' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="Manual">Manual</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gearbox_preference"
                                            value="Automatic" id="Automatic"
                                            {{ old('gearbox_preference') == 'Automatic' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="Automatic">Automatic</label>
                                    </div>
                                </div>
                                                            <div class="form-group mb-4">
                                    <p class="fw-normal">Ride Comfort Priority</p>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="comfort_priority" value="Comfort"
                                            id="Comfort" {{ old('comfort_priority') == 'Comfort' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="Comfort">Comfort</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="comfort_priority"
                                            value="Balanced" id="Balanced" {{ old('comfort_priority') == 'Balanced' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="Balanced">Balanced</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="comfort_priority"
                                            value="Performance" id="Performance" {{ old('comfort_priority') == 'Performance' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="Performance">Performance</label>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <p class="fw-normal">Feature Priority</p>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="feature_priority[]"
                                            value="Safety" id="Safety" 
                                            {{ (is_array(old('feature_priority')) && in_array('Safety', old('feature_priority'))) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="Safety">Safety</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="feature_priority[]"
                                            value="Comfort" id="ComfortFeature" 
                                            {{ (is_array(old('feature_priority')) && in_array('Comfort', old('feature_priority'))) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ComfortFeature">Comfort</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="feature_priority[]"
                                            value="Technology" id="Technology" 
                                            {{ (is_array(old('feature_priority')) && in_array('Technology', old('feature_priority'))) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="Technology">Technology</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="feature_priority[]"
                                            value="Performance" id="PerformanceFeature" 
                                            {{ (is_array(old('feature_priority')) && in_array('Performance', old('feature_priority'))) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="PerformanceFeature">Performance</label>
                                    </div>
                                </div>
                                 <div class="form-group mb-4">
                                    <p class="fw-normal">Noise Sensitivity</p>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="noise_sensitivity"
                                            value="Important" id="Important"
                                            {{ old('noise_sensitivity') == 'Important' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="Important">Important</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="noise_sensitivity"
                                            value="Not Important" id="Not-Important"
                                            {{ old('noise_sensitivity') == 'Not Important' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="Not-Important">Not Important</label>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label" for="Colour">Colour Preference </label>
                                    <input class="form-control" type="text" name="Colour" id="Colour"
                                        placeholder="Colour Preference"
                                        value="{{ old('Colour') }}">
                                </div>
                                <div class="d-flex justify-content-between align-content-center">
                                    <button class="btn-primary w-fit prev"><i class="fa-solid fa-arrow-left"></i>
                                        Back</button>
                                    <button class="btn-default text-center w-fit next">Continue <i
                                            class="fa-solid fa-arrow-right"></i></button>
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
                                    <input class="form-check-input" type="radio" name="max_acceptable" value="1st Owner" id="m1"
                                        {{ old('max_acceptable') == '1st Owner' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="m1">1st Owner</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="max_acceptable" value="2nd Owner" id="m2"
                                        {{ old('max_acceptable') == '2nd Owner' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="m2">2nd Owner</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="max_acceptable" value="Any" id="any"
                                        {{ old('max_acceptable') == 'Any' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="any">Any</label>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <p class="fw-normal">Accident History Preference</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="History" value="Zero Tolerance" id="zero"
                                        {{ old('History') == 'Zero Tolerance' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="zero">Zero Tolerance</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="History" value="Minor Acceptable" id="Minor"
                                        {{ old('History') == 'Minor Acceptable' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Minor">Minor Acceptable</label>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <p class="fw-normal">Insurance Preference</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="Preference" value="Comprehensive" id="Comprehensive"
                                        {{ old('Preference') == 'Comprehensive' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Comprehensive">Comprehensive</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="Preference" value="Third-party" id="Third-party"
                                        {{ old('Preference') == 'Third-party' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Third-party">Third-party acceptable</label>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <p class="fw-normal">Purchase Timeline</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="Purchase" value="Immediate (0–7 days)" id="Immediate"
                                        {{ old('Purchase') == 'Immediate (0–7 days)' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Immediate">Immediate (0–7 days)</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="Purchase" value="2–4 weeks" id="weeks"
                                        {{ old('Purchase') == '2–4 weeksweeks' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="weeks">2–4 weeks</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="Purchase" value="1–3 months" id="months"
                                        {{ old('Purchase') == '1–3 months' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="months">1–3 months</label>
                                </div>
                            </div>
                                <div class="d-flex justify-content-between align-content-center">
                                    <button class="btn-primary w-fit prev"><i class="fa-solid fa-arrow-left"></i>
                                        Back</button>
                                    <button class="btn-default text-center w-fit next">Continue <i
                                            class="fa-solid fa-arrow-right"></i></button>
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
                                    <input class="form-check-input" type="radio" name="Decision" value="Self" id="Self"
                                        {{ old('Decision', 'Self') == 'Self' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Self">Self</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="Decision" value="Family" id="Family"
                                        {{ old('Decision') == 'Family' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Family">Family</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="Decision" value="Company" id="Company"
                                        {{ old('Decision') == 'Company' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Company">Company</label>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="Existing">Existing Car Owned (if any) </label>
                                <input class="form-control" id="Existing" name="Existing"
                                    placeholder="Existing Car Owned (if any)"
                                    value="{{ old('Existing') }}">
                            </div>

                            <div class="form-group mb-4">
                                <label for="Reason" class="form-label">Reason for Upgrade / Change</label>
                                <textarea id="Reason" name="Reason" placeholder="Reason for Upgrade / Change"
                                        class="form-control">{{ old('Reason') }}</textarea>
                            </div>

                            <div class="form-check mb-4">
                                <input required type="checkbox" class="form-check-input" name="confirm" id="confirm"
                                    {{ old('confirm') ? 'checked' : '' }}>
                                <label class="form-check-label" for="confirm">I confirm details are correct</label>
                            </div>
                             <div class="form-group col-md-12 mb-4">
                                    <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}" data-theme="dark"></div>
                                    @error('cf-turnstile-response')
                                        <div class="text-danger mt-1 small">{{ $message }}</div>
                                    @enderror
                                    <div id="turnstile-error" class="text-danger mt-1 small" style="display:none;">Please verify that you are not a robot.</div>
                                </div>
                                <div class="d-flex justify-content-between align-content-center">
                                    <button class="btn-primary w-fit prev"><i class="fa-solid fa-arrow-left"></i>
                                        Back</button>
                                    <button type="submit" class="btn btn-primary">Submit & Get Expert</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="book-appointment-image wow fadeInUp">
                        <div class="book-appointment-img">
                            <figure> 
                                <img src="{{config('settings.smart_car_requirement_image', '') }}" class="img-fluid" alt="">
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
                                        <li>Mon - Sat:  {{config('settings.open_hours_mon_sat', '') }}</li>
                                        <li>Sunday: {{config('settings.open_hours_sun', '') }}</li>
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
                                        <li><i class="fa-solid fa-phone"></i> <span><a href="tel:{{config('settings.phone', '') }}">{{config('settings.phone', '') }}</a></span></li>
                                        <li><i class="fa-solid fa-envelope"></i> <span><a
                                                    href="mailto:{{ config('settings.contact_email', '') }}">{{ config('settings.contact_email', '') }}</a></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')

        <script>

            $(document).ready(function () {
                function updateRunningPlaceholder() {
        let pattern = $('input[name="running_pattern"]:checked').val();
        let placeholderText = "km";

        switch(pattern) {
            case 'Everyday': // Handling both potential values
                placeholderText = "km/day";
                break;
            case 'Monthly':
                placeholderText = "km/month";
                break;
            case 'Yearly':
                placeholderText = "km/year";
                break;
            default:
                placeholderText = "km";
        }

        $('input[name="running_km"]').attr('placeholder', placeholderText);
    }

    // 1. Trigger on Change
    $('input[name="running_pattern"]').on('change', function() {
        updateRunningPlaceholder();
    });

    // 2. Trigger on Page Load (to handle "old" or pre-filled values)
    updateRunningPlaceholder();
                let currentStepNum = 1;

                // 1. Initialize jQuery Validation
                var validator = $("#carForm").validate({
                    errorElement: 'span',
                    errorClass: 'text-danger small',
                    highlight: function (element) { $(element).addClass('is-invalid'); },
                    unhighlight: function (element) { $(element).removeClass('is-invalid'); },
                    rules: {
                        name: { required: true, minlength: 3 },
                        mobile: { required: true, minlength: 7, maxlength: 20 },
                        city: "required",
                        service: "required",
                        contact: "required",
                        budget: { required: true, min: 100000 },
                        ownership: "required",
                        usage: "required",
                        running_pattern: "required",
                        //Colour: "required",
                       // Existing: "required",
                        confirm: "required"
                    },
                    errorPlacement: function (error, element) {
                        if (element.attr("type") == "radio" || element.attr("type") == "checkbox") {
                            error.appendTo(element.closest(".form-group"));
                        } else {
                            error.insertAfter(element);
                        }
                    },
                     submitHandler: function (form) {
                    // Check for Turnstile token before submitting
                   /*  const turnstileResponse = $('[name="cf-turnstile-response"]').val();
                    if (!turnstileResponse) {
                        $('#turnstile-error').show();
                        return false;
                    }
                    $('#turnstile-error').hide();
                    form.submit(); */
                     form.submit();
                }
                });

                // 2. Navigation Function
                function goToStep(step) {
                    $(".step").removeClass("active");
                    $('.step[data-step="' + step + '"]').addClass("active");
                    currentStepNum = step;
                    $(window).scrollTop($(".contact-form").offset().top - 100); // Smooth scroll to top of form
                }

                // 3. Next Button Logic
                $(".next").click(function (e) {
                    e.preventDefault();

                    // Validate ONLY the inputs in the current visible step
                    let fieldsInStep = $('.step[data-step="' + currentStepNum + '"]').find('input, select, textarea');
                    let stepIsValid = true;

                    fieldsInStep.each(function () {
                        if (!validator.element(this)) {
                            stepIsValid = false;
                        }
                    });

                    if (stepIsValid) {
                        // ACTION: Save Lead on Step 1 Completion
                        if (currentStepNum === 1) {
                            $.post("save-lead.php", $("#carForm").serialize());
                        }

                        // LOGIC: Skip Step 5 if "New Car" is selected
                        if (currentStepNum === 4) {
                            let service = $("input[name='service']:checked").val();
                            if (service === "New Car Consultation") {
                                goToStep(6);
                                return;
                            }
                        }

                        // Proceed to next step if not at the end
                        if (currentStepNum < 6) {
                            goToStep(currentStepNum + 1);
                        }
                    }
                });

                // 4. Back Button Logic
                $(".prev").click(function (e) {
                    e.preventDefault();

                    // LOGIC: If going back from Final Step and it was a New Car, jump to Step 4
                    if (currentStepNum === 6) {
                        let service = $("input[name='service']:checked").val();
                        if (service === "New Car Consultation") {
                            goToStep(4);
                            return;
                        }
                    }

                    if (currentStepNum > 1) {
                        goToStep(currentStepNum - 1);
                    }
                });

               
            });
        </script>
    @endpush
@endsection