

<?php $__env->startSection('section_title'); ?>
<strong>Block & Report Users Management</strong>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('section_body'); ?>
	
	<table class="table dataTable">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Request Type</th>
        <th>Content</th>
		<th>Requester Name</th>
        <th>Reqeuster Email</th>
        <th>Request Date</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $reportUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td><?php echo e($u->id); ?></td>
        <td><?php echo e($u->user->name); ?></td>
        <td><?php echo e($u->user->email); ?></td>
        <td><?php echo e($u->report_type); ?></td>
        <td><?php echo e($u->report_content); ?></td>
        <td><?php echo e($u->reported_user->name); ?></td>
        <td><?php echo e($u->reported_user->email); ?></td>
        <td><?php echo e($u->created_at->format( 'jS F Y' )); ?></td>
        <td>
            <a href="/admin/block-report-users/delete/<?php echo e($u->id); ?>" onclick="return confirm('Are you sure you want to delete this report?')" class="text-danger">Delete & Clear this report</a>
        </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
	</table>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra_bottom'); ?>
	<?php if(count($errors) > 0): ?>
	    <div class="alert alert-danger">
	        <ul>
	            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                <li><?php echo e($error); ?></li>
	            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	        </ul>
	    </div>
	<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/admin/block-report-users.blade.php ENDPATH**/ ?>