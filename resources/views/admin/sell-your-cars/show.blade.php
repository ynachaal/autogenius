<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">Vehicle Details: {{ $sellYourCar->vehicle_name }}</h2>
    </x-slot>



    <div class="content py-4">
        <div class="container-fluid">
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Detailed Inquiry Information</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.sell-your-cars.index') }}" class="btn btn-sm btn-secondary">
                            <i class="bi bi-list"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 border-end">
                            <h5 class="text-primary border-bottom pb-2">Vehicle Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Model:</th>
                                    <td>{{ $sellYourCar->vehicle_name }}</td>
                                </tr>
                                <tr>
                                    <th>Year:</th>
                                    <td>{{ $sellYourCar->year }}</td>
                                </tr>
                                <tr>
                                    <th>KMs Driven:</th>
                                    <td>{{ number_format($sellYourCar->kms_driven) }} km</td>
                                </tr>
                                <tr>
                                    <th>Owners:</th>
                                    <td>{{ $sellYourCar->no_of_owners }}</td>
                                </tr>
                                <tr>
                                    <th>Reg Number:</th>
                                    <td><span class="badge bg-dark">{{ $sellYourCar->registration_number }}</span></td>
                                </tr>
                                <tr>
                                    <th>Location:</th>
                                    <td>{{ $sellYourCar->car_location }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-primary border-bottom pb-2">Customer Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Name:</th>
                                    <td>{{ $sellYourCar->customer_name }}</td>
                                </tr>
                                <tr>
                                    <th width="40%">Email:</th>
                                    <td>{{ $sellYourCar->customer_email }}</td>
                                </tr>
                                <tr>
                                    <th>Mobile:</th>
                                    <td><a
                                            href="tel:{{ $sellYourCar->customer_mobile }}">{{ $sellYourCar->customer_mobile }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Inquiry Date:</th>
                                    <td>{{ $sellYourCar->created_at->format('M d, Y - h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="fw-bold mb-3">Vehicle Photo:</h5>
                    <div class="row g-3">
                        @if(!empty($sellYourCar->car_photos))
                            <div class="col-md-4">
                                <div class="border rounded overflow-hidden shadow-sm">
                                    <img src="{{ asset('storage/' . $sellYourCar->car_photos) }}" class="img-fluid"
                                        alt="Car Photo" style="height: 200px; width: 100%; object-fit: cover;">
                                </div>
                            </div>
                        @else
                            <div class="col-12">
                                <p class="text-muted italic">No photos uploaded for this vehicle.</p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-footer">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $sellYourCar->customer_mobile) }}"
                        target="_blank" class="btn btn-success">
                        <i class="bi bi-whatsapp"></i> Contact via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>