<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold mb-0 text-dark">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <main class="dashboard-content container my-4">
        <div class="card shadow-sm rounded-lg border p-4 p-lg-5">

            <h2 class="h3 fw-bold mb-4 pb-2 border-bottom">
                Dashboard Overview
            </h2>

            <div class="row g-4">

                {{-- Active Brands --}}
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="{{ route('admin.brands.index') }}" class="text-decoration-none">
                        <div class="card border border-warning-subtle shadow-sm rounded-4 p-4 text-center bg-warning-subtle hover-shadow">
                            <p class="text-uppercase small fw-medium text-warning mb-2">Active Brands</p>
                            <p class="display-6 fw-bold text-dark mb-0">
                                {{ number_format($stats['active_brands'] ?? 0) }}
                            </p>
                        </div>
                    </a>
                </div>

                {{-- Active Services --}}
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="{{ route('admin.services.index') }}" class="text-decoration-none">
                        <div class="card border border-info-subtle shadow-sm rounded-4 p-4 text-center bg-info-subtle hover-shadow">
                            <p class="text-uppercase small fw-medium text-info mb-2">Active Services</p>
                            <p class="display-6 fw-bold text-dark mb-0">
                                {{ number_format($stats['active_services'] ?? 0) }}
                            </p>
                        </div>
                    </a>
                </div>

                {{-- Total Leads --}}
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="{{ route('admin.leads.index') }}" class="text-decoration-none">
                        <div class="card border border-primary-subtle shadow-sm rounded-4 p-4 text-center bg-primary-subtle hover-shadow">
                            <p class="text-uppercase small fw-medium text-primary mb-2">Total Leads</p>
                            <p class="display-6 fw-bold text-dark mb-0">
                                {{ number_format($stats['total_leads'] ?? 0) }}
                            </p>
                        </div>
                    </a>
                </div>

                {{-- Call Consultations (New) --}}
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="{{ route('admin.call-consultations.index') }}" class="text-decoration-none">
                        <div class="card border border-success-subtle shadow-sm rounded-4 p-4 text-center bg-success-subtle hover-shadow">
                            <p class="text-uppercase small fw-medium text-success mb-2">Consultations</p>
                            <p class="display-6 fw-bold text-dark mb-0">
                                {{ number_format($stats['consultations']['total'] ?? 0) }}
                            </p>
                           <!--  <small class="text-muted">Paid: {{ $stats['consultations']['paid'] ?? 0 }}</small> -->
                        </div>
                    </a>
                </div>

                {{-- Car Inspections (New) --}}
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="{{ route('admin.car-inspections.index') }}" class="text-decoration-none">
                        <div class="card border border-danger-subtle shadow-sm rounded-4 p-4 text-center bg-danger-subtle hover-shadow">
                            <p class="text-uppercase small fw-medium text-danger mb-2">Car Inspections</p>
                            <p class="display-6 fw-bold text-dark mb-0">
                                {{ number_format($stats['inspections']['total'] ?? 0) }}
                            </p>
                           <!--  <small class="text-muted">Paid: {{ $stats['inspections']['paid'] ?? 0 }}</small> -->
                        </div>
                    </a>
                </div>

                {{-- Insurance Claims (New) --}}
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="{{ route('admin.service-insurance-claims.index') }}" class="text-decoration-none">
                        <div class="card border border-secondary-subtle shadow-sm rounded-4 p-4 text-center bg-secondary-subtle hover-shadow">
                            <p class="text-uppercase small fw-medium text-secondary mb-2">Insurance Claims</p>
                            <p class="display-6 fw-bold text-dark mb-0">
                                {{ number_format($stats['insurance_claims']['total'] ?? 0) }}
                            </p>
                           <!--  <small class="text-muted">Paid: {{ $stats['insurance_claims']['paid'] ?? 0 }}</small> -->
                        </div>
                    </a>
                </div>

                {{-- Sell Your Car (New) --}}
                <div class="col-12 col-md-6 col-lg-3" >
                    <a href="{{ route('admin.sell-your-cars.index') }}" class="text-decoration-none">
                        <div class="card border border-dark-subtle shadow-sm rounded-4 p-4 text-center bg-light hover-shadow" >
                            <p class="text-uppercase small fw-medium text-dark mb-2">Car Sales</p>
                            <p class="display-6 fw-bold text-dark mb-0">
                                {{ number_format($stats['car_sales']['total'] ?? 0) }}
                            </p>
                          
                        </div>
                    </a>
                </div>

            </div>

            <div class="mt-5 border-top pt-4">
                <h4 class="h5 fw-bold mb-3">System Actions</h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.migrate') }}" class="btn btn-outline-dark btn-sm">Run Migrations</a>
                    <a href="{{ route('admin.clearCache') }}" class="btn btn-outline-secondary btn-sm">Clear Cache</a>
                    <a href="{{ route('admin.storage.link') }}" class="btn btn-outline-secondary btn-sm">Storage SYM LINK</a>
                </div>
            </div>

        </div>
    </main>
</x-app-layout>