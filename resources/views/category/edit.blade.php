@extends('layout.main')
@section('content')
    <div class="pc-content">

        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.category.index') }}">Category List</a></li>
                            <li class="breadcrumb-item"><a>Edit Category</a></li>

                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Edit category #{{ $category->category_name }}</h2>
                        </div>
                        <div class="card mt-3 col-sm-6">

                            <div class="card-body">
                                <form class="col-sm-12" method="post" action="{{ route('admin.category.update', $category->id) }}" enctype="multipart/form-data">
                                    @method('PATCH')
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label" for="exampleInputEmail1">Category Name</label>
                                        <input type="text"
                                            class="form-control @error('category_name'){{ 'is-invalid' }}@enderror"
                                            value="{{ $category->category_name }}" name="category_name"
                                            placeholder="Enter category name">
                                        @error('category_name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="exampleInputEmail1">Parent Category</label>
                                        <select class="mb-0 form-select" name="parent_category_id">
                                            <option value="0" selected>None</option>
                                            @foreach ($categories as $item)
                                                <option value="{{ $item->id }}" {{$item->id == $category->parent_category_id ? 'selected' : ''}}>{{ $item->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class=" mt-3">
                                        <label class="form-label"
                                            for="inputGroupFile01">Icon (nullable)</label>
                                        <input type="file" name="icon" class="form-control  @error('icon'){{ 'is-invalid' }}@enderror" id="inputGroupFile01">
                                        @error('icon')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class=" mt-3">
                                        <label class="form-label" for="inputGroupFile02">Background (nullable)</label>
                                        <input type="file" name="background" class="form-control @error('background'){{ 'is-invalid' }}@enderror" id="inputGroupFile02">
                                        @error('background')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    </div>
                                    <button type="submit" style="color:white" class="btn btn-primary mt-3"><i
                                            class="ph-duotone ph-plus-circle" style="margin-top: 3px"></i> Add New
                                        Category</button>


                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
