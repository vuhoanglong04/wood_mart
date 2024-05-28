@extends('layout.main')
@section('content')
    <div class="pc-content">

        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.vouchers.index') }}">Voucher List</a></li>
                            <li class="breadcrumb-item"><a>Edit Voucher</a></li>

                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Edit voucher #{{ $voucher->id }}</h2>
                        </div>
                        <div class="card mt-3 col-sm-6">

                            <div class="card-body">
                                <form action="{{ route('admin.vouchers.update', $voucher->id) }}" method="post">
                                    @method('PATCH')
                                    @csrf

                                        <div class="mb-3">
                                            <label class="form-label" for="">Code</label>
                                            <input type="text"maxlength="10"
                                                class="form-control code @error('code'){{ 'is-invalid' }}@enderror"
                                                name="code" placeholder="Enter code" value='{{ old('code') ?? $voucher->code }}'>
                                            @error('code')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror

                                        </div>

                                        <div class="mb-3">
                                            <label for="demo-range-input @error('discount'){{ 'is-invalid' }}@enderror"
                                                class="form-label">Discount : <b class="percents">{{$voucher->discount ?? '20'}}</b>%
                                            </label>
                                            <input class="form-range range" value="{{ $voucher->discount ?? 20}}" type="range" name='discount'
                                                min="0" max="100" value="0" id="demo-range-input">
                                            @error('discount')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="example-datemin">Date Expiry</label>
                                            <input type="date" name="date_expiry"
                                                class="form-control @error('date_expiry'){{ 'is-invalid' }}@enderror"
                                                id="example-datemin" min="2000-01-02" value="{{old('date_expiry')}}">
                                            @error('date_expiry')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

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
