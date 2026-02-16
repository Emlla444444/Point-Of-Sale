@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-6 offset-2">
            <div class="card">
                <div class="pt-4 card-body">
                    <form action="{{ route('product#add') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <img src="{{ asset('default_image/dImage.webp') }}" class="px-2 my-2 w-50 img-thumbnail"
                            id="output">{{-- photo review --}}

                        <input type="file" name="image" class="px-2 my-2 @error('image') is-invalid @enderror" accept="image/*" onchange="loadFile(event)">
                        @error('image')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror

                        <input type="text" name="title" class="px-2 my-2 form-control @error('title') is-invalid @enderror" placeholder="Enter Product Title..." value="{{ old('title') }}">
                        @error('title')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror

                        <input type="number" name="price" class="px-2 my-2 form-control @error('price') is-invalid @enderror" placeholder="Enter Product Price..." value="{{ old('price') }}">
                        @error('price')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror

                        <textarea name="description" cols="30" rows="10" class="px-2 my-2 form-control @error('description') is-invalid @enderror" placeholder="Enter Product Description...">{{ old('description') }}</textarea>
                        @error('description')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror

                        <select name="categoryId" id="" class="px-2 my-2 form-control form-select @error('categoryId') is-invalid @enderror">
                            <option value="">Choose Category Name...</option>
                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}"
                                @if ($item->id == old('categoryId'))
                                    selected
                                @endif>{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('categoryId')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror

                        <input type="number" name="stock" class="px-2 my-2 form-control @error('stock') is-invalid @enderror" placeholder="Enter Product Stock..." value="{{ old('stock') }}">
                        @error('stock')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror

                        <input type="submit" value="Add" class="btn btn-primary w-100">
                    </form>
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
            title: "product is added successfully!",
            showConfirmButton: false,
            timer: 1000
            });
        </script>
    @endsection
@endif
