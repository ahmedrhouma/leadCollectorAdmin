<?php $__env->startSection('css'); ?>
    <style>
        .single-table {
            background: #fff;
            transition: all 0.2s linear;
            z-index: 1;
            /* Bubble Float Right */
        }
        .single-table .plan-header {
            background: #e67e22;
            color: #fff;
            text-transform: capitalize;
            padding: 2px 0;
        }
        .single-table .plan-header h3 {
            margin: 0;
            padding: 20px 0 5px 0;
            text-transform: uppercase;
        }
        .single-table .plan-price {
            display: inline-block;
            color: #e67e22;
            margin: 0 0 10px 0;
            font-size: 25px;
            font-weight: bold;
            background: #fff;
            border-radius: 50%;
            color: #e67e22;
            padding: 33px 15px;
        }
        .single-table .plan-price span {
            font-size: 14px;
            font-weight: normal;
        }
        .single-table ul {
            margin: 0;
            padding: 20px 0;
            list-style: none;
        }
        .single-table ul li {
            padding: 8px 0;
            margin: 0 20px;
            border-bottom: 1px solid white;
            font-size: 15px;
        }
        .single-table .plan-submit {
            display: inline-block;
            text-decoration: none;
            margin: 20px 0 30px 0;
            padding: 10px 40px;
            border: 1px solid #e67e22;
            color: #e67e22;
            font-size: 15px;
            text-transform: uppercase;
            border-radius: 3px;
            transition: all 0.25s linear;
        }
        .single-table .plan-submit:hover {
            background: #e67e22;
            color: #FFF;
            transition: all 0.25s linear;
        }
        .single-table .hvr-bubble-float-right {
            display: inline-block;
            vertical-align: middle;
            transform: translateZ(0);
            box-shadow: 0 0 1px rgba(0, 0, 0, 0);
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            -moz-osx-font-smoothing: grayscale;
            position: relative;
            transition-duration: 0.3s;
            transition-property: transform;
        }
        .single-table .hvr-bubble-float-right:before {
            position: absolute;
            z-index: -1;
            top: calc(50% - 10px);
            right: 0;
            content: "";
            border-style: solid;
            border-width: 10px 0 10px 10px;
            border-color: transparent transparent transparent transparent;
            transition-duration: 0.3s;
            transition-property: transform;
        }
        .single-table .hvr-bubble-float-right:hover,
        .single-table .hvr-bubble-float-right:focus,
        .single-table .hvr-bubble-float-right:active {
            transform: translateX(-10px);
        }
        .single-table .hvr-bubble-float-right:hover:before,
        .single-table .hvr-bubble-float-right:focus:before,
        .single-table .hvr-bubble-float-right:active:before {
            transform: translateX(10px);
            border-color: transparent transparent transparent #e67e22;
        }

        .color-2 .single-table .plan-header {
            background: #3498db;
            color: #fff;
        }
        .color-2 .single-table .plan-header .plan-price {
            color: #3498db;
            background: #fff;
        }
        .color-2 .single-table .plan-submit {
            border: 1px solid #3498db;
            color: #3498db;
        }
        .color-2 .single-table .plan-submit:hover {
            background: #3498db;
            color: #FFF;
        }
        .color-2 .hvr-bubble-float-right:hover:before,
        .color-2 .hvr-bubble-float-right:focus:before,
        .color-2 .hvr-bubble-float-right:active:before {
            transform: translateX(10px);
            border-color: transparent transparent transparent #3498db;
        }

        .color-3 .single-table .plan-header {
            background: #2ecc71;
            color: #fff;
        }
        .color-3 .single-table .plan-header .plan-price {
            color: #2ecc71;
            background: #fff;
        }
        .color-3 .single-table .plan-submit {
            border: 1px solid #2ecc71;
            color: #2ecc71;
        }
        .color-3 .single-table .plan-submit:hover {
            background: #2ecc71;
            color: #FFF;
        }
        .color-3 .hvr-bubble-float-right:hover:before,
        .color-3 .hvr-bubble-float-right:focus:before,
        .color-3 .hvr-bubble-float-right:active:before {
            transform: translateX(10px);
            border-color: transparent transparent transparent #2ecc71;
        }

        .color-4 .single-table .plan-header {
            background: #9b59b6;
            color: #fff;
        }
        .color-4 .single-table .plan-header .plan-price {
            color: #9b59b6;
            background: #fff;
        }
        .color-4 .single-table .plan-submit {
            border: 1px solid #9b59b6;
            color: #9b59b6;
        }
        .color-4 .single-table .plan-submit:hover {
            background: #9b59b6;
            color: #FFF;
        }
        .color-4 .hvr-bubble-float-right:hover:before,
        .color-4 .hvr-bubble-float-right:focus:before,
        .color-4 .hvr-bubble-float-right:active:before {
            transform: translateX(10px);
            border-color: transparent transparent transparent #9b59b6;
        }
    </style>
<?php $__env->stopSection(); ?>
<!-- Header -->
<?php $__env->startSection('header'); ?>
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Pricing</h6>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<!-- Content -->
<?php $__env->startSection('content'); ?>
    <section id="pricing-tables">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12 color-1">
                <div class="single-table text-center">
                    <div class="plan-header">
                        <h3>basic</h3>
                        <p>plan for basic user</p>
                        <h4 class="plan-price">$30<span>/5 K request</span></h4>
                    </div>


                    <ul class="text-center">
                        <li>1000 contacts</li>
                        <li>Forms</li>
                        
                    </ul>
                    <a href="#" class="plan-submit hvr-bubble-float-right">buy now</a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12 color-2">
                <div class="single-table text-center">
                    <div class="plan-header">
                        <h3>advanced</h3>
                        <p>plan for basic user</p>
                        <h4 class="plan-price">$30<span>/50 K requests</span></h4>
                    </div>


                    <ul class="text-center">
                        <li>1000 contacts</li>
                        <li>Forms</li>
                        <li>Data matching</li>
                        
                    </ul>
                    <a href="#" class="plan-submit hvr-bubble-float-right">buy now</a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12 color-3">
                <div class="single-table text-center">
                    <div class="plan-header">
                        <h3>premium</h3>
                        <p>plan for basic user</p>
                        <h4 class="plan-price">$30<span>/100 K request</span></h4>
                    </div>


                    <ul class="text-center">
                        <li>1000 contacts</li>
                        <li>Data matching</li>
                        <li>Live chat plugin</li>
                        <li>Forms</li>
                        <li>Social media comments</li>
                        <li>Automated posts</li>
                    </ul>
                    <a href="#" class="plan-submit hvr-bubble-float-right">buy now</a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12 color-4">
                <div class="single-table text-center">
                    <div class="plan-header">
                        <h3>gold</h3>
                        <p>plan for basic user</p>
                        <h4 class="plan-price">$300<span>/infinity requests</span></h4>
                    </div>


                    <ul class="text-center">
                        <li>1000 contacts</li>
                        <li>Data matching</li>
                        <li>Live chat plugin</li>
                        <li>Forms</li>
                        <li>Social media comments</li>
                        <li>Automated posts</li>
                    </ul>
                    <a href="#" class="plan-submit hvr-bubble-float-right">buy now</a>
                </div>
            </div>

        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\leadCollectorV2\resources\views/dashboard/pricing.blade.php ENDPATH**/ ?>