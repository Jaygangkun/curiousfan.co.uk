<?php $__env->startSection('section_title'); ?>
<strong>Users Management</strong>
<a href="/admin/add-user/">Add New User</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('section_body'); ?>
	
	<table class="table dataTable">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Subscribers</th>
		<th>Fans</th>
        <th>Type</th>
        <th>Is Admin</th>
        <th>IP Address</th>
        <th>Join Date</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td><?php echo e($u->id); ?></td>
        <td><?php echo e($u->name); ?></td>
        <td>
            <?php echo e($u->email); ?>

            <br>
            <?php if($u->email_verified_at): ?>
                <span style="color:green;font-weight:bold;">Email Verified</span>
            <?php else: ?>
                <span style="color:red;font-weight:bold;">Email Unverified</span><br />
                <a href="/admin/verify/email/<?php echo e($u->id); ?>">Verify Email Now</a>
            <?php endif; ?>
            <br><br>
            <?php if($u->profile->isVerified == 'Yes'): ?>
                <span style="color:green;font-weight:bold;">ID Verified</span> | <span><a target="_blank" href="<?php echo e(@\Storage::disk($u->profile->user_meta['verificationDisk'])->url($u->profile->user_meta['id'])); ?>">View ID</a></span>
            <?php else: ?>
                <span style="color:red;font-weight:bold;">ID Unverified</span><br />
                <a href="/admin/verifications/new/<?php echo e($u->id); ?>">Verify ID Now</a>
            <?php endif; ?>
        </td>
        <?php
            $customD = json_decode($u->profile->custom_data);
        ?>
        <td>
            <?php echo e($u->followers_count); ?> (Original)<br>
            <?php if(@$customD->subscribers): ?><?php echo e(@$customD->subscribers); ?> (Added by admin) <?php endif; ?>
        </td>
        <td>
            <?php echo e($u->subscribers_count); ?> (Original)<br>
            <?php if(@$customD->fans): ?><?php echo e(@$customD->fans); ?> (Added by admin) <?php endif; ?>
		</td>
		<td>
			<?php if($u->isCreating == 'Yes'): ?>
				Creator
			<?php else: ?>
				User
			<?php endif; ?>
        </td>
        <td>
            <?php echo e($u->isAdmin); ?>

            <br>
            <?php if($u->isAdmin == 'Yes'): ?> 
                <a href="/admin/users/unsetadmin/<?php echo e($u->id); ?>">Unset Admin Role</a>
            <?php elseif($u->isAdmin == 'No'): ?>
                <a href="/admin/users/setadmin/<?php echo e($u->id); ?>">Set Admin Role</a>
            <?php endif; ?>
        </td>
        <td>
            <?php echo e($u->ip ? $u->ip : 'N/A'); ?>

            <br>
            <?php if($u->isBanned == 'No'): ?>
				<a href="/admin/users/ban/<?php echo e($u->id); ?>">Ban</a>
            <?php elseif($u->isBanned == 'Yes'): ?>
				<a href="/admin/users/unban/<?php echo e($u->id); ?>">Unban</a>
            <?php endif; ?>
			<br>
			<?php if($u->bannedIP == 'YES'): ?>
				<a href="/admin/users/unbanip/<?php echo e($u->id); ?>">Unban IP</a>
				
            <?php elseif($u->bannedIP != 'Yes'): ?>
				<a href="/admin/users/banip/<?php echo e($u->id); ?>">Ban IP</a>
            <?php endif; ?>
			
        </td>
		<td><?php echo e($u->created_at->format( 'jS F Y' )); ?></td>
        <td>
            <a href="/admin/view-user/<?php echo e($u->id); ?>">Edit User</a><br>
            <a href="/admin/add-plan/<?php echo e($u->id); ?>">Add Plan Manually</a><br>
            
            <a href="/admin/loginAs/<?php echo e($u->id); ?>" onclick="return confirm('This will log you out as an admin and login as a vendor. Continue?')">Login as User</a>

            <br>
            <br>
            <a href="/admin/users?remove=<?php echo e($u->id); ?>" onclick="return confirm('Are you sure you want to delete this user and his data? This is irreversible!!!')" class="text-danger">Delete User & His Data</a>
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
<?php echo $__env->make('admin.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/admin/users.blade.php ENDPATH**/ ?>