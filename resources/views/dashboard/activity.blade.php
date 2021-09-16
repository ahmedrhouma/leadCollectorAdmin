@extends('layouts.dashboard')
@section('css')
    <style>
        body{margin-top:20px;}
        .timeline {
            border-left: 3px solid #727cf5;
            border-bottom-right-radius: 4px;
            border-top-right-radius: 4px;
            background: rgba(114, 124, 245, 0.09);
            margin: 0 auto;
            letter-spacing: 0.2px;
            position: relative;
            line-height: 1.4em;
            font-size: 1.03em;
            padding: 50px;
            list-style: none;
            text-align: left;
            max-width: 40%;
        }

        @media (max-width: 767px) {
            .timeline {
                max-width: 98%;
                padding: 25px;
            }
        }

        .timeline h1 {
            font-weight: 300;
            font-size: 1.4em;
        }

        .timeline h2,
        .timeline h3 {
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .timeline .event {
            border-bottom: 1px dashed #e8ebf1;
            padding-bottom: 25px;
            margin-bottom: 25px;
            position: relative;
        }

        @media (max-width: 767px) {
            .timeline .event {
                padding-top: 30px;
            }
        }

        .timeline .event:last-of-type {
            padding-bottom: 0;
            margin-bottom: 0;
            border: none;
        }

        .timeline .event:before,
        .timeline .event:after {
            position: absolute;
            display: block;
            top: 0;
        }

        .timeline .event:before {
            left: -300px;
            content: attr(data-date);
            text-align: right;
            font-weight: 100;
            font-size: 0.9em;
            min-width: 120px;
        }

        @media (max-width: 767px) {
            .timeline .event:before {
                left: 0px;
                text-align: left;
            }
        }

        .timeline .event:after {
            -webkit-box-shadow: 0 0 0 3px #727cf5;
            box-shadow: 0 0 0 3px #727cf5;
            left: -55.8px;
            background: #fff;
            border-radius: 50%;
            height: 9px;
            width: 9px;
            content: "";
            top: 5px;
        }

        @media (max-width: 767px) {
            .timeline .event:after {
                left: -31.8px;
            }
        }

        .rtl .timeline {
            border-left: 0;
            text-align: right;
            border-bottom-right-radius: 0;
            border-top-right-radius: 0;
            border-bottom-left-radius: 4px;
            border-top-left-radius: 4px;
            border-right: 3px solid #727cf5;
        }

        .rtl .timeline .event::before {
            left: 0;
            right: -170px;
        }

        .rtl .timeline .event::after {
            left: 0;
            right: -55.8px;
        }
    </style>
@endsection
<!-- Header -->
@section('header')
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Activity</h6>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- Content -->
@section('content')
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div id="content">
                            <ul class="timeline">
                                <li class="event" data-date="09 May 2021 12:30 - 1:00pm">
                                    <h3>Registration</h3>
                                    <p>Your account has been created.</p>
                                </li>
                                <li class="event" data-date="09 May 2021 2:30 - 4:00pm">
                                    <h3>Create channel</h3>
                                    <p>You have created the channel "best fighties" from the media Facebook.</p>
                                </li>
                                <li class="event" data-date="09 May 2021 5:00 - 8:00pm">
                                    <h3>Create responder</h3>
                                    <p>You have created the responder "facebook Resonder"</p>
                                </li>
                                <li class="event" data-date="09 Jul 2021 8:30 - 9:30pm">
                                    <h3>Responder assigned to channel</h3>
                                    <p>You have assigned responder "facebook Resonder" to the channel "best fighties"</p>
                                </li>
                                <li class="event" data-date="09 Aug 2021 8:30 - 9:30pm">
                                    <h3>Channel updated</h3>
                                    <p>You have activated the channel "best fighties".</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('javascript')

@endsection

