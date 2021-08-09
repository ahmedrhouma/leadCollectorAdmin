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
<?php $__env->stopSection(); ?>
<!-- Content -->
<?php $__env->startSection('content'); ?>
    <!-- Card stats -->
    <div class="row">
        <?php if(count($channels) ==0): ?>
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
        <?php else: ?>
            <?php $__currentLoopData = $channels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $channel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-xl-3 col-md-4 channel">
                    <div class="card card-stats <?php if($channel['responder_id'] == ""): ?> missed-config <?php endif; ?>">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <div class="avatar avatar-lg rounded-circle shadow">
                                        <img src="<?php echo e($channel['picture']); ?>">
                                    </div>
                                </div>
                                <div class="col-7">
                                    <h4 class="card-title text-uppercase font-weight-bold mb-0"> <?php echo e($channel['name']); ?></h4>
                                    <span class="text mb-0"><?php echo e($channel['media']['name']); ?></span>
                                    <div>
                                        <?php if($channel['status'] == "1"): ?>
                                            <span class="badge badge-pill badge-success channel-status-<?php echo e($channel['id']); ?>">Active</span>
                                        <?php else: ?>
                                            <span class="badge badge-pill badge-danger channel-status-<?php echo e($channel['id']); ?>">Disabled</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-2 p-0">
                                    <a href="#" class="btn text-primary edit" data-id="<?php echo e($channel['id']); ?>"
                                       data-responder="<?php echo e($channel['responder_id']); ?>"
                                       data-status="<?php echo e($channel['status']); ?>"
                                       data-toggle="tooltip" data-placement="right" title="Edit"><i
                                            class="fas fa-edit"></i></a>
                                    <a href="#" class="btn text-danger delete" data-id="<?php echo e($channel['id']); ?>"
                                       data-toggle="tooltip" data-placement="right" title="Delete"><i
                                            class="far fa-trash-alt"></i></a>
                                </div>
                            </div>
                            <?php if($channel['responder_id'] == ""): ?>
                                <p class="mt-3 mb-0 text-danger">
                                    <span class="text-lg"><i class="fas fa-exclamation-circle"></i></span>
                                    <span class="text-nowrap text-sm"> Responder configuration is Missing!</span>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" id="modal-form" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <?php $__currentLoopData = $medias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $media): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e($media['redirectUrl']); ?>">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-auto">
                                        <div class="avatar avatar-lg rounded-circle shadow">
                                            <img src="<?php echo e(asset('assets/img/icons/common/'.$media['tag'].'.svg')); ?>">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h5 class="card-title text-uppercase font-weight-bold mb-0"> <?php echo e($media['name']); ?></h5>
                                        <span class="text mb-0">Add some <?php echo e($media['name']); ?> pages.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Responder</label>
                        <select class="form-control" id="responders">
                            <?php $__currentLoopData = $responders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $responder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($responder['id']); ?>"><?php echo e($responder['name']); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php $__env->startSection('javascript'); ?>
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
                url: "<?php echo e(route('ajax.channels.update')); ?>",
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
                        url: "<?php echo e(route('ajax.channels.delete')); ?>",
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /usr/local/apache/htdocs/leadCollector/resources/views/dashboard/channels.blade.php ENDPATH**/ ?>