@extends('layouts.dashboard')

<!-- Header -->
@section('header')
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Dashboard</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="#" class="btn btn-sm btn-neutral newUser" data-toggle="modal" data-target="#scopesDetails">New
                        user</a>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- Content -->
@section('content')
    <div class="row">
        @foreach($users as $user)
            <div class="col-xl-3 col-md-4">
                <div class="card card-stats">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">{{ $user['name'] }}</h5>
                                <div>
                                    @if($user['status'] == "1")
                                        <span class="badge badge-pill badge-success user-status-{{ $user['id'] }}">Active</span>
                                    @else
                                        <span class="badge badge-pill badge-danger user-status-{{ $user['id'] }}">Disabled</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-auto">
                                <a href="#" class="btn btn-sm btn-neutral scopes" data-toggle="modal"
                                   data-target="#scopesDetails" data-id="{{ $user['id'] }}">Scopes</a>
                                <a href="#" class="btn btn-sm btn-neutral logs" data-toggle="modal"
                                   data-target="#userslogs" data-id="{{ $user['id'] }}">Logs</a>
                            </div>
                        </div>
                        <div class="input-group mt-4">
                            <input type="text" class="form-control" aria-label="Access key"
                                   aria-describedby="button-addon2" value="{{ $user['token'] }}">
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary btn-sm copy" type="button">Copy
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="modal fade" id="scopesDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" id="modal-form" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">User scopes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="userForm">
                        @csrf
                        <div class="row">
                            <div class="form-group col-8">
                                <label for="name" class="form-control-label">Title</label>
                                <input class="form-control" type="text" id="name">
                            </div>
                            <div class="form-group col-4 d-flex align-items-center">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="Active" id="Active">
                                    <label class="custom-control-label" for="Active">Active</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="all" id="all">
                                    <label class="custom-control-label" for="all">All</label>
                                </div>
                            </div>
                            @foreach($scopes as $key => $scope)
                                <div class="form-group col-6">
                                    <hr class="mt-1">
                                    <a data-toggle="collapse" href="#{{ $key }}" role="button" aria-expanded="false"
                                       aria-controls="{{ $key }}" class="clpsBtn">
                                        <h5 class="text-capitalize">{{ $key }} <i
                                                class="fas fa-chevron-up float-right arrowL"></i>
                                            <i
                                                class="fas fa-chevron-down float-right arrowL"
                                                style="display: none"></i>
                                        </h5>
                                    </a>
                                    <div id="{{ $key }}" class="collapse row mt-4">
                                        @foreach($scope as $key => $action)
                                            <div class="form-group col-6">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                           name="{{$action}}"
                                                           id="{{$action}}" data-Saction="{{$action}}">
                                                    <label class="custom-control-label"
                                                           for="{{$action}}">{{$key}}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save">Save changes</button>
                    <button type="button" class="btn btn-primary saveUser">Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="userslogs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" id="modal-form" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">User log</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table align-items-center">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="action">Action</th>
                            <th scope="col" class="sort" data-sort="created_at">Date create</th>
                        </tr>
                        </thead>
                        <tbody class="list">

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        var id ;
        $('.copy').click(function () {
            $(this).parent().parent().find('input').focus();
            $(this).parent().parent().find('input').select();
            document.execCommand('copy');
            $(this).removeClass('btn-outline-primary').addClass('btn-outline-success');
            $(this).text('Copied');
        });
        $('#all').click(function () {
            $('#scopesDetails input[type="checkbox"]').prop('checked', $(this).is(':checked'));
        });
        $('.newUser').click(function () {
            $('#userForm')[0].reset();
            $('.saveUser').show();
            $('.save').hide();
        });
        $('.scopes').click(function () {
            $('#userForm')[0].reset();
            $('.saveUser').hide();
            $('.save').show();
            let _token = $("#scopesDetails input[name='_token']").val();
            id = $(this).data('id');
            $.ajax({
                url: "{{ route('ajax.accessKeys.show') }}",
                type: 'POST',
                data: {_token: _token, id: id},
                success: function (res) {
                    if (res.code == "success") {
                        $.each(JSON.parse(res.data.scopes), function (i, scope) {
                            $("input[data-Saction='" + scope + "']").attr('checked', true);
                        });
                        $("#name").val(res.data.name);
                        $("#Active").attr('checked',res.data.status==1?true:false);
                    }
                }
            });
        });
        $('.logs').click(function () {
            $('#userslogs tbody').empty();
            let _token = $("#scopesDetails input[name='_token']").val();
            let id = $(this).data('id');
            $.ajax({
                url: "{{ route('ajax.logs.list') }}",
                type: 'POST',
                data: {_token: _token, id: id},
                success: function (res) {
                    if (res.code == "success") {
                        $.each(res.data, function (i, log) {
                            $('#userslogs tbody').append('<tr><td>' + log.action + ' ' + log.element + '</td><td>' + log.created_at + '</td></tr>');
                        });
                        $("#name").val(res.data.name);
                        $('.save').show();
                    }
                }
            });
        });
        $('.saveUser').click(function () {
            let _token = $("#scopesDetails input[name='_token']").val();
            let name = $("#name").val();
            if (name.toUpperCase() === "ADMIN") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "Name reserved for admin !",
                });
                return 0;
            }
            let scopes = $('#scopesDetails .custom-control-input').serializeArray();
            let status = 0;
            $.ajax({
                url: "{{ route('ajax.accessKeys.add') }}",
                type: 'POST',
                data: {_token: _token, scopes: scopes, status: status, name: name},
                success: function (data) {
                    if (data.code == "error") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.messages,
                        })
                    } else if (data.code == "success") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'User added successfully !',
                        });
                    }
                }
            });
        });
        $('.save').click(function () {
            let _token = $("#scopesDetails input[name='_token']").val();
            let name = $("#name").val();
            let status = $("#Active").is(':checked')?1:0;
            let scopes = $('#scopesDetails .custom-control-input').serializeArray();
            $.ajax({
                url: "{{ route('ajax.accessKeys.edit') }}",
                type: 'POST',
                data: {_token: _token, scopes: scopes, status: status, name: name, id: id},
                success: function (data) {
                    if (data.code == "error") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.messages,
                        })
                    } else if (data.code == "success") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Key updated successfully !',
                        });
                    }
                }
            });
        });

        $('.clpsBtn').click(function () {
            $(this).find('.arrowL').toggle();
        });
    </script>
@endsection

