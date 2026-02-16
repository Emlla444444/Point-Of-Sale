@extends('admin.layout.master')

@section('content')

    <div class="row">
        <div class="col-4 offset-4">
            <a href="{{ route('category#list') }}">category</a> > edit
            <div class="card">
                <div class="card-body shadow">
                    <form action="{{ route('category#update',$data->id) }}" method="post"     class="p-3 rounded">
                        @csrf
                            <input type="text" name="categoryName" value="{{ old('categoryName',$data->name ) }}" class=" form-control @error('categoryName') is-invalid @enderror"
                                placeholder="Category Name...">
                            @error('categoryName')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                            <input type="submit" value="Update" class="btn btn-outline-primary mt-3">
                        </form>
                    </div>
                </div>
            </div>
        </div>

@endsection

@if (Session::has('update'))
    @section('script-code')
        <script>
            Swal.fire({
            icon: "success",
            title: "updated successfully!",
            showConfirmButton: false,
            timer: 1000
            });

            setInterval(() => {
                    location.href="/admin/category/list/"
            }, 1010);

        </script>
    @endsection
@endif
