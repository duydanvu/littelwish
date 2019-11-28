<?php $__env->startSection('content'); ?>
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="card uper">
        <div class="card-header">
            Add Share
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
            <form method="post" action="<?php echo e(route('shares.store')); ?>">
                <div class="form-group">
                    <?php echo csrf_field(); ?>
                    <label for="name">Share Name:</label>
                    <input type="text" class="form-control" name="share_name"/>
                </div>
                <div class="form-group">
                    <label for="price">Share Price :</label>
                    <input type="text" class="form-control" name="share_price"/>
                </div>
                <div class="form-group">
                    <label for="quantity">Share Quantity:</label>
                    <input type="text" class="form-control" name="share_qty"/>
                </div>
                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\crud\resources\views/shares/create.blade.php ENDPATH**/ ?>