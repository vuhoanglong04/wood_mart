@extends('layout.main')
@section('content')
    <div class="pc-content">

        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.groups.index') }}">Groups List</a></li>
                            <li class="breadcrumb-item"><a>Edit Group</a></li>

                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Edit group #{{ $group->group_name }}</h2>
                        </div>
                        <div class="card mt-3 col-sm-6">

                            <div class="card-body">
                                <form action="{{route('admin.groups.update' , $group->id)}}" method="post">
                                    @method('PATCH')
                                    @csrf
                                    <div class="mt-3">
                                        <label class="form-label">Group Name</label>
                                        <input type="text" name="group_name" class="form-control  @error('group_name'){{ 'is-invalid' }}@enderror"
                                            placeholder="Enter group name" id="floatingInput"
                                            value="{{ old('group_name') ??  $group->group_name }}">
                                    </div>
                                    @error('group_name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>

                                    @enderror
                                    <button type="submit" style="color:white" class="btn btn-primary mt-2">Update</button>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
