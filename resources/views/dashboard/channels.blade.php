@extends('layouts.dashboard')
@section('css')
    <style>
        .missed-config {
            border-left: 4px solid red !important;
        }

        .heading {
            font-size: 0.8rem !important;
        }
        .error{
            color: #ff5b5b;
            font-size: 14px;
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
    <div class="row">
        @if(count($channels) ==0)
            <div class="col-xl-4 col-md-6 mx-auto">
                <div class="card card-stats">
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
                            <div class="row align-items-center">
                                <div class="col-3">
                                    <div class="avatar avatar-lg rounded-circle shadow">
                                        <img
                                            src="{{ $channel['picture']!=""?$channel['picture']:"https://beta.myplatform.pro/assets/img/icons/common/www.svg" }}">
                                    </div>
                                </div>
                                <div class="col-7">
                                    <h4 class="card-title text-uppercase font-weight-bold mb-0 name"> {{ $channel['name'] }}</h4>
                                    <span class="text mb-0 cmedia">{{ $channel['media']['name'] }}</span>
                                    <div class="status">
                                        @if($channel['status'] == "1")
                                            <span
                                                class="badge badge-pill badge-success channel-status-{{ $channel['id'] }}">Active</span>
                                        @else
                                            <span
                                                class="badge badge-pill badge-danger channel-status-{{ $channel['id'] }}">Disabled</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-2 p-0">
                                    @if($channel['media']->tag == "liveChat")
                                        <a href="#" class="btn text-primary code " data-id="{{ $channel['id'] }}"
                                           data-identifier="{{ $channel['identifier'] }}"
                                           data-key="{{ $channel['authorization']->token }}"
                                           data-responder="{{ $channel['responder']->name }}"
                                           data-created="{{ $channel['created_at'] }}"
                                           data-toggle="tooltip" data-placement="right" title="Show"><i
                                                class="fas fa-eye"></i></a>
                                    @else
                                        <a href="#" class="btn text-primary showChannel" data-id="{{ $channel['id'] }}"
                                           data-responder="{{ isset($channel['responder'])?$channel['responder']->name:"" }}"
                                           data-created="{{ $channel['created_at'] }}"
                                           data-toggle="tooltip" data-placement="right" title="Show"><i
                                                class="fas fa-eye"></i></a>
                                    @endif
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
                    <a href="{{ $media['tag']=="liveChat"?"#":$media['redirectUrl'] }}" {{ $media['tag']=="liveChat"?'role=button data-target=#newLiveChat data-toggle=modal':"" }}>
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary save">Save changes</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="newLiveChat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" id="modal-form" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add live chat page</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label" >Name</label>
                        <input type="text" class="form-control" id="nameChat" required>
                    </div>
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Responder</label>
                        <select class="form-control" id="liveResponders" required>
                            @foreach($responders as $responder)
                                <option value="{{ $responder['id'] }}">{{ $responder['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Picture</label>
                        <input type="file" class="custom-control" id="pictureChat" name="file">
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="chatstatus">
                            <label class="custom-control-label" for="chatstatus">Enabled</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary addLivePage">Save changes</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="liveChatCode" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" id="modal-form" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Channel details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12 text-center mb-2">
                    <div class="avatar avatar-lg rounded-circle shadow" style="width: 100px;height: 100px;">
                        <img class="pic" src="https://beta.myplatform.pro/assets/img/icons/common/www.svg">
                    </div>
                    <h4 class="name">name</h4>
                    <h4 class="text-muted cmedia">facebook</h4>
                </div>
                <div class="col">
                    <div class="card-profile-stats d-flex justify-content-center">
                        <div>
                            <span class="heading status"><span class="badge badge-success">Active</span></span>
                            <span class="description">Status</span>
                        </div>
                        <div>
                            <span class="heading responder">Facebook </span>
                            <span class="description">Responder</span>
                        </div>
                        <div>
                            <span class="heading created">09-11-1888</span>
                            <span class="description">Created</span>
                        </div>
                    </div>
                </div>
                <hr>
                <h4>Integrate a live chat bot into your landing page with the a very simple way.</h4>
                <h5 class="text-muted">Copy the code down below and paste it into your page then go to your web page you
                    will find the chat bot there</h5>
                <small class="text-danger "><i class="fas fa-exclamation-circle"></i> Attention !! Don't change the
                    "key" or "authrisation" value.</small>
                <pre style="background-color:#2b2b2b; color: whitesmoke" class="mt-2">
<span style="color: yellow">&lt;script </span>src=<span style="color: yellowgreen">"https://beta.myplatform.pro/sdk/Messenger.js"&gt;</span><span
                        style="color: yellow"> &lt;/script&gt;</span>
<span style="color: yellow">&lt;script&gt;</span>
<span style="color: darkorange"> var</span> messenger = new messenger({
        welcomeMSG: <span style="color: yellowgreen">"Welcome , to my chat bot let's talk"</span>,
        key:"<span class="identifier" style="color: darkgreen">25875969852</span>",
        authorisation:"<span class="key" style="color: darkgreen">25875969852</span>",
       });
<span style="color: yellow">&lt;/script&gt;</span>
	            </pre>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary copy">Copy</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="show" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" id="modal-form" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Channel details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-12 text-center">
                        <div class="avatar avatar-lg rounded-circle shadow" style="width: 100px;height: 100px;">
                            <img class="pic" src="https://beta.myplatform.pro/assets/img/icons/common/www.svg">
                        </div>
                        <h4 class="name">name</h4>
                        <h4 class="text-muted cmedia">facebook</h4>
                    </div>
                    <div class="col">
                        <div class="card-profile-stats d-flex justify-content-center">
                            <div>
                                <span class="heading status"><span class="badge badge-success">Active</span></span>
                                <span class="description">Status</span>
                            </div>
                            <div>
                                <span class="heading responder">Facebook </span>
                                <span class="description">Responder</span>
                            </div>
                            <div>
                                <span class="heading created">09-11-1888</span>
                                <span class="description">Created</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('javascript')
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

    <script>
        var id;
        $(document).on('click', '.edit', function () {
            id = $(this).data('id');
            $('#responders option[value="' + $(this).data('responder') + '"]').attr('selected', true);
            $('#status').attr('checked', $(this).data('status') == 1 ? true : false);
            $('#channelDetails').modal('show');
        });
        $(document).on('click', '.showChannel', function () {
            $('#show .cmedia').text($(this).parent().parent().find('.cmedia').text());
            $('#show .name').text($(this).parent().parent().find('.name').text());
            $('#show .status').html($(this).parent().parent().find('.status').html());
            $('#show .pic').attr('src',$(this).parent().parent().find('img').attr('src'));
            $('#show .created').text($(this).data('created'));
            $('#show .responder').text($(this).data('responder'));
            $('#show').modal('show');
        });
        $('.addLivePage').click(function () {
            if($("#addForm").valid()) {
                var formData = new FormData($("#addForm")[0]);
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('name', $('#nameChat').val());
                formData.append('responder_id', $('#liveResponders').val());
                formData.append('status', $('#chatstatus').is(':checked') ? 1 : 0);
                $.ajax({
                    url: "{{ route('ajax.liveChat.add') }}",
                    type: "POST",
                    data: formData,
                    success: function (data) {
                        if (data.code == "success") {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Channel saved successfully !',
                            });
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        });
        $('.code').click(function () {
            $('#liveChatCode .cmedia').text($(this).parent().parent().find('.cmedia').text());
            $('#liveChatCode .name').text($(this).parent().parent().find('.name').text());
            $('#liveChatCode .status').html($(this).parent().parent().find('.status').html());
            $('#liveChatCode .pic').attr('src',$(this).parent().parent().find('img').attr('src'));
            $('#liveChatCode .created').text($(this).data('created'));
            $('#liveChatCode .responder').text($(this).data('responder'));
            $('.identifier').text($(this).data('identifier'));
            $('.key').text($(this).data('key'));
            $('#liveChatCode').modal('show');
        });
        $('.copy').click(function () {
            let input = $('<input type="hidden" value="' + $(this).parent().parent().find('pre') + '">')
            input.focus();
            input.select();
            document.execCommand('copy');
            $(this).removeClass('btn-outline-primary').addClass('btn-outline-success');
            $(this).text('Copied');
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
                        $('.channel-status-' + id).replaceWith(status == 1 ? '<span class="badge badge-pill badge-success channel-status-' + id + '">Active</span>' : '<span class="badge badge-pill badge-danger channel-status-' + id + '">Disabled</span>').remove();
                    }
                }
            });
        });
        $('.delete').click(function () {
            let element = $(this);
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
