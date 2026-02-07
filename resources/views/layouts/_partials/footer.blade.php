@php
    $footerMenus = include resource_path('views/layouts/_menus/footer-menus.php');
@endphp
<footer class="main-footer bg-section mx-0 w-100">
    <div class="footer-header-prime">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-8">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <h2 class="text-anime-style-3" data-cursor="-opaque">{{config('settings.footer_heading', '') }}
                        </h2>
                        <p>{{ config('settings.footer_subheading', '') }}</p>
                    </div>
                    <!-- Section Title End -->
                </div>

                <div class="col-xl-4">
                    <!-- Footer Newsletter Form Start -->
                    <div class="footer-newsletter-form-prime">
                        <div class="section-title">
                            <p class="text-anime-style-3 h5 mb-4 fw-normal" data-cursor="-opaque">
                                {{config('settings.footer_contactheading', '') }}
                            </p>
                        </div>
                        <a href="tel:{{config('settings.phone', '') }}" class="btn-default"><i
                                class="fa-solid fa-phone"></i> {{config('settings.phone', '') }}</a>
                    </div>
                    <!-- Footer Newsletter Form End -->
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row gy-lg-3 gy-4">
            <div class="col-xl-3 col-lg-12 col-md-12">
                <!-- About Footer Start -->
                <div class="about-footer">
                    <!-- Footer Logo Start -->
                    <div class="footer-logo">
                        <img src="{{ url(config('settings.site_logo')) }}" alt="" style="filter: invert(1);">
                    </div>
                    <!-- Footer Logo End -->

                    <!-- About Footer Content Start -->
                    <div class="about-footer-content">
                        <p>{{ config('settings.footer_about', '') }}</p>
                    </div>
                    <!-- About Footer Content End -->

                    <!-- Footer Social Link Start -->
                    <div class="footer-social-links">
                        <ul>
                            <li><a href="{{ config('settings.facebook_url', '') }}" target="_blank"><i
                                        class="fa-brands fa-facebook-f"></i></a></li>
                            <li><a href="{{ config('settings.instagram_url', '') }}" target="_blank"><i
                                        class="fa-brands fa-instagram"></i></a></li>
                            <li><a href="https://api.whatsapp.com/send?phone=91{{ str_replace(' ', '', config('settings.phone', '')) }}"
                                    target="_blank"><i class="fa-brands fa-whatsapp"></i></a></li>
                        </ul>
                    </div>
                    <!-- Footer Social Link End -->
                </div>
                <!-- About Footer End -->
            </div>

            <div class="col-xl-5 col-lg-8 col-md-8">
                <!-- Footer Links Box Start -->
                <div class="footer-links-box">
                    <!-- Footer Links Start -->
                    <div class="footer-links">
                        <h3>Quick Link</h3>
                        <ul>
                            @foreach ($footerMenus as $menu)
                                <li>
                                    <a href="{{ $menu['route'] ?? 'javascript:void(0)' }}"
                                        target="{{ $menu['target'] ?? '_self' }}">
                                        {{ $menu['title'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                    <!-- Footer Links End -->


                    <!-- Footer Services Start -->
                    <div class="footer-links">
                        <h3>Services</h3>
                        @php
                            $services = [
                                ['title' => 'New Car Consultation', 'slug' => 'new-car-consultation'],
                                ['title' => 'Used Car Consultation & Unlimited Inspections', 'slug' => 'used-car-consultation-and-unlimited-inspections'],
                                ['title' => 'Sell Your Car with AutoGenius', 'slug' => 'sell-your-car-with-autogenius'],
                                ['title' => 'New Car PDI', 'slug' => 'new-car-pdi'],
                                ['title' => 'Used Car Inspection', 'slug' => 'used-car-inspection'],
                                ['title' => 'Premium & Luxury Car Inspection', 'slug' => 'premium-luxury-car-inspection'],
                                ['title' => 'Get Your Own Car Inspected', 'slug' => 'get-your-own-car-inspected'],
                                ['title' => 'Get Service History & Insurance Claim Details', 'slug' => 'get-service-history-and-insurance-claim-details'],
                                ['title' => 'On Call Consultation', 'slug' => 'on-call-consultation'],
                                ['title' => 'Insurance With AutoGenius', 'slug' => 'insurance-with-autogenius'],
                            ];
                        @endphp

                        <ul>
                            @foreach($services as $service)
                                <li>
                                    <a href="{{ route('services.show', $service['slug']) }}">
                                        {{ $service['title'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>


                    </div>
                    <!-- Footer Services End -->

                    <!-- Footer Links End -->
                </div>
                <!-- Footer Links Box End -->
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4">
                <!-- Footer Links Start -->
                <div class="footer-links footer-contact-links w-100 mw-100">
                    <h3>Get in Touch</h3>
                    <!-- Footer Contact Item Start -->
                    <div class="footer-contact-item">
                        <div class="icon-box">
                            <img src="{{ asset('images/icon-headphone-accent.svg') }}" alt="">
                        </div>
                        <div class="footer-contact-content">
                            <p><a href="tel:{{ config('settings.phone', '') }}">{{ config('settings.phone', '') }}</a>
                            </p>
                            <p><a
                                    href="mailto:{{ config('settings.contact_email', '') }}">{{ config('settings.contact_email', '') }}</a>
                            </p>
                        </div>
                    </div>
                    <!-- Footer Contact Item End -->

                    <!-- Footer Contact Item Start -->
                    <div class="footer-contact-item">
                        <div class="icon-box">
                            <img src="{{ asset('images/icon-location-accent.svg') }}" alt="">
                        </div>
                        <div class="footer-contact-content">
                            <p>{{ config('settings.address', '') }}</p>
                        </div>
                    </div>
                    <!-- Footer Contact Item End -->
                </div>
                <!-- Footer Links End -->
            </div>


            <div class="col-lg-12">
                <!-- Footer Copyright Text Start -->
                <div class="footer-copyright-text">
                    <p>Copyright © {{ now()->year }} {{ config('settings.footer_text', '') }}</p>
                </div>
                <!-- Footer Copyright Text End -->
            </div>
        </div>
    </div>
</footer>
<!-- Footer End -->
<a class="whatsapp_float" target="_blank"
    href="https://wa.me/+91{{ str_replace(' ', '', config('settings.phone', '')) }}?text=Hi%20AutoGenius%2C%0AI%27d%20like%20expert%20guidance%20regarding%20a%20car.">
    <span><i class="fa-brands fa-whatsapp"></i> Speak with an AutoGenius Expert</span>
</a>