@extends('layout.main')
@section('content')
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products List</a></li>
                            <li class="breadcrumb-item" aria-current="page">Add New Product</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Add New Product</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12" bis_skin_checked="1">

            <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
                <div class="card" bis_skin_checked="1">

                    @csrf
                    <div class="card-body" bis_skin_checked="1">
                        @if ($errors->any())
                            <div class="alert alert-danger mt-2" role="alert">
                                Please fill in all the required fields.
                            </div>
                        @endif
                        <div class="mt-3" bis_skin_checked="1">
                            <label class="form-label">Product Name</label>
                            <input type="text" class="form-control @error('product_name'){{ 'is-invalid' }}@enderror"
                                name="product_name" placeholder="Enter Product Name" value="{{old('product_name')}}">
                        </div>
                        @error('product_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <div class="mt-3 col-xl-6" bis_skin_checked="1">
                            <label class="form-label d-flex align-items-center">Price <i class="ph-duotone ph-info ms-1"
                                    data-bs-toggle="tooltip" data-bs-title="Price"></i></label>
                            <div class="input-group mt-3" bis_skin_checked="1">
                                <span class="input-group-text">$</span>
                                <input type="text" name="price" value="{{old('price')}}"
                                    class="form-control @error('price'){{ 'is-invalid' }}@enderror" placeholder="Price">
                            </div>
                            @error('price')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3" bis_skin_checked="1">
                            <label class="form-label">Category</label>
                            <select class="form-select @error('category_id'){{ 'is-invalid' }}@enderror"
                                name="category_id">
                                <option value="" selected>Select Category</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}"> {{ $item->category_name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3" bis_skin_checked="1">
                            <label class="form-label">Product Description</label>
                            <textarea class="form-control @error('product_description'){{ 'is-invalid' }}@enderror" name="product_description"
                                placeholder="Enter Product Description">{{old('product_description')}}</textarea>
                            @error('product_description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <label class="form-label mt-3">Product Theme</label>
                        <div class="col-xl-3" bis_skin_checked="1">
                            <label class="btn btn-outline-secondary" for="flupld" style="@error('product_theme'){{ 'border:2px solid red' }}@enderror">
                                <i class="ti ti-upload me-2"></i> Click to Upload
                            </label>
                            <input  type="file" id="flupld" name="product_theme"
                                class="d-none">
                            @error('product_theme')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Save product</button>
                    </div>
                </div>
            </form>


        </div>
    </div>
@endsection
