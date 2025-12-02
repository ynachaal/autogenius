
    <div class="container">
        <div class="footer-content">
            <div class="row gy-4">
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="footer-widget">
                        <div>
                            <a class="logo d-block mb-3" href="javascript:void(0)">Compass <span>&</span> Coin</a>
                        </div>
                        <p>{!! config('app.footer_about', '') !!}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-6">
                    <div class="footer-widget">
                        <h3>Quick Links</h3>
                        <ul class="list-unstyled">
                            <li>
                                <a href="javascript:void(0)">Buy Properties</a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">Sell Properties</a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">Rent Properties</a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">Off-Plan Projects</a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">About Us</a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">Contact Us</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-6">
                    <div class="footer-widget">
                        <h3>Dubai Areas</h3>
                        <ul class="list-unstyled">
                            <li>
                                <a href="javascript:void(0)">Dubai Marina</a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">Palm Jumeirah</a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">Downtown Dubai</a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">Dubai Hills Estate</a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">Jumeirah Village Circle</a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">Arabian Ranches</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h3>Contact Us</h3>
                        <ul class="list-unstyled contact_info">
                            <li>
                                <a href="javascript:void(0)"><i class="fa-solid fa-location-dot"></i> F-37, Ahmad Building, Hor Al Anz, Dubai</a>
                            </li>
                            <li>
                                <a href="tel:+971528426365"><i class="fa-solid fa-phone-flip"></i> +971 528426365</a>
                            </li>
                            <li>
                                <a href="mailto:info@compassandcoin.com"><i class="fa-solid fa-envelope"></i> info@compassandcoin.com</a>
                            </li>
                        </ul>
                    </div>
                    <div class="social-media">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a href="{{ config('settings.facebook_url', 'My Laravel App') }}"><i class="fa-brands fa-facebook-f"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="{{ config('settings.twitter_url', 'My Laravel App') }}"><i class="fa-brands fa-x-twitter"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="{{ config('settings.instagram_url', 'My Laravel App') }}"><i class="fa-brands fa-instagram"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="{{ config('settings.linkedin_url', 'My Laravel App') }}"><i class="fa-brands fa-linkedin-in"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <hr class="border-light">
    </div>
    <p class="copyright">&copy; {{ date('Y') }}  {{ config('settings.footer_text', 'My Laravel App') }}</p>

