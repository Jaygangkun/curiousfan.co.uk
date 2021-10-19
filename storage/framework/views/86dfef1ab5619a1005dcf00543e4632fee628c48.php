<?php $__env->startSection('section_title'); ?>
    <?php if($type == 'create'): ?>
        <strong>Add New Email Templates</strong>
    <?php elseif($type == 'edit'): ?>
        <strong>Edit Email Templates</strong>
    <?php else: ?>
        <strong>Email Templates</strong>
    <a href="/admin/email-templates/create" class="btn btn-success">Add New Email Template</a>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('section_body'); ?>
    <?php if($type == 'create' || $type == 'edit'): ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.9.2/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#emailBody',
            height: 500,
            plugins: [
                'advlist autolink link image lists charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks code fullscreen insertdatetime media nonbreaking',
                'table emoticons template paste help'
            ],
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | link image media | ' +
                'forecolor backcolor emoticons',
            menu: {
                favs: {title: 'My Favorites', items: 'code visualaid | searchreplace | emoticons'}
            },
            menubar: 'favs file edit view insert format tools table help'
        });
    </script>
    <div class="row">
        <div class="col-md-12">
                <?php if($type == 'edit'): ?>
                    <form method="POST" action="/admin/email-templates/<?php echo e($templateData->id); ?>">
                    <input type="hidden" name="upid" value="<?php if(isset($templateData->id)): ?><?php echo e($templateData->id); ?><?php endif; ?>">
                     <?php echo e(method_field('PATCH')); ?>

                <?php else: ?>
                        <form method="POST" action="/admin/email-templates/">
                <?php endif; ?>
                <?php echo e(csrf_field()); ?>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" value="<?php if(isset($templateData->name)): ?><?php echo e($templateData->name); ?><?php endif; ?>" class="form-control" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="emailSubject">Email Subject</label>
                        <input type="text" name="emailSubject" id="emailSubject" value="<?php if(isset($templateData->emailSubject)): ?><?php echo e($templateData->emailSubject); ?><?php endif; ?>" class="form-control" required>
                    </div>
                    
                    <div class="col-md-12 form-group">
                        <label for="emailBody">Email Body</label>
                        <textarea id="emailBody" name="emailBody"><?php if(isset($templateData->emailBody)): ?><?php echo e($templateData->emailBody); ?><?php endif; ?></textarea>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="msgGet">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1" <?php if(isset($templateData->status) && $templateData->status == 1): ?> selected <?php endif; ?>>Enable</option>
                            <option value="0" <?php if(isset($templateData->status) && $templateData->status == 0): ?> selected <?php endif; ?>>Disable</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <br>
                        <input type="submit" name="submit" value="Save Email Template" class="btn btn-primary">
                    </div>
                    <div class="col-md-12">
                        <hr>
                        <p style="text-transform: uppercase;color:red;font-weight: bold;">Use following shortcodes to render the data</p>
                        <hr>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Global Template Tags:</strong> <br>
                            Application Name = {APP_NAME}<br>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p>
                            <p><strong>Content Reported Template Tags:</strong> <br>
                            Reporter Name = {reporter_name}<br>
                            Reported URL = {reported_url}<br>
                            Reporter IP = {reporter_ip}<br>
                            View Abuse Reports Link = {view_abuse_report_link}<br>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Creator Paid Subscriber Template Tags:</strong> <br>
                            Creator Name = {name}<br>
                            Subscriber Name = {subscriber_name}<br>
                            Subscriber Handle = {subscriber_handle}<br>
                            Subscriber Profile URL = {subscriber_profile_url}<br>
                            My subscribers Link = {my_subscribers}<br>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Payment Action Required Template Tags:</strong> <br>
                            Name = {name}<br>
                            Invoice Amount = {invoice_amount}<br>
                            Profile Link = {profile_link}<br>
                            Profile Handle = {profile_handle}<br>
                            Invoice URL = {invoice_url}<br>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>New payment request Template Tags:</strong> <br>
                            Withdraw Amount = {withdraw_amount}<br>
                            Withdraw Username  = {withdraw_username}<br>
                            Withdraw User Profile Link = {withdraw_user_profile}<br>
                            Withdraw User Profile Handle = {withdraw_user_handle}<br>
                            Payment Requests URL = {payment_requests_url}<br>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Payment processed! Paid Template Tags:</strong> <br>
                            Withdraw Username = {withdraw_username}<br>
                            Withdraw Amount  = {withdraw_amount}<br>
                            Withdraw Payout Gateway = {withdraw_payout_gateway}<br>
                            Withdraw Payout Details =>{withdraw_payout_details}<br>
                        </p><br>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Profile Rejected Email Template Tags:</strong> <br>
                            Username = {username}<br>
                            Profile Link  = {profile_link}<br>
                            Profile Handle = {profile_handle}<br>
                            Sending Email =>{sending_mail}<br>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Profile Verified Email Template Tags:</strong> <br>
                            Username = {username}<br>
                            Profile Link  = {profile_link}<br>
                            Profile Handle = {profile_handle}<br>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Tip Receive Email Template Tags:</strong> <br>
                            Username = {name}<br>
                            Tipper Name = {tipper_name}<br>
                            Tipper Profile Link = {tipper_profile_link}<br>
                            Tipper Handle = {tipper_handle}<br>
                            Tip Amount = {tip_amount}<br>
                            Tip Post Link = {tip_post_link}<br>
                            My Tips Link = {my_tips}<br>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Unlock Message Email Template Tags:</strong> <br>
                            Username = {name}<br>
                            Unlock Tipper Name = {unlock_tipper_name}<br>
                            Unlock Tipper Profile Link = {unlock_tipper_profile_username}<br>
                            Unlock Tipper Handle = {unlock_tipper_profile_handle}<br>
                            Unlock Tip Amount = {unlock_creator_amount}<br>
                            All Notification Link = {notifications_link}<br>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Profile Verification Requested Email Template Tags:</strong> <br>
                            Username = {username}<br>
                            All Verifications Request = {verification_requests}<br>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Reset Password Email Template Tags:</strong> <br>
                            Reset URL = {reset_link}<br>
                        </p>
                    </div>
                </div>
            </form>
        </div><!-- /.col-xs-12 col-md-6 -->
    </div><!-- /.row -->
    <?php else: ?>
    <?php if($emailTemplates): ?>
        <table class="table table-striped table-bordered table-responsive dataTable">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email Subject</th>
                <th>Sent From</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $emailTemplates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                        <?php echo e($e->id); ?>

                    </td>
                    <td>
                        <?php echo e($e->name); ?>

                    </td>
                    <td>
                        <?php echo e($e->emailSubject); ?>

                    </td>
                    <td>
                        <?php echo e($e->senderName); ?> <<?php echo e($e->sentFrom); ?>>
                    </td>
                    <td>
                        <?php if($e->status == 1): ?>
                            <span style="color:green;font-weight:bold;">Enabled</span>
                        <?php else: ?>
                            <span style="color:red;font-weight:bold;">Disabled</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-primary btn-xs" href="/admin/email-templates/<?php echo e($e->id); ?>/edit">
                                <i class="glyphicon glyphicon-pencil"></i>
                            </a>
                            <a href="#" onclick="return confirm('Are you sure you want to remove this category from database?');" data-formid="#submitForm_<?php echo e($e->id); ?>" class="btn btn-danger btn-xs submitForm">
                                <i class="glyphicon glyphicon-remove"></i>
                            </a>
                            <form action="/admin/email-templates/<?php echo e($e->id); ?>" method="POST" id="submitForm_<?php echo e($e->id); ?>">
                                <?php echo e(csrf_field()); ?>

                                <?php echo e(method_field('DELETE')); ?>

                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php else: ?>
        No messages in database.
    <?php endif; ?>
<?php endif; ?>
    <script>
        $(document).ready(function() {
            $('.submitForm').on('click', function (){
                let getFormid = $(this).data('formid');
                $(getFormid).submit();
            })
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/admin/email-templates.blade.php ENDPATH**/ ?>