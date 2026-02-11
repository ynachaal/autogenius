@extends('layouts.front')

@section('title', $page->meta_title ?? '')

@section('meta_description', $page->meta_description ?? '')
@section('meta_keywords', $page->meta_keywords ?? '')

@section('content')
<div class="our-approach bg-section about_section mt-5 mb-3">
    <div class="container">
        <div class="row align-items-center gy-4">
            <x-slider-carousel :sliders="$sliders" carousel-id="homeSlider" />
            <div class="col-xl-6">
                <div class="approach-content">
                    <div class="section-title mb-2">
                        <h3 class="wow fadeInUp">About AutoGenius</h3>
                    </div>
                    <p>AutoGenius was founded in 2016 with a clear mission — to help car buyers make confident, informed, and safe purchasing decisions.</p>
                    <p>In an industry where buyers often face hidden defects, unfair pricing, and misleading information, AutoGenius stands on the buyer’s side. We are an independent car consulting company, not connected to any dealer or seller. Our only priority is protecting your interest.</p>
                    <p>From new cars to pre-owned vehicles and premium automobiles, we provide expert inspections, accurate valuations, negotiation support, and complete car buying assistance. Every vehicle we inspect goes through a detailed technical and visual evaluation using professional tools, diagnostics, and real-world market knowledge.</p>
                    <p>What makes AutoGenius different is our end-to-end approach. We support you from the moment you shortlist a car until the day you take delivery. Our team ensures that the car you buy is genuine, mechanically sound, fairly priced, and free from hidden surprises.</p>
                    <p>Over the years, AutoGenius has earned the trust of thousands of customers across India. Our reputation is built on transparency, honesty, and consistent results.</p>
                    <p>We don’t sell cars.<br>We help you buy the right one — with confidence.</p>
                </div>
            </div>
        </div>
    </div>
</div>
    <section class="about-us bg-section principles mb-2r pt-5 pb-4">
        <div class="container">
            <div class="about-us-content">
                <div class="section-title">
                    <h2>Our Principles</h2>
                </div>
                <p>When AutoGenius was founded in 2016, we defined a simple set of principles that continue to guide every decision we make. These values shape how we work, how we serve customers, and how we build long-term trust.</p>
                <ol class="mb-0">
                    <li>
                        <strong>Every Buyer Deserves the Right Match</strong>
                        <p>We believe every car has a personality — and every buyer has unique needs. Our goal is not to sell what is popular, but to help you find what truly fits your lifestyle, usage, and expectations.</p>
                    </li>
                    <li>
                        <strong>Personalisation Comes First</strong>
                        <p>No two buyers are the same. That’s why we don’t follow generic advice or template recommendations. We listen, understand your priorities, and guide you with solutions tailored specifically to you.</p>
                    </li>
                    <li>
                        <strong>Real Experience Beats Online Opinions</strong>
                        <p>Buying a car shouldn’t be based only on reviews or social media opinions. We believe in real-world testing, real inspections, and hands-on evaluation — so you make decisions based on facts, not marketing.</p>
                    </li>
                    <li>
                        <strong>Good Is Never Enough</strong>
                        <p>We continuously push ourselves to improve. Whether it’s our inspection process, reporting quality, or customer experience — we always aim higher than industry standards.</p>
                    </li>
                    <li>
                        <strong>The Buyer Always Comes First</strong>
                        <p>Every car we inspect is treated as if we were buying it for ourselves. We step into the customer’s shoes, analyse every detail carefully, and always recommend what is best for you — not what benefits anyone else.</p>
                    </li>
                    <li>
                        <strong>Transparency Builds Trust</strong>
                        <p>We believe informed buyers make better decisions. That’s why we openly share details about vehicle condition, maintenance costs, ownership history, risks, and long-term ownership impact — without hiding uncomfortable truths.</p>
                    </li>
                    <li>
                        <strong>Deliver More Than Expected</strong>
                        <p>We follow the philosophy of giving more value than promised. Whether it’s extra checks, deeper analysis, or additional guidance — we strive to exceed expectations at every step.</p>
                    </li>
                    <li>
                        <strong>Ethics Over Short-Term Profit</strong>
                        <p>We strongly believe that honest work builds stronger brands. Long-term trust, reputation, and customer relationships matter more than quick profits. We choose what is right, even when it is not easy.</p>
                    </li>
                    <li>
                        <strong>Passion Drives Performance</strong>
                        <p>We genuinely love automobiles. That passion reflects in the way we inspect, analyse, and advise. When work is driven by passion, quality becomes natural.</p>
                    </li>
                    <li>
                        <strong>Trust Is Our Greatest Reward</strong>
                        <p>Customer recommendations are our biggest achievement. When our clients confidently refer AutoGenius to friends and family, it reminds us why we started — to become the first name people think of when buying a car.</p>
                    </li>
                </ol>
            </div>
        </div>
    </section>
@endsection
