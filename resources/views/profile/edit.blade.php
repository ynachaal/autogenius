<x-app-layout>
    <x-slot name="header">
        <h2 class="h4">{{ __('Profile') }}</h2>
    </x-slot>

    <div class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Update Profile Information</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-primary card-outline mt-5">
                <div class="card-header">
                    <h3 class="card-title">Update Password</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>
            </div>

           <!--  <div class="card card-primary card-outline  mt-5">
                <div class="card-header">
                    <h3 class="card-title">Delete Account</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</x-app-layout>