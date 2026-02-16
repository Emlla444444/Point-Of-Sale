@extends('admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-11">
                <div class="card">
                    <div class="pt-4 card-body">
                        <div class="row">
                            <div class="col-5">
                                <img src="{{ asset('productImage/' . $product->image) }}"
                                    class="px-2 my-2 w-100 img-thumbnail" id="output"> {{-- photo review --}}
                            </div>
                            <div class="col">
                                    <label for="title" class="px-2 my-2 form-control">{{ $product->name }}</label>

                                <label for="price" class="px-2 my-2 form-control">{{ $product->price }}</label>

                                <textarea name="description"
                                    class="px-2 my-2 form-control h-50" readonly>{{ $product->description }}
                                </textarea>

                                <label for="categoryId" class="px-2 my-2 form-control">
                                    @foreach ($categories as $item)
                                        @if ($item->id == $product->category_id)
                                            {{ $item->name }}
                                        @endif
                                    @endforeach
                                </label>

                                <label for="stock" class="px-2 my-2 form-control">{{ $product->stock }}</label>

                                <a href="{{ route('product#list') }}" class="btn btn-primary w-100">Back</a>
                            </div>
                        </div>
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
