@extends('admin.layout.master')

@section('content')
    <div class="container">
        <div class=" d-flex justify-content-between my-2">
            <div class=""></div>
            <div class="">
                <form action="{{ route('order#orderList') }}" method="get">

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
            <a href="{{ route('order#list') }}">
                <button class="btn btn-success rounded mb-2 mr-2 ml-3">Back</button>
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

                        @if (!$orders)
                            <td class="text-danger col-span-4">There has no accept or pending order</td>
                        @else
                            @foreach ($orders as $item)
                                <tr>
                                    <td>{{ $item->created_at->format('d-F-y') }}</td>
                                    <td>
                                        <a href="{{ route('order#detail', $item->order_code) }}">{{ $item->order_code }}</a>
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        @if ($item->status == 'accepted')
                                            <span class="text-success">
                                                {{ $item->status }} <i class="fa-solid fa-circle-check"></i>
                                            </span>
                                        @elseif ($item->status == 'pending')
                                            <span class="text-warning">
                                                {{ $item->status }} <i class="fa-solid fa-hourglass-half"></i>
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

                <span>{{ $orders->links() }}</span>

            </div>
        </div>
    </div>
@endsection
