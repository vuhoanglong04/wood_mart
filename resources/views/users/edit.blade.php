@extends('layout.main');
@section('content')
    <style>

    </style>
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">User List</a></li>
                            <li class="breadcrumb-item" aria-current="page">Edit User</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Edit User #{{$user->id}}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5>User Information</h5>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                Please fill in all the required fields.
                            </div>
                        @endif
                        <form action="{{ route('admin.users.update' , $user->id) }}" method="post" enctype="multipart/form-data">

                            <div class="mt-3">
                                <label class="form-label">Full name</label>
                                <input type="text" name='full_name'
                                    class="form-control @error('full_name'){{ 'is-invalid' }}@enderror"
                                    placeholder="Enter full name"
                                    id="floatingInput"
                                    value="{{old('full_name') ?? $user->full_name }}"
                                    >
                            </div>
                            @error('full_name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <div class="mt-3">
                                <label class="form-label">Email</label>
                                <input type="text" name='email'
                                    class="form-control @error('email'){{ 'is-invalid' }}@enderror"
                                    placeholder="Emaill address"
                                    value="{{old('email') ?? $user->email}}"
                                    >
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <div class="mt-3">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name='phone_number'
                                    class="form-control @error('phone_number'){{ 'is-invalid' }}@enderror"
                                    placeholder="+84" value="{{old('phone_number') ?? $user->phone_number}}">
                            </div>
                            @error('phone_number')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <label class="form-label mt-3">Password</label>
                            <div class="input-group mb-3">
                                <div class="input-group-text">
                                  <input class="form-check-input checkPass" type="checkbox" value="1" name="newPass" {{old('newPass')?'checked':''}}>
                                </div>
                                <input type="text" class="form-control @error('password'){{ 'is-invalid' }}@enderror" aria-label="Text input with checkbox" placeholder="Enter new password here" {{old('newPass')!=null ? '' :'disabled'}} name="password">
                              </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <div class="mt-3">
                                <label class="form-label">Group</label>
                                <select class="form-select fs-5 @error('group_id'){{ 'is-invalid' }}@enderror"
                                    name='group_id'>
                                    @foreach ($groups as $item)
                                        <option value="{{ $item->group_id }}" {{$item->group_id == $user->group_id ? 'selected' : ''}}>{{ $item->group_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('group_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <div class=" mt-3">
                                <label class="form-label" for="inputGroupFile02">Upload Avatar <span
                                        style="color:red">*</span> (Can skip)</label>
                                <input type="file" name="img" class="form-control @error('img'){{ 'is-invalid' }}@enderror" id="inputGroupFile02">
                            </div>
                            @error('img')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <div class="action mt-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                               
                            </div>
                            @csrf
                        </form>

                    </div>

                </div>

            </div>
<script>
        document.querySelector('.checkPass').addEventListener('click', function(){
            var passInput = this.parentNode.parentNode.querySelector('.form-control')
            if(this.checked){
                passInput.removeAttribute('disabled');
            }else passInput.setAttribute('disabled' ,'');
        })

</script>
        </div>
    @endsection
