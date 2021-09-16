@extends('layouts.dashboard')

<!-- Header -->
@section('header')
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Configuration</h6>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- Content -->
@section('content')
    <div class="row">
        <div class="col-xl-10 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Webhooks confguration </h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="heading-small text-muted mb-4">To receive messages and other events sent by Lead Collector, the app should enable webhooks integration.</h6>
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-username">Callback URL</label>
                                    <input type="url" id="input-username" class="form-control" placeholder="url"
                                           value="https://example.xyz/leadCollector/receive" disabled>
                                </div>
                                <h5 class="text-muted">Validation requests and Leadcollector notifications for this
                                    object will be sent to this URL.</h5>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">Verify Token</label>
                                    <input type="password" id="input-email" class="form-control"
                                           placeholder="*****************" disabled>
                                </div>
                                <h5 class="text-muted">Token that Leadcollector will echo back to you as part of
                                    callback URL verification.</h5>
                            </div>
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="text-right">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit">
                            Edit Callback URL
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" id="modal-form" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Callback URL</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    @csrf
                    <div class="form-group">
                        <label class="form-control-label" for="input-username">Callback URL</label>
                        <input type="url" id="callbackURL" class="form-control"
                               placeholder="Validation requests and Webhook notifications for this object will be sent to this URL.">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="token">Verify Token</label>
                        <input type="text" id="token" class="form-control"
                               placeholder="Token that LeadCollector will echo back to you as part of callback URL verification.">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-sm save">Verify and Save</button>
            </div>
        </div>
    </div>
</div>

@section('javascript')
    <script>
        $('.save').click(function () {
            let _token = $("input[name='_token']").val();
            $.ajax({
                url: $('#callbackURL').val(),
                type: 'POST',
                data: {hub_challenge: _token, hub_mode: "subscribe", hub_verify_token: $('#token').val()},
                success: function (data) {
                    if (data == _token) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'User added successfully !',
                        });
                    } else if (data.code == "success") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data,
                        })
                    }
                },
                error: function (data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data,
                    })
                }
            });
        })
    </script>
@endsection

