

<?php $__env->startSection('section_title'); ?>
<strong>Send Notification to All users or Individual user</strong>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('section_body'); ?>

<form method="POST" action="/admin/send_notification">
<?php echo e(csrf_field()); ?>

    
<dl>
<dt>Notification Title</dt>
<dd><input type="text" name="notification_title" class="form-control" required="required" ></dd>
<br>
<dt>Notification Content</dt>
<dd><textarea name="notification_content" class="form-control" rows="8"></textarea></dd>
<dt>&nbsp;</dt>
<br>

<dd>
    <input type="radio" name="target_type" value="1" id="all" > <label for="all" >All</label>  &nbsp;&nbsp;&nbsp;<input type="radio" name="target_type" value="0" id="individual"> <label for="individual" >Individual User</label> 
    <select name="user" id="users_list" disabled>
        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($u->id); ?>">
                <?php echo e($u->name); ?> - ( <?php echo e($u->email); ?> )
            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</dd> 
<br>
<dd><input type="submit" name="sb_page" class="btn btn-primary" value="Send Notification"></dd>
</dl>

</form>
 
<script type='text/javascript'>
	
	$(function() {
	    $("#individual").click(function(){
	        $("#users_list").prop('disabled', false)
	    })
	    
	    $("#all").click(function(){
	        $("#users_list").prop('disabled', true)
	    })
	});

</script> 

 
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/admin/notifications.blade.php ENDPATH**/ ?>