<?php $__env->startSection('section_title'); ?>
    <strong>Website Messages</strong>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('section_body'); ?>

    <div class="row">
        <div class="col-md-12">
            <?php if( empty( $name ) ): ?>
                    <?php else: ?>
                        <form method="POST" action="/admin/update_website-messages">
                            <input type="hidden" name="id" value="<?php echo e($msgID); ?>">
                            <?php endif; ?>
                            <?php echo e(csrf_field()); ?>

                            <div class="row">
                                <div class="col-md-4">
                                    <label for="msgName">Name</label>
                                    <input type="text" name="name" id="msgName" value="<?php echo e($name); ?>" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="msgGet">Message</label>
                                    <input type="text" name="msg" id="msgGet" value="<?php echo e($msg); ?>" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="msgGet">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" <?php if($status == 1): ?> selected <?php endif; ?>>Enable</option>
                                        <option value="0" <?php if($status == 0): ?> selected <?php endif; ?>>Disable</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <br>
                                    <input type="submit" name="sb" value="Save Message" class="btn btn-primary">
                                </div>
                            </div>

                        </form>
        </div><!-- /.col-xs-12 col-md-6 -->
    </div><!-- /.row -->

    <br/>
    <hr/>

    <?php if($messages): ?>
        <table class="table table-striped table-bordered table-responsive dataTable">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Message</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                        <?php echo e($m->id); ?>

                    </td>
                    <td>
                        <?php echo e($m->name); ?>

                    </td>
                    <td>
                        <?php echo e($m->msg); ?>

                    </td>
                    <td>
                        <?php if($m->status == 1): ?>
                            <span style="color:green;font-weight:bold;">Enabled</span>
                        <?php else: ?>
                            <span style="color:red;font-weight:bold;">Disabled</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-primary btn-xs" href="/admin/website-messages?update=<?php echo e($m->id); ?>">
                                <i class="glyphicon glyphicon-pencil"></i>
                            </a>
                            
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php else: ?>
        No messages in database.
    <?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/admin/website-messages.blade.php ENDPATH**/ ?>