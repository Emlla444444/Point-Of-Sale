@extends('admin.layout.master')

@section('content')
    <div class="container">
        <div class=" d-flex justify-content-between my-2">
            <a href="{{ route('profile#accountList',['accountType'=>'admin']) }}"> <button class=" btn btn-sm btn-secondary "> admin List</button> </a>
            <div class="">
                <form action="{{ route('profile#accountList',['accountType'=>'user']) }}" method="get">
                    <div class="input-group">
                        <input type="text" name="searchKey" value="{{ request('searchKey') }}" class=" form-control"
                            placeholder="Enter Search Key...">
                        <button type="submit" class=" btn bg-dark text-white"> <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <span><i class="fa-solid fa-user-tie"></i> users - {{ count($accounts) }}</span>
        <div class="row">
            <div class="col">
                <table class="table table-hover shadow-sm ">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Created Date</th>
                            <th>Platform</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($accounts as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->address == null ? '-' : $item->address }}</td>
                                <td>{{ $item->phone == null ? '-' : $item->phone }}</td>
                                <td>{{ $item->role }}</td>
                                <td>{{ $item->created_at->format('d-m-y') }}</td>
                                <td>
                                    @if ($item->provider == 'simple')
                                        <i class="fa-solid fa-gauge-simple"></i> {{ $item->provider }}
                                    @elseif ($item->provider == 'google')
                                        <i class="fa-brands fa-google"></i> {{ $item->provider }}
                                    @elseif ($item->provider == 'github')
                                        <i class="fa-brands fa-github"></i> {{ $item->provider }}
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('profile#userAccDetail',$item->id) }}" class="btn btn-sm btn-outline-primary"> <i class="fa-solid fa-circle-info"></i>
                                    </a>
                                </td>
                                <td>
                                    @if ($item->role != 'superadmin')
                                        <button type="button" onclick="deleteCategory({{ $item->id }})" class="btn btn-sm btn-outline-danger"> <i class="fa-solid fa-circle-minus"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

                <span class=" d-flex justify-content-end"></span>

            </div>
        </div>
    </div>
@endsection

@section('script-code')
    <script>
        function deleteCategory(id) {
            Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
            }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                title: "Deleted!",
                text: "Your file has been deleted.",
                icon: "success",
                timer: 1000,
                timerProgressBar: true,
                showConfirmButton: false
                });

                setInterval(() => {
                    location.href="/admin/profile/delete/"+id //delete process
                }, 1010);
            }
        });
    }
    </script>
@endsection
