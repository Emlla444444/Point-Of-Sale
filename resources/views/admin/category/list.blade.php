@extends('admin.layout.master')

@section('content')
    <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Category List</h1>
                    </div>

                    <div class="">
                        <div class="row">
                            <div class="col-4">
                                <div class="card">
                                    <div class="card-body shadow">
                                        <form action="{{ route('category#create') }}" method="post" class="p-3 rounded">
                                            @csrf
                                            <input type="text" name="categoryName" value="{{ old('categoryName') }}" class=" form-control @error('categoryName') is-invalid @enderror"
                                                placeholder="Category Name...">
                                            @error('categoryName')
                                                <small class="invalid-feedback">{{ $message }}</small>
                                            @enderror
                                            <input type="submit" value="Create" class="btn btn-outline-primary mt-3">
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="row">
                                    <div class="col-6 offset-6">
                                        <form action="{{ route('category#list') }}" method="GET">
                                            <div class="input-group mb-2">
                                                <input type="text" name="searchKey" class="form-control" value="{{ request('searchKey') }}" placeholder="Enter search key...">
                                                <button class="btn bg-dark text-white">
                                                    <i class="fa-solid fa-magnifying-glass"></i>{{-- from font-awesone --}}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <table class="table table-hover shadow-sm mt-2">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Created Date</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if ($categoryCount != 0)
                                            @foreach ($categories as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->created_at->format('d-m-y') }}</td>
                                                <td>
                                                    <a href="{{ route('category#edit',$item->id) }}" class="btn btn-sm btn-outline-secondary"> <i
                                                            class="fa-solid fa-pen-to-square"></i> </a>
                                                    <button type="button" onclick="deleteCategory({{ $item->id }})" class="btn btn-sm btn-outline-danger"> <i
                                                            class="fa-solid fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach

                                            @else
                                            <td class="text-center" colspan="4">There is no data...</td>

                                        @endif

                                    </tbody>
                                </table>

                                <span class=" d-flex justify-content-end">{{ $categories->links() }}</span>

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
            title: "catrgory item created!",
            showConfirmButton: false,
            timer: 1000
            });
        </script>
    @endsection
@endif

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
                    location.href="/admin/category/delete/"+id //delete process
                }, 1010);
            }
        });
    }
    </script>
@endsection
