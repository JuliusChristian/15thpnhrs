<?php $__env->startSection('content'); ?>
<div class="text-center">
<?php if(strlen($msg) > 0): ?>
	<div class="row">
		<div class="alert alert-success"><?php echo e($msg); ?></div>
	</div>
<?php endif; ?>
	<h3>
		There are no active events taking place at this time.
		<br>
		Please try again later...
	</h3>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.ereg_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>