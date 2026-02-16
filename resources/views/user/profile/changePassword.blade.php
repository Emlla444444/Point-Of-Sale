@extends('user.layout.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid py-5 mt-5">
        <!-- Page Heading -->
        <div class="">
            <div class="row">
                <div class="col-8 offset-2">
                    <div class="card">
                        <div class="card-body shadow">
                            <form action="{{ route('user#passwordChange') }}" method="post" class="p-3 rounded">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Old
                                        Password</label>
                                    <input type="password" name="oldPassword"
                                        class="form-control @error('oldPassword') is-invalid @enderror"
                                        placeholder="Enter Old Password...">
                                    @error('oldPassword')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">New
                                        Password</label>
                                    <input type="password" name="newPassword"
                                        class="form-control @error('newPassword') is-invalid @enderror"
                                        placeholder="Enter New Password...">
                                    @error('newPassword')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror

                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" name="confirmPassword"
                                        class="form-control @error('confirmPassword') is-invalid @enderror"
                                        placeholder="Enter Confirm Password...">
                                    @error('confirmPassword')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="">
                                    <input type="submit" value="Submit" class="btn bg-success text-white">
                                    <a href="{{ route('user#home') }}" class="btn btn-dark">Back</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@if (Session::has('success'))
    @section('script-code')
        <script>
            Swal.fire({
                icon: "success",
                title: "password is changed successfully!",
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endsection
@endif

@if (Session::has('fail'))
    @section('script-code')
        <script>
            Swal.fire({
                icon: "fail",
                title: "try again..",
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endsection
@endif
