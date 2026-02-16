@extends('user.layout.master')

@section('content')
    <div class="container " style="margin-top: 150px">
        <div class="row">
            <div class="card col-12 shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <h5 class="mb-4">Payment methods</h5>

                            @foreach ($payments as $item)
                                <div class="">
                                    <b></b>{{ $item->account_type }} ( Name : {{ $item->account_name }})
                                </div>

                                Account : {{ $item->account_number }}
                                <hr>
                            @endforeach

                        </div>
                        <div class="col">
                            <div class="card shadow-sm">
                                <div class="card-header">
                                    Payment Info
                                </div>
                                <div class="card-body">
                                    <div class="">
                                        <form action="{{ route('user#payment') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row mt-4">
                                                <div class="col">
                                                    <input type="text" name="name" id="" readonly
                                                        value="{{ auth()->user()->name }}" class="form-control "
                                                        placeholder="User Name...">
                                                </div>
                                                <div class="col">
                                                    <input type="text" name="phone" id=""
                                                        value="{{ old('phone') }}"
                                                        class="form-control @error('phone')
                                                            is-invalid
                                                        @enderror"
                                                        placeholder="09xxxxxxxx">
                                                    @error('phone')
                                                        <small class="invalid-feedback">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col">
                                                    <input type="text" name="address" id=""
                                                        value="{{ old('address') }}"
                                                        class="form-control @error('address')
                                                            is-invalid
                                                        @enderror"
                                                        placeholder="Address...">
                                                    @error('address')
                                                        <small class="invalid-feedback">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col">
                                                    <select name="paymentType" id=""
                                                        class=" form-select @error('paymentType')
                                                            is-invalid
                                                        @enderror">
                                                        <option value="">Choose Payment methods...</option>
                                                        @foreach ($payments as $item)
                                                            <option value="{{ $item->id }}"
                                                                @if ($item->id == old('paymentType')) selected @endif>
                                                                {{ $item->account_type }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('paymentType')
                                                        <small class="invalid-feedback">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col">
                                                    <img src="{{ asset('default_image/dImage.webp') }}" id="output"
                                                        class="px-2 my-2 w-50 img-thumbnail">
                                                    <input type="file" name="payslipImage" id=""
                                                        class="form-control @error('payslipImage')
                                                            is-invalid
                                                        @enderror"
                                                        accept="image/*" onchange="loadFile(event)">
                                                    @error('payslipImage')
                                                        <small class="invalid-feedback">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mt-4">
                                                <div class="col">
                                                    <input type="hidden" name="orderCode" value="">
                                                    Order Code : <span
                                                        class="text-secondary fw-bold">{{ $orderCode }}</span>
                                                </div>
                                                <div class="col">
                                                    <input type="hidden" name="totalAmount" value="">
                                                    Total amt : <span class=" fw-bold">{{ $total }} mmk</span>
                                                </div>
                                            </div>

                                            <div class="row mt-4 mx-2">
                                                <button type="submit" class="btn btn-outline-success w-100"><i
                                                        class="fa-solid fa-cart-shopping me-3"></i> Order
                                                    Now...</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
                title: "ordered successfully!",
                showConfirmButton: false,
                timer: 1500
            });

            setInterval(() => {
                location.href = "/user/order/list"
            }, 1502);
        </script>
    @endsection
@endif
