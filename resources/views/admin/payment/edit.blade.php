@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-4 offset-4">
            <a href="{{ route('payment#list') }}">Back</a> > edit
            <div class="card">
                <div class="card-body shadow">
                    <form action="{{ route('payment#update',$payment->id) }}" method="POST" class="p-3 rounded">
                        @csrf
                        <input type="text" name="accountName" value="{{ old('accountName',$payment->account_name) }}"
                            class=" form-control @error('accountName') is-invalid @enderror" placeholder="Account Name">
                        @error('accountName')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                        <input type="text" name="accountNumber" value="{{ old('accountNumber',$payment->account_number) }}"
                            class=" form-control mt-3 @error('accountNumber') is-invalid @enderror"
                            placeholder="Account Number">
                        @error('accountNumber')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                        <input type="text" name="accountType" value="{{ old('accountType',$payment->account_type) }}"
                            class=" form-control mt-3 @error('accountType') is-invalid @enderror"
                            placeholder="Account Type">
                        @error('accountType')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                        <input type="submit" value="Update" class="btn btn-outline-primary mt-3">
                    </form>
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
                title: "updated successfully!",
                showConfirmButton: false,
                timer: 1000
            });

            setInterval(() => {
                location.href = "/admin/payment/list/"
            }, 1010);
        </script>
    @endsection
@endif
