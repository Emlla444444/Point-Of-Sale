@extends('user.layout.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid py-5 mt-5 fruite">


        <!-- DataTales Example -->
        <div class="card shadow mb-4 col">
            <div class="card-header py-3">
                <div class="">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">User Profile ( <span class="text-danger"> Role</span> )
                        </h6>
                    </div>
                </div>
            </div>
            <form action="{{ route('user#profileUpdate',auth()->user()->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <img class="img-profile img-thumbnail" id="output"
                                src="{{ asset(auth()->user()->profile == null ? 'default_image/defaultProfile.jpg' : 'userProfile/'.auth()->user()->profile) }}">


                            <input type="file" name="image" id="" class="form-control mt-1 " onchange="loadFile(event)" accept="image/*">

                        </div>
                        <div class="col">

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">
                                            Name</label>
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Enter your name..." value="{{ old('name', auth()->user()->name) }}">
                                        @error('name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">
                                            Email</label>
                                        <input type="text" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', auth()->user()->email) }}"
                                            placeholder="Enter your email...">
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">
                                            Phone</label>
                                        <input type="text" name="phone"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ old('phone', auth()->user()->phone) }}" placeholder="09xxxxxx">
                                        @error('phone')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Address</label>
                                        <input type="text" name="address"
                                            class="form-control @error('address') is-invalid @enderror"
                                            value="{{ old('address', auth()->user()->address) }}"
                                            placeholder="Enter your address...">
                                        @error('address')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror

                                    </div>
                                </div>
                            </div>

                            <input type="submit" value="Update" class="btn btn-primary mt-3">
                            <a href="{{ route('user#home') }}" class="btn btn-dark mt-3" >Back</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection

@if (Session::has('success'))
    @section('script-code')
        <script>
            Swal.fire({
            icon: "success",
            title: "your acc was updated!",
            showConfirmButton: false,
            timer: 1500
            });
        </script>
    @endsection
@endif
