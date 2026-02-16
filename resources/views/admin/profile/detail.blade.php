@extends('admin.layout.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4 col">
            <div class="card-header py-3">
                <div class="">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">Admin Profile ( Role - <span
                                class="text-danger">{{ auth()->user()->role }}</span> )
                        </h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-3">

                        <img class="img-profile img-thumbnail" id="output"
                            src="{{ asset(auth()->user()->profile == null ? 'default_image/defaultProfile.jpg' : 'profileImage/'.auth()->user()->profile) }}">

                    </div>
                    <div class="col">

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">
                                        <i class="fa-solid fa-file-signature me-2"></i> <b>Name</b></label>
                                    <h6>{{ auth()->user()->name }}</h6>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">
                                        <i class="fa-solid fa-message me-2"></i> <b>Email</b></label>
                                    <h6>{{ auth()->user()->email }}</h6>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">
                                        <i class="fa-solid fa-phone me-2"></i> <b>Phone</b></label>
                                    <h6>{{ auth()->user()->phone }}</h6>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">
                                        <i class="fa-solid fa-location-arrow me-2"></i> <b>Address</b></label>
                                    <h6>{{ auth()->user()->address }}</h6>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label for="exampleFormControlInput1" class="form-label">
                                    <i class="fa-solid fa-clock me-2"></i> <b>Created at</b></label>
                                <h6>{{ auth()->user()->created_at }}</h6>
                                <a href="{{ route('profile#changePassword') }}"><i class="fa-solid fa-key"></i> change password</a>
                            </div>
                        </div>
                        <a href="{{ route('profile#edit') }}" class="btn btn-primary mt-3">Edit</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
