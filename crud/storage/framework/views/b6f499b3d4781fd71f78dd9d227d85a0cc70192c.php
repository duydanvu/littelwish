<?php $__env->startSection('content'); ?>
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="card uper">
        <div class="card-header">
            Edit Share
        </div>
        <div class="card-body">
            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div><br />
            <?php endif; ?>
            <form method="post" action="<?php echo e(route('shares.update', $share->id)); ?>">
                <?php echo method_field('PATCH'); ?>
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label for="name">Share Name:</label>
                    <input type="text" class="form-control" name="share_name" value=<?php echo e($share->share_name); ?> />
                </div>
                <div class="form-group">
                    <label for="price">Share Price :</label>
                    <input type="text" class="form-control" name="share_price" value=<?php echo e($share->share_price); ?> />
                </div>
                <div class="form-group">
                    <label for="quantity">Share Quantity:</label>
                    <input type="text" class="form-control" name="share_qty" value=<?php echo e($share->share_qty); ?> />
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\crud\resources\views/shares/edit.blade.php ENDPATH**/ ?>