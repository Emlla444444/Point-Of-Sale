@extends('admin.layout.master')

@section('content')
    <div class="container">
        <div class=" d-flex justify-content-between my-2">
            <div class=""></div>
            <div class="">
                <form action="{{ route('order#list') }}" method="get">

                    <div class="input-group">
                        <input type="text" name="searchKey" value="{{ request('searchKey') }}" class=" form-control"
                            placeholder="Search with order code...">
                        <button type="submit" class=" btn bg-dark text-white"> <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <a href="{{ route('order#orderList') }}">
                <button class="btn btn-success rounded mb-2 mr-2 ml-3">Order List</button>
            </a>
            <a href="{{ route('order#rejectList') }}">
                <button class="btn btn-danger rounded">Reject List</button>
            </a>
        </div>

        <div class="row">
            <div class="col">
                <table class="table table-hover shadow-sm ">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Date</th>
                            <th>Order Code</th>
                            <th>Customer Name</th>
                            <th>Order Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderList as $item)
                            <tr>
                                <td>{{ $item->created_at->format('d/m/y') }}</td>
                                <td>
                                    <a href="{{ route('order#detail', $item->order_code) }}">{{ $item->order_code }}</a>
                                </td>
                                <td>{{ $item->customer_name }}</td>
                                <td>
                                    @if ($item->status == 'accepted')
                                        <span class="text-success">
                                            {{ $item->status }} <i class="fa-solid fa-circle-check"></i>
                                        </span>
                                    @elseif ($item->status == 'rejected')
                                        <span class="text-danger">
                                            {{ $item->status }} <i class="fa-solid fa-circle-xmark"></i>
                                        </span>
                                    @elseif ($item->status == 'pending')
                                        <span class="text-warning">
                                            {{ $item->status }} <i class="fa-solid fa-hourglass-half"></i>
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <span>{{ $orderList->links() }}</span>

            </div>
        </div>
    </div>
@endsection
