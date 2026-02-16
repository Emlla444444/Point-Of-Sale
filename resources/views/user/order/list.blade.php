@extends('user.layout.master')

@section('content')
    <div class="container " style="margin-top: 150px">
        <div class="row">
            <table class="table table-hover shadow-sm ">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Date</th>
                        <th>Order Code</th>
                        <th>Order Status</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($orderList as $item)
                        <tr>
                            <td>{{$item->created_at->format('d/m/y')}}</td>
                            <td>{{$item->order_code}}</td>
                            <td>
                                @if ( $item->status  == 'accepted')
                                    <span class="text-success">
                                        {{ $item->status }} <i class="fa-solid fa-circle-check"></i>
                                    </span>
                                @elseif ( $item->status == 'rejected')
                                    <span class="text-danger">
                                        {{ $item->status }} <i class="fa-solid fa-circle-xmark"></i>
                                    </span>
                                @elseif ( $item->status == 'pending')
                                    <span class="text-warning">
                                        {{ $item->status }} <i class="fa-solid fa-hourglass-half"></i>
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
