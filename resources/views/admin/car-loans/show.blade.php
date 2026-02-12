<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">Loan Applicant: {{ $carLoan->customer_name }}</h2>
    </x-slot>

    <div class="content py-4">
        <div class="container-fluid">
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Application Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.car-loans.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-list"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 border-end">
                            <h5 class="text-primary border-bottom pb-2">Customer Profile</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Full Name:</th>
                                    <td>{{ $carLoan->customer_name }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $carLoan->customer_email }}</td>
                                </tr>
                                <tr>
                                    <th>Mobile:</th>
                                    <td>
                                        <a href="tel:{{ $carLoan->customer_mobile }}">{{ $carLoan->customer_mobile }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>City/Location:</th>
                                    <td>{{ $carLoan->city }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h5 class="text-primary border-bottom pb-2">Inquiry Details</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Loan Type:</th>
                                    <td><span class="badge bg-dark">{{ $carLoan->loan_type }}</span></td>
                                </tr>
                                <tr>
                                    <th>Application Date:</th>
                                    <td>{{ $carLoan->created_at->format('M d, Y - h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>{{ ucfirst($carLoan->status) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="alert alert-light border">
                        <h6 class="fw-bold"><i class="fas fa-info-circle"></i> Internal Note:</h6>
                        <p class="mb-0">This lead was generated via the Car Loan form. Follow-up is required within 24 hours.</p>
                    </div>
                </div>
                <div class="card-footer d-flex gap-2">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $carLoan->customer_mobile) }}"
                        target="_blank" class="btn btn-success">
                        <i class="fab fa-whatsapp"></i> Contact via WhatsApp
                    </a>
                    <a href="mailto:{{ $carLoan->customer_email }}" class="btn btn-primary">
                        <i class="fas fa-envelope"></i> Send Email
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>