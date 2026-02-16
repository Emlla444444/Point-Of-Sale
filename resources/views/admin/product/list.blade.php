@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-10 offset-1">
            <table class="table table-hover shadow-sm mt-2">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th class="col-2">Image</th>
                        <th>Stock</th>
                        <th>Created Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                <img class="img-thumbnail w-10" src="{{ asset('productImage/' . $item->image) }}"
                                    alt="">
                            </td>
                            <td>
                                <span class="position-relative text-dark">
                                    {{ $item->stock }}
                                    @if ($item->stock == 0)
                                        <small class="position-absolute top-0 start-100 badge text-danger">
                                            out of stock
                                        </small>
                                    @elseif ($item->stock <= 5)
                                        <small class="position-absolute top-0 start-100 badge text-warning">
                                            low amount
                                        </small>
                                    @endif
                                </span>
                            </td>
                            <td>{{ $item->created_at->format('d/m/y') }}</td>
                            <td>
                                <a href="{{ route('product#detail',$item->id) }}" class="btn btn-sm btn-outline-secondary"> <i class="fa-solid fa-search"></i> </a>
                                <a href="{{ route('product#edit',$item->id) }}" class="btn btn-sm btn-outline-secondary"> <i
                                        class="fa-solid fa-pen-to-square"></i> </a>
                                <button onclick="deleteProduct({{ $item->id }})" type="button"
                                    class="btn btn-sm btn-outline-danger"> <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script-code')
    <script>
        function deleteProduct(id) {
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
                        location.href = "/admin/product/delete/" + id //delete process
                    }, 1010);
                }
            });
        }
    </script>
@endsection
