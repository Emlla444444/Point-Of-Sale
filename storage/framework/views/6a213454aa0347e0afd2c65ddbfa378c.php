<?php $__env->startSection('content'); ?>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4 col">
            <div class="card-header py-3">
                <div class="">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">Admin Profile ( Role - <span
                                class="text-danger"><?php echo e(auth()->user()->role); ?></span> )
                        </h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-3">

                        <img class="img-profile img-thumbnail" id="output"
                            src="<?php echo e(asset(auth()->user()->profile == null ? 'default_image/defaultProfile.jpg' : 'profileImage/'.auth()->user()->profile)); ?>">

                    </div>
                    <div class="col">

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">
                                        <i class="fa-solid fa-file-signature me-2"></i> <b>Name</b></label>
                                    <h6><?php echo e(auth()->user()->name); ?></h6>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">
                                        <i class="fa-solid fa-message me-2"></i> <b>Email</b></label>
                                    <h6><?php echo e(auth()->user()->email); ?></h6>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">
                                        <i class="fa-solid fa-phone me-2"></i> <b>Phone</b></label>
                                    <h6><?php echo e(auth()->user()->phone); ?></h6>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">
                                        <i class="fa-solid fa-location-arrow me-2"></i> <b>Address</b></label>
                                    <h6><?php echo e(auth()->user()->address); ?></h6>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label for="exampleFormControlInput1" class="form-label">
                                    <i class="fa-solid fa-clock me-2"></i> <b>Created at</b></label>
                                <h6><?php echo e(auth()->user()->created_at); ?></h6>
                                <a href="<?php echo e(route('profile#changePassword')); ?>"><i class="fa-solid fa-key"></i> change password</a>
                            </div>
                        </div>
                        <a href="<?php echo e(route('profile#edit')); ?>" class="btn btn-primary mt-3">Edit</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/macbookpro2015/Desktop/POS_Project/resources/views/admin/profile/detail.blade.php ENDPATH**/ ?>