@extends('layouts.layout')

<!-- Header -->
@section('content')
    <div class="header bg-gradient-primary py-lg-6">
        <div class="container">
            <div class="header-body text-center mb-7">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8 px-5">
                        <h1 class="text-white">Reset Password!</h1>
                        <p class="text-lead text-white">Looks like you forget your password! don't worry you can reset it here.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="separator separator-bottom separator-skew zindex-100">
            <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
                 xmlns="http://www.w3.org/2000/svg">
                <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
    </div>
    <!-- Page content -->
    <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card bg-secondary border-0 mb-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center text-muted mb-4">
                            <small>Please write your new password</small>
                        </div>
                        <form role="form" method="post" action="">
                            @csrf
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="Password" type="password" name="password">
                                </div>
                                @error('password')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="Confirm Password" type="password" name="password_confirmation">
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary my-4 " name="reset">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <a href="{{ route('login') }}" class="text-light"><small>Sign in</small></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $('.reset').click(function () {
            let _token = $("input[name='_token']").val();
            if ( $('.Email').val()!==""){
                $.ajax({
                    url: "{{ route('ajax.reset.password') }}",
                    type: 'POST',
                    data: {_token: _token, email: $('.Email').val()},
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
                                text: data.messages,
                            });
                        }
                    }
                });

            }
        })
    </script>
@endsection
