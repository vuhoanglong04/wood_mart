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
                                <form class="col-sm-12" method="post"
                                    action="{{ route('admin.category.update', $category->id) }}">
                                    @method('PATCH')
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label" for="exampleInputEmail1">Category Name</label>
                                        <input type="text"
                                            class="form-control @error('category_name'){{ 'is-invalid' }}@enderror @if(session('unique')) 'is-invalid'  @endif"
                                            value="{{ old('category_name') ?? $category->category_name }}"
                                            name="category_name" placeholder="Enter category name">
                                        @error('category_name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                        @if (session('unique'))
                                         <div class="invalid-feedback d-block">{{session('unique') }}</div>

                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="exampleInputEmail1">Parent Category</label>
                                        <select class="mb-0 form-select" name="parent_category_id">
                                            <option value="0" {{ $category->parent_category_id == '0' }}>None</option>
                                            @foreach ($categories as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $item->id == $category->parent_category_id ? 'selected' : '' }}>
                                                    {{ $item->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" style="color:white" class="btn btn-primary"> Update</button>
                                    <a href="{{route('admin.category.index')}}" type="submit" style="color:white" class="btn btn-danger">
                                        Cancel</a>



                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
