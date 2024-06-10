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
                            <li class="breadcrumb-item">Authorization</li>

                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Authorization : {{ $group->group_name }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" bis_skin_checked="1">
            <div class="card-header" bis_skin_checked="1">
                <h5>Permission</h5>
            </div>
            <div class="card-body all" bis_skin_checked="1">

            </div>
        </div>
    </div>
    <input type="text" data-arr="{{ $group->permissions }}" style="display: none" id='permissions'>
@endsection
@push('scripts')
    <script>
        showLoader();
        $(document).ready(function() {
            var url = `{{ URL::to('admin/modules') }}`;
            var token = '{{ csrf_token() }}';
            var id = '{{ $group->id }}';
            $.ajax({
                url: url,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                "method": "GET",
                success: function(response) {
                    stopLoader();

                    var permission = document.querySelector('#permissions').dataset.arr;
                    if(permission){
                        permission =JSON.parse(permission);
                    }
                    var all = document.querySelector('.all');
                    for (actions of response) {
                        var tag = `<div class="mb-3 row align-items-center" bis_skin_checked="1">
                                        <label class="col-sm-2 text-md-start col-form-label ps-5"><a
                                                class="text-primary">${actions.module_name.charAt(0).toUpperCase() + actions.module_name.slice(1)} : </a></label>
                                        <div class="col-sm-9 d-flex gap-4 " bis_skin_checked="1">`;
                        actions.module_action = JSON.parse(actions.module_action);
                        for (var i = 0; i < actions.module_action.length; i++) {
                            var check = '';
                            if (permission && actions.module_name in permission && permission[actions.module_name]
                                .includes(actions.module_action[i])) {
                                check = 'checked';
                            }
                            tag += `   <div class="form-check form-switch custom-switch-v1 mb-2" bis_skin_checked="1">
                                    <input type="checkbox" class="form-check-input input-primary"
                                        name="${actions.module_name}"
                                        id="customCheckdefh_${actions.module_name}_${actions.module_action[i]}"
                                        data-module="${actions.module_name}" data-actions="${actions.module_action[i]}"
                                        ${check} 
                                        >
                                    <label class="form-check-label"
                                        for="customCheckdefh_${actions.module_name}_${actions.module_action[i]}">${actions.module_action[i].charAt(0).toUpperCase() +actions.module_action[i].slice(1) }</label>
                                </div>`
                        }
                        tag += `   </div>
                                        </div>`
                        all.insertAdjacentHTML('afterend', tag);
                    }
                    document.querySelectorAll('input[type=checkbox]').forEach(element => {
                        element.addEventListener('change', function() {
                            
                            var turn= 0;
                            if (this.checked) turn = 1;
                            var data = {
                                module: this.dataset.module,
                                actions: this.dataset.actions,
                                turn: turn,
                                id: id
                            }
                            $.ajax({
                                url: `{{ URL::to('admin/groups/authorization/${id}') }}`,
                                headers: {
                                    'X-CSRF-TOKEN': token
                                },
                                data: data,
                                "method": "POST",
                                success: function(response) {
                                       console.log('Sucess...');
                                },
                                error: function(xhr, status, error) {
                                    console.log(xhr);
                                }
                            })
                        })
                    });

                },
                error: function(xhr, status, error) {

                }

            });
        })
    </script>
@endpush
