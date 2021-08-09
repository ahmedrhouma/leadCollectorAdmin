@extends('layouts.dashboard')
@section('css')
    <style>
        .missed-config {
            border-left: 4px solid red !important;
        }
    </style>
@endsection
<!-- Header -->
@section('header')
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Channels</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <button class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#exampleModal">Add New
                        channel
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- Content -->
@section('content')
    <!-- Card stats -->
    <div class="row">
        @if(count($channels) ==0)
            <div class="col-xl-4 col-md-6 mx-auto">
                <div class="card card-stats">
                    <!-- Card body -->
                    <div class="card-body text-center">
                        <h5 class="card-title text-uppercase">No channel recorded !</h5>
                        <p class="text-muted">You'll need to connect pages and grant them the required permissions in
                            order for tokens to be generated</p>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            Add New channel
                        </button>
                    </div>
                </div>
            </div>
        @else
            @foreach($channels as $channel)
                <div class="col-xl-3 col-md-4 channel">
                    <div class="card card-stats @if($channel['responder_id'] == "") missed-config @endif">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <div class="avatar avatar-lg rounded-circle shadow">
                                        <img src="{{ $channel['picture'] }}">
                                    </div>
                                </div>
                                <div class="col-7">
                                    <h4 class="card-title text-uppercase font-weight-bold mb-0"> {{ $channel['name'] }}</h4>
                                    <span class="text mb-0">{{ $channel['media']['name'] }}</span>
                                    <div>
                                        @if($channel['status'] == "1")
                                            <span class="badge badge-pill badge-success channel-status-{{ $channel['id'] }}">Active</span>
                                        @else
                                            <span class="badge badge-pill badge-danger channel-status-{{ $channel['id'] }}">Disabled</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-2 p-0">
                                    <a href="#" class="btn text-primary edit" data-id="{{ $channel['id'] }}"
                                       data-responder="{{ $channel['responder_id'] }}"
                                       data-status="{{ $channel['status'] }}"
                                       data-toggle="tooltip" data-placement="right" title="Edit"><i
                                            class="fas fa-edit"></i></a>
                                    <a href="#" class="btn text-danger delete" data-id="{{ $channel['id'] }}"
                                       data-toggle="tooltip" data-placement="right" title="Delete"><i
                                            class="far fa-trash-alt"></i></a>
                                </div>
                            </div>
                            @if($channel['responder_id'] == "")
                                <p class="mt-3 mb-0 text-danger">
                                    <span class="text-lg"><i class="fas fa-exclamation-circle"></i></span>
                                    <span class="text-nowrap text-sm"> Responder configuration is Missing!</span>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" id="modal-form" role="document">
        <div class="modal-content">
            <div class="modal-body">
                @foreach($medias as $media)
                    <a href="{{ $media['redirectUrl'] }}">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-auto">
                                        <div class="avatar avatar-lg rounded-circle shadow">
                                            <img src="{{ asset('assets/img/icons/common/'.$media['tag'].'.svg') }}">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h5 class="card-title text-uppercase font-weight-bold mb-0"> {{ $media['name'] }}</h5>
                                        <span class="text mb-0">Add some {{ $media['name'] }} pages.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="channelDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" id="modal-form" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form>
                    @csrf
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Responder</label>
                        <select class="form-control" id="responders">
                            @foreach($responders as $responder)
                                <option value="{{ $responder['id'] }}">{{ $responder['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="status">
                            <label class="custom-control-label" for="status">Enabled</label>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>
@section('javascript')
    <script>
        var id;
        $(document).on('click', '.edit', function () {
            id = $(this).data('id');
            $('#responders option[value="' + $(this).data('responder') + '"]').attr('selected', true);
            $('#status').attr('checked', $(this).data('status') == 1?true:false);
            $('#channelDetails').modal('show');
        });
        $('.save').click(function () {
            let _token = $("input[name='_token']").val();
            let responder = $("#responders").val();
            let status = $("#status").is(':checked') ? 1 : 0;
            $.ajax({
                url: "{{ route('ajax.channels.update') }}",
                type: 'POST',
                data: {_token: _token, id: id, responder: responder, status: status},
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
                            text: 'Channel updated successfully !',
                        })
                        $('.channel-status-'+id).replaceWith(status == 1?'<span class="badge badge-pill badge-success channel-status-'+id+'">Active</span>':'<span class="badge badge-pill badge-danger channel-status-'+id+'">Disabled</span>').remove();
                    }
                }
            });
        });
        $('.delete').click(function () {
            let element =$(this);
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('ajax.channels.delete') }}",
                        type: 'POST',
                        data: {id: $(this).data('id')},
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
                                    text: 'Channel deleted successfully !',
                                });
                                element.parents('.channel').remove();
                            }
                        }
                    });
                }
            })
        })
    </script>
@endsection
