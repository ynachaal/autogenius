<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold mb-0 text-dark">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- Main Admin Content Area -->
    <main class="dashboard-content container my-4">
        <div class="card shadow-sm rounded-lg border p-4 p-lg-5">

            <h2 class="h3 fw-bold mb-4 pb-2 border-bottom">
                Dashboard Overview
            </h2>

            <!-- Stats Grid -->
            <div class="row g-4">
                <!-- Total Users -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card border border-primary-subtle shadow-sm rounded-4 p-4 text-center bg-primary-subtle">
                        <p class="text-uppercase small fw-medium text-primary mb-2">Total Users</p>
                        <p class="display-6 fw-bold text-dark mb-0">4,200</p>
                    </div>
                </div>

                <!-- Revenue -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card border border-success-subtle shadow-sm rounded-4 p-4 text-center bg-success-subtle">
                        <p class="text-uppercase small fw-medium text-success mb-2">Revenue</p>
                        <p class="display-6 fw-bold text-dark mb-0">$15.4K</p>
                    </div>
                </div>

                <!-- Pending Tasks -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card border border-warning-subtle shadow-sm rounded-4 p-4 text-center bg-warning-subtle">
                        <p class="text-uppercase small fw-medium text-warning mb-2">Pending Tasks</p>
                        <p class="display-6 fw-bold text-dark mb-0">12</p>
                    </div>
                </div>

                <!-- Critical Errors -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card border border-danger-subtle shadow-sm rounded-4 p-4 text-center bg-danger-subtle">
                        <p class="text-uppercase small fw-medium text-danger mb-2">Critical Errors</p>
                        <p class="display-6 fw-bold text-dark mb-0">0</p>
                    </div>
                </div>
            </div>

            <!-- Additional Content -->
            <div class="mt-4">
                <p class="text-secondary">
                    This section represents the main content of your admin dashboard, providing space for tables, charts, and control elements.
                </p>
            </div>

        </div>
    </main>
</x-app-layout>
