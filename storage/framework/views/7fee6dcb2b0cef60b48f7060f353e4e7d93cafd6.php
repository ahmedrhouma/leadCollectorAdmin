<!-- Header -->
<?php $__env->startSection('header'); ?>
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
<?php $__env->stopSection(); ?>
<!-- Content -->
<?php $__env->startSection('content'); ?>
    <div class="row">
        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-xl-3 col-md-6">
                <div class="card card-stats">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Title</h5>
                                <div>
                                    <?php if($user['status'] == "1"): ?>
                                        <span class="badge badge-pill badge-success user-status-<?php echo e($user['id']); ?>">Active</span>
                                    <?php else: ?>
                                        <span class="badge badge-pill badge-danger user-status-<?php echo e($user['id']); ?>">Disabled</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <a href="#" class="btn btn-sm btn-neutral scopes" data-toggle="modal"
                                   data-target="#scopesDetails" data-id="<?php echo e($user['id']); ?>">Scopes</a>
                                <a href="#" class="btn btn-sm btn-neutral logs" data-toggle="modal"
                                   data-target="#logs" data-id="<?php echo e($user['id']); ?>">Logs</a>
                            </div>
                        </div>
                        <div class="input-group mt-4">
                            <input type="text" class="form-control" aria-label="Access key"
                                   aria-describedby="button-addon2" value="<?php echo e($user['token']); ?>">
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary btn-sm copy" type="button">Copy
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="modal fade" id="scopesDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" id="modal-form" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">User scopes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="form-group col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="all" id="all">
                                    <label class="custom-control-label" for="all">All</label>
                                </div>
                                <hr class="mt-1">
                            </div>
                            <?php $__currentLoopData = $scopes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $scope): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="form-group col-12">
                                    <h5><?php echo e($key); ?></h5>
                                </div>
                                <?php $__currentLoopData = $scope; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="form-group col-6">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="<?php echo e($action); ?>"
                                                   id="<?php echo e($action); ?>">
                                            <label class="custom-control-label" for="<?php echo e($action); ?>"><?php echo e($key); ?></label>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary save">Save changes</button>
                        <button type="button" class="btn btn-primary saveUser">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="logs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <script>
        $('.copy').click(function () {
            $(this).parent().parent().find('input').focus();
            $(this).parent().parent().find('input').select();
            document.execCommand('copy');
            $(this).removeClass('btn-outline-primary').addClass('btn-outline-success');
            $(this).text('Copied');
        });
        $('#all').click(function () {
            $('#scopesDetails input').attr('checked', $(this).is(':checked'));
        });
        $('.newUser').click(function () {
            $('.saveUser').show();
            $('.save').hide();
        });
        $('.scopes').click(function () {
            $('.saveUser').hide();
            $('.save').show();
        });
        $('.saveUser').click(function () {
            let _token = $("#scopesDetails input[name='_token']").val();
            let scopes = $('#scopesDetails .custom-control-input').serializeArray();
            let status = 0;
            $.ajax({
                url: "<?php echo e(route('ajax.accessKeys.add')); ?>",
                type: 'POST',
                data: {_token: _token, scopes: scopes, status: status},
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
                        // $('.channel-status-'+id).replaceWith(status == 1?'<span class="badge badge-pill badge-success channel-status-'+id+'">Active</span>':'<span class="badge badge-pill badge-danger channel-status-'+id+'">Disabled</span>').remove();
                    }
                }
            });
        })
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /usr/local/apache/htdocs/leadCollector/resources/views/dashboard/users.blade.php ENDPATH**/ ?>