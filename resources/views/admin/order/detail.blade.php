@extends('admin.layout.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">


        <a href="{{ route('order#list') }}" class=" text-black m-3"> <i class="fa-solid fa-arrow-left-long"></i> Back</a>

        <!-- DataTales Example -->


        <div class="row">
            <div class="card col-5 shadow-sm m-4 col">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-5">Name :</div>
                        <div class="col-7">{{ $CustomerData[0]->name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Phone :</div>
                        <div class="col-7">
                            {{ $CustomerData[0]->phone }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Address :</div>
                        <div class="col-7">
                            {{ $CustomerData[0]->address }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Order Code :</div>
                        <div class="col-7" id="orderCode">{{ $CustomerData[0]->order_code }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Order Date :</div>
                        <div class="col-7">{{ $CustomerData[0]->created_at->format('d-m-y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Total Price :</div>
                        <div class="col-7">
                            {{ $totalPrice }} mmk<br>
                            <small class=" text-danger ms-1">( Contain Delivery Charges )</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card col-5 shadow-sm m-4 col">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-5">Contact Phone :</div>
                        <div class="col-7">{{ $paymentData->phone }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Payment Method :</div>
                        <div class="col-7">{{ $paymentData->account_type }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Purchase Date :</div>
                        <div class="col-7">{{ $paymentData->created_at->format('d-m-y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <img style="width: 150px" src="{{ asset('payslipImage/' . $paymentData->payslip_image) }}"
                            class=" img-thumbnail">
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">Order Board</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover shadow-sm " id="productTable">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="col-2">Image</th>
                                <th>Name</th>
                                <th>Order Count</th>
                                <th>Available Stock</th>
                                <th>Product Price (each)</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($productData as $item)
                                <tr>
                                    <input type="hidden" class="productId" value="{{ $item->id }}">
                                    <input type="hidden" class="orderCount" value="{{ $item->count }}">

                                    <td>
                                        <img src="{{ asset('productImage/' . $item->image) }}" class=" w-50 img-thumbnail">
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->count }}</td>
                                    <td>
                                        {{ $item->stock }}
                                        @if ($item->count > $item->stock)
                                            <small class="text-danger">( out of stock )</small>
                                        @endif
                                    </td>
                                    <td>{{ $item->price }} mmk</td>
                                    <td>{{ $item->total_price }} mmk</td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                    @if ($productData[0]['status'] == 'pending')
                        <div class="card-footer d-flex justify-content-end">
                            <div class="">
                                @if ($productStock)
                                    <input type="button" id="btn-order-confirm" class="btn btn-success rounded shadow-sm"
                                    value="Confirm">
                                @endif
                                <input type="button" id="btn-order-reject" class="btn btn-danger rounded shadow-sm"
                                    value="Reject">
                            </div>
                        </div>
                    @elseif ($productData[0]['status'] == 'rejected')
                        <div class="d-flex justify-content-center">
                            <span class="text-danger">You've been rejected this order</span>
                        </div>
                    @elseif ($productData[0]['status'] == 'accepted')
                        <div class="d-flex justify-content-center">
                            <span class="text-success">You've been accepted this order</span>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection

@section('script-code')
    <script>
        $(document).ready(function() {
            //order rejected
            $('#btn-order-reject').click(function() {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, reject it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        orderCode = $('#orderCode').text();
                        $.ajax({
                            type: 'GET',
                            url: '/admin/order/reject',
                            data: {
                                'order-code': orderCode
                            },
                            dataType: 'JSON',
                            success: function(res) {
                                res.status == 200 ? location.href =
                                    '/admin/order/list' : location
                                    .reload();
                            }
                        });
                    }
                });
            })

            //order accepted
            $('#btn-order-confirm').click(function() {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You will accept this order!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Confirm"
                }).then((result) => {
                    if (result.isConfirmed) {
                        orderCode = $('#orderCode').text();
                        orderInfo = [];
                        $('#productTable tbody tr').each(function(index, row) {
                            productId = $(row).find('.productId').val() * 1;
                            orderCount = $(row).find('.orderCount').val() * 1;

                            orderInfo.push({
                            'productId': productId,
                            'orderCount': orderCount
                        })

                        })
                        data = {
                            'orderCode': orderCode,
                            'orderInfo': orderInfo
                        }
                        $.ajax({
                            type: 'GET',
                            url: '/admin/order/accept',
                            data: Object.assign({}, data),
                            dataType: 'JSON',
                            success: function(res) {
                                res.status == 200 ? location.href =
                                    '/admin/order/list' : location
                                    .reload();
                            }
                        });
                    }
                });
            })
        })
    </script>
@endsection
