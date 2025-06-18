<?php $__env->startSection('content'); ?>
    <h1>Daftar Produk</h1>
    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div>
            <a href="<?php echo e(route('products.show', $product)); ?>"><?php echo e($product->name); ?></a> - Rp<?php echo e(number_format($product->price,0,',','.')); ?>

        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php if(auth()->guard()->check()): ?>
        <?php if(auth()->user()->role === 'admin'): ?>
            <a href="<?php echo e(route('products.create')); ?>">Tambah Produk</a>
        <?php endif; ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\jualan2\resources\views/products/index.blade.php ENDPATH**/ ?>