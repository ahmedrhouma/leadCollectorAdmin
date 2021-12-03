<?php $__env->startSection('css'); ?>
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
    <div class="row">
        <?php if(count($channels) ==0): ?>
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
        <?php else: ?>
            <?php $__currentLoopData = $channels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $channel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-xl-3 col-md-4 channel">
                    <div class="card card-stats <?php if($channel['responder_id'] == ""): ?> missed-config <?php endif; ?>">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-3">
                                    <div class="avatar avatar-lg rounded-circle shadow">
                                        <img
                                            src="<?php echo e($channel['picture']!=""?$channel['picture']:"https://beta.myplatform.pro/assets/img/icons/common/www.svg"); ?>">
                                    </div>
                                </div>
                                <div class="col-7">
                                    <h4 class="card-title text-uppercase font-weight-bold mb-0 name"> <?php echo e($channel['name']); ?></h4>
                                    <span class="text mb-0 cmedia"><?php echo e($channel['media']['name']); ?></span>
                                    <div class="status">
                                        <?php if($channel['status'] == "1"): ?>
                                            <span
                                                class="badge badge-pill badge-success channel-status-<?php echo e($channel['id']); ?>">Active</span>
                                        <?php else: ?>
                                            <span
                                                class="badge badge-pill badge-danger channel-status-<?php echo e($channel['id']); ?>">Disabled</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-2 p-0">
                                    <?php if($channel['media']->tag == "liveChat"): ?>
                                        <a href="#" class="btn text-primary code " data-id="<?php echo e($channel['id']); ?>"
                                           data-identifier="<?php echo e($channel['identifier']); ?>"
                                           data-key="<?php echo e($channel['authorization']->token); ?>"
                                           data-responder="<?php echo e($channel['responder']->name); ?>"
                                           data-created="<?php echo e($channel['created_at']); ?>"
                                           data-toggle="tooltip" data-placement="right" title="Show"><i
                                                class="fas fa-eye"></i></a>
                                    <?php else: ?>
                                        <a href="#" class="btn text-primary showChannel" data-id="<?php echo e($channel['id']); ?>"
                                           data-responder="<?php echo e(isset($channel['responder'])?$channel['responder']->name:""); ?>"
                                           data-created="<?php echo e($channel['created_at']); ?>"
                                           data-toggle="tooltip" data-placement="right" title="Show"><i
                                                class="fas fa-eye"></i></a>
                                    <?php endif; ?>
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
                    <a href="<?php echo e($media['tag']=="liveChat"?"#":$media['redirectUrl']); ?>" <?php echo e($media['tag']=="liveChat"?'role=button data-target=#newLiveChat data-toggle=modal':""); ?>>
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
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label" >Name</label>
                        <input type="text" class="form-control" id="nameChat" required>
                    </div>
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Responder</label>
                        <select class="form-control" id="liveResponders" required>
                            <?php $__currentLoopData = $responders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $responder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($responder['id']); ?>"><?php echo e($responder['name']); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php $__env->startSection('javascript'); ?>
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
                formData.append('_token', '<?php echo e(csrf_token()); ?>');
                formData.append('name', $('#nameChat').val());
                formData.append('responder_id', $('#liveResponders').val());
                formData.append('status', $('#chatstatus').is(':checked') ? 1 : 0);
                $.ajax({
                    url: "<?php echo e(route('ajax.liveChat.add')); ?>",
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
                        url: "<?php echo e(route('ajax.channels.delete')); ?>",
                        type: 'POST',
                        data: {id: $(this).data('id'),_token : '<?php echo e(csrf_token()); ?>'},
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

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\leadCollector\resources\views/dashboard/channels.blade.php ENDPATH**/ ?>