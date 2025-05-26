@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow rounded-4 border-0">
                <div class="card-body p-4">
                    <h2 class="mb-3 text-center" style="color:#FFA500;">Mi Perfil</h2>
                    <hr>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
            <div class="card shadow rounded-4 border-0 mt-4">
                <div class="card-body p-4">
                    
                    @include('profile.partials.update-password-form')
                </div>
            </div>
            <div class="card shadow rounded-4 border-0 mt-4 mb-4">
                <div class="card-body p-4">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
