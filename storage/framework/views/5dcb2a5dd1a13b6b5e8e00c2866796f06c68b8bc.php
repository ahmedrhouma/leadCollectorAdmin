<?php $__env->startSection('css'); ?>
    <style>
        .missed-config {

            border-left: 4px solid red !important;
        }

    </style>
<?php $__env->stopSection(); ?>
<!-- Header -->
<?php $__env->startSection('header'); ?>
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Profile</h6>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<!-- Content -->
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xl-4 order-xl-2">
            <div class="card card-profile">
                <img src="../assets/img/theme/img-1-1000x600.jpg" alt="Image placeholder" class="card-img-top">
                <div class="row justify-content-center">
                    <div class="col-lg-3 order-lg-2">
                        <div class="card-profile-image">
                            <form id="upload-image-form" enctype="multipart/form-data">
                                <label>
                                    <?php echo csrf_field(); ?>
                                    <img
                                        src="<?php echo e(Storage::disk('public')->url("uploads/".Auth::user()->account->id.".png")); ?>"
                                        class="rounded-circle" id="profilePic">
                                    <input type="file" name="file" id="pic" style="display: none">
                                </label>
                            </form>
                        </div>
                    </div>
                </div>
                
                
                
                
                
                
                <div class="card-body pt-5">
                    <div class="row">
                        <div class="col">
                            <div class="card-profile-stats d-flex justify-content-center">
                                <div>
                                    <span class="heading">22</span>
                                    <span class="description">Users</span>
                                </div>
                                <div>
                                    <span class="heading">10</span>
                                    <span class="description">Channels</span>
                                </div>
                                <div>
                                    <span class="heading">89</span>
                                    <span class="description">Packs</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <h5 class="h3"><?php echo e(Auth::user()->account->first_name." ".Auth::user()->account->last_name); ?></span>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Edit profile </h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="updateForm">
                        <?php echo csrf_field(); ?>
                        <h6 class="heading-small text-muted mb-4">User information</h6>
                        <div class="pl-lg-4">

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-first-name">First name</label>
                                        <input type="text" id="input-first-name" class="form-control"
                                               placeholder="First name" value="<?php echo e(Auth::user()->account->first_name); ?>" name="first_name">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-last-name">Last name</label>
                                        <input type="text" id="input-last-name" class="form-control"
                                               placeholder="Last name" value="<?php echo e(Auth::user()->account->last_name); ?>" name="last_name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">Email address</label>
                                        <input type="email" id="input-email" class="form-control"
                                               value="<?php echo e(Auth::user()->account->email); ?>"  name="email">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4">
                        <!-- Address -->
                        <h6 class="heading-small text-muted mb-4">Company information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-city">Company name</label>
                                        <input type="text" id="input-city" class="form-control"
                                               placeholder="Company name"
                                               value="<?php echo e(Auth::user()->account->company_name); ?>"  name="company_name">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-country">Company URL</label>
                                        <input type="url" id="input-country" class="form-control"
                                               placeholder="Company url"
                                               value="<?php echo e(Auth::user()->account->company_url); ?>"  name="company_url">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="button" class="btn btn-primary save">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <script>
        $('#pic').change(function () {
            var formData = new FormData($("#upload-image-form")[0]);
            formData.append('_token', '<?php echo e(csrf_token()); ?>');
            $.ajax({
                url: "<?php echo e(route('ajax.profile.pic')); ?>",
                type: "POST",
                data: formData,
                success: function (data) {
                    if (data.code == "success") {
                        $('#profilePic').attr('src', $("#profilePic").attr("src") + "?timestamp=" + new Date().getTime());
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Picture updated successfully !',
                        });
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
        $('.save').click(function () {
            var formData = new FormData($("#updateForm")[0]);
            formData.append('_token', '<?php echo e(csrf_token()); ?>');
            $.ajax({
                url: "<?php echo e(route('ajax.profile.update')); ?>",
                type: "POST",
                data: formData,
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
                            text: 'profile updated successfully !',
                        });
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /usr/local/apache/htdocs/leadCollector/resources/views/dashboard/profile.blade.php ENDPATH**/ ?>