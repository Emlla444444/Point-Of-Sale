@extends('admin.layout.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4 col">
            <div class="card-header py-3">
                <div class="">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">Profile Detail ( Role - <span
                                class="text-danger">{{ $data[0]->role }}</span> )
                        </h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-3">

                        <img class="img-profile img-thumbnail" id="output"
                            src="{{ asset($data[0]->profile == null ? 'default_image/defaultProfile.jpg' : 'userProfile/' . $data[0]->profile) }}">

                    </div>
                    <div class="col">

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">
                                        <i class="fa-solid fa-file-signature me-2"></i> <b>Name</b></label>
                                    <h6>{{ $data[0]->name }}</h6>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">
                                        <i class="fa-solid fa-message me-2"></i> <b>Email</b></label>
                                    <h6>{{ $data[0]->email }}</h6>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">
                                        <i class="fa-solid fa-phone me-2"></i> <b>Phone</b></label>
                                    <h6>{{ $data[0]->phone }}</h6>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">
                                        <i class="fa-solid fa-location-arrow me-2"></i> <b>Address</b></label>
                                    <h6>{{ $data[0]->address }}</h6>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label for="exampleFormControlInput1" class="form-label">
                                    <i class="fa-solid fa-clock me-2"></i> <b>Created date</b></label>
                                <h6>{{ $data[0]->created_at->format('d-m-y') }}</h6>
                            </div>
                        </div>
                        <div class="mt-2">
                            <a href="{{ route('profile#accountList', ['accountType' => 'user']) }}" class="btn btn-sm btn-primary">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
