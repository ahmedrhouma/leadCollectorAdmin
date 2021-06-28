@extends('layouts.dashboard')

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
                        <a href="{{ $url }}" class="btn btn-primary">Add New channel</a>
                    </div>
                </div>
            </div>
        @else
            @foreach($channels as $channel)
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="avatar avatar-lg rounded-circle shadow">
                                        <img src="{{ $channel['picture'] }}">
                                    </div>
                                </div>
                                <div class="col">
                                    <h5 class="card-title text-uppercase font-weight-bold mb-0"> {{ $channel['name'] }}</h5>
                                    <span class="text mb-0">{{ $channel['media']['name'] }}</span>
                                </div>
                            </div>
                            {{--<p class="mt-3 mb-0 text-sm">
                                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                                <span class="text-nowrap">Since last month</span>
                            </p>--}}
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

