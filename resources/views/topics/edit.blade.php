@extends('layout.main')
@section('content')
    <div class="pc-content">

        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.topics.index') }}">Topics List</a></li>
                            <li class="breadcrumb-item"><a>Edit Topic</a></li>

                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Edit topic #{{ $topic->topic_name }}</h2>
                        </div>
                        <div class="card mt-3 col-sm-6">

                            <div class="card-body">
                                <form class="col-sm-12" method="post"
                                    action="{{ route('admin.topics.update', $topic->id) }}">
                                    @method('PATCH')
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label" for="">Topic Name</label>
                                        <input type="text"
                                            class="form-control @error('topic_name'){{ 'is-invalid' }}@enderror"
                                            value="{{$topic->topic_name ?? old('topic_name') }}" name="topic_name"
                                            placeholder="Enter topic name">
                                        @error('topic_name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="exampleInputEmail1">Parent Topic</label>
                                        <select
                                            class="mb-0 form-select @error('parent_topic_id'){{ 'is-invalid' }}@enderror"
                                            name="parent_topic_id">
                                            <option value="0">None</option>
                                            @foreach ($topics as $item)
                                                <option value="{{ $item->id }}" {{$item->id == $topic->parent_topic_id ? 'selected' : ''}}>{{ $item->topic_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('parent_topic_id')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" style="color:white" class="btn btn-primary"> Update</button>
                                    <a href="{{ route('admin.topics.index') }}" type="submit" style="color:white"
                                        class="btn btn-danger">
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
