@extends('admin.layout.master')

@section('content')
<div class="container">
        <div class=" d-flex justify-content-between my-2">
            <div class=""></div>
            <div class="">
                <form action="{{ route('order#saleInfo') }}" method="get">

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
            <h5 class="ml-3">
                Sale Information (Total Amount - <span class="text-danger">{{$total}}</span> mmk)
            </h5>
        </div>

        <div class="row">
            <div class="col">
                <table class="table table-hover shadow-sm ">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Date</th>
                            <th>Order Code</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if (!$sales)
                            <td class="text-danger col-span-4">no sale yet!</td>
                        @else
                            @foreach ($sales as $item)
                                <tr>
                                    <td>{{ $item->created_at->format('d-F-y') }}</td>
                                    <td>
                                        <a href="{{ route('order#detail', $item->order_code) }}">{{ $item->order_code }}</a>
                                    </td>
                                    <td>{{ $item->total_price }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
