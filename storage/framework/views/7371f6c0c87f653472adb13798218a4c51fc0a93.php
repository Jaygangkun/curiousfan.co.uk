

<?php $__env->startSection('section_title'); ?>
    <?php if($userEdit == true): ?>
        <strong>Edit User</strong>
    <?php else: ?>
        <strong>Create New User</strong>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('section_body'); ?>
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.2/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
    

    <div class="row">
        <div class="col-md-12">
            <?php if($userEdit == true && $editUser->id): ?>
            <form method="POST" action="/admin/view-user/update/<?php echo e($editUser->id); ?>"  enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" name="user_id" value="<?php echo e($editUser->id); ?>">
            <?php else: ?>
            <form method="POST" action="/admin/add-user/"  enctype="multipart/form-data" autocomplete="off">
            <?php endif; ?>
                <?php echo e(csrf_field()); ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Name</strong></label>
                            <input type="text" name="name" id="name" disabled value="<?php if($userEdit == true): ?><?php echo e($editUser->name); ?><?php endif; ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email_address">Email</label>
                            <input type="email" name="email_address" disabled id="email_address" value="<?php if($userEdit == true): ?><?php echo e($editUser->email); ?><?php endif; ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" autocomplete="off" name="password" disabled id="password" value="" class="form-control" title="Password must contain: Minimum 8 characters atleast 1 Alphabet and 1 Number" <?php if($userEdit == false): ?> required <?php endif; ?> pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password1">Retype Password</label>
                            <input type="password" name="password1" autocomplete="off" disabled id="password1" value="" class="form-control" <?php if($userEdit == false): ?> required <?php endif; ?>>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="box-header with-border"><strong>Profile Details</strong>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select name="category" id="category" class="form-control" required>
                                <option value="">Please Select</option>
                                <?php $__currentLoopData = $all_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($userEdit == true): ?>
                                    <option value="<?php echo e($c->id); ?>" <?php if($c->id == $editUser->profile->category_id): ?> selected <?php endif; ?>><?php echo e($c->category); ?></option>
                                    <?php else: ?>
                                    <option value="<?php echo e($c->id); ?>" ><?php echo e($c->category); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="isCreating">User Type</label>
                                <select id="isCreating" name="isCreating" class="form-control">
                                    <option value="No" <?php if($userEdit == true && $editUser->isCreating == 'No'): ?> selected <?php endif; ?>>Standard User</option>
                                    <option value="Yes" <?php if($userEdit == true && $editUser->isCreating == 'Yes'): ?> selected <?php endif; ?>>Creators Account</option>
                                </select>
                        </div>
                    </div>
                    <?php if($userEdit == true): ?>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <label >Profile Picture View</label>
                                <a href="<?php echo e(asset('public/uploads/' . $editUser->profile->profilePic)); ?>" target="_blank">
                                    <img src="<?php echo e(asset('public/uploads/' . $editUser->profile->profilePic)); ?>" width="100%" class="img-responsive"/>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="profilePic">Update Profile Picture (Min 200x200)</label>
                                    <input id="profilePic" name="profilePic" type="file" class="file" data-preview-file-type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <label >Cover Picture View</label>
                                <a href="<?php echo e(asset('public/uploads/' . $editUser->profile->coverPic)); ?>" target="_blank">
                                    <img src="<?php echo e(asset('public/uploads/' . $editUser->profile->coverPic)); ?>" width="100%" class="img-responsive"/>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="coverPic">Update Cover Picture (Min 960x280)</label>
                                    <input id="coverPic" name="coverPic" type="file" class="file" data-preview-file-type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="profilePic">Profile Picture (Min 200x200)</label>
                            <input id="profilePic" name="profilePic" type="file" class="file" data-preview-file-type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cover_picture">Cover Picture (Min 960x280)</label>
                            <input id="coverPic" name="coverPic" type="file" class="file" data-preview-file-type="text">
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="creates">Headline</label>
                            <textarea name="creates" id="creates" class="form-control"><?php if($userEdit == true): ?><?php echo e($editUser->profile->creating); ?><?php endif; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="box-header with-border"><strong>Social Profiles</strong></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fbUrl">Facebook</label>
                            <input type="text" name="fbUrl" id="fbUrl" value="<?php if($userEdit == true): ?><?php echo e($editUser->profile->fbUrl); ?><?php endif; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="instagram">Instagram</label>
                            <input type="text" name="instaUrl" id="instaUrl" value="<?php if($userEdit == true): ?><?php echo e($editUser->profile->instaUrl); ?><?php endif; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="twUrl">Twitter</label>
                            <input type="text" name="twUrl" id="twUrl" value="<?php if($userEdit == true): ?><?php echo e($editUser->profile->twUrl); ?><?php endif; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="youtube">Youtube</label>
                            <input type="text" name="ytUrl" id="ytUrl" value="<?php if($userEdit == true): ?><?php echo e($editUser->profile->ytUrl); ?><?php endif; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="twitchUrl">Twitch</label>
                            <input type="text" name="twitchUrl" id="twitchUrl" value="<?php if($userEdit == true): ?><?php echo e($editUser->profile->twitchUrl); ?><?php endif; ?>" class="form-control">
                        </div>
                    </div>
                </div>
                <?php
                if($userEdit == true){
                    $customD = json_decode($editUser->profile->custom_data);
                    //print_r($customD);
                };
                ?>
                <div class="row">
                    <div class="box-header with-border"><strong>Manual Subscribers & Fans</strong></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="subscriber">Subscriber</label>
                            <input type="number" name="subscriber" id="subscriber" value="<?php if($userEdit == true && !empty($customD->subscribers)): ?><?php echo e(@$customD->subscribers); ?><?php elseif($userEdit == true && empty($customD->subscribers)): ?><?php echo e(@$profileData->followers->count()); ?><?php endif; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fans">Fans</label>
                            <input type="number" name="fans" id="fans" value="<?php if($userEdit == true && !empty($customD->fans)): ?><?php echo e(@$customD->fans); ?><?php else: ?><?php echo e(@$profileData->fans_count); ?><?php endif; ?>" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="box-header with-border"><strong>Profile Notes</strong></div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <textarea name="profile_note" id="profile_note" class="form-control"><?php if($userEdit == true): ?><?php echo e(@$customD->admin_note); ?><?php endif; ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <br>
                        <input type="submit" name="sb" value="<?php if($userEdit == true): ?> Update User <?php else: ?> Add New User <?php endif; ?>" class="btn btn-primary btn-block">
                    </div>
                </div>

            </form>
        </div><!-- /.col-xs-12 col-md-6 -->
    </div><!-- /.row -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.2/js/plugins/piexif.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.2/js/plugins/sortable.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.2/js/fileinput.min.js"></script>
    <script type="text/javascript">
        window.onload = function () {
            var txtPassword = document.getElementById("password");
            var txtConfirmPassword = document.getElementById("password1");
            txtPassword.onchange = ConfirmPassword;
            txtConfirmPassword.onkeyup = ConfirmPassword;
            function ConfirmPassword() {
                txtConfirmPassword.setCustomValidity("");
                if (txtPassword.value != txtConfirmPassword.value) {
                    txtConfirmPassword.setCustomValidity("Passwords do not match.");
                }
            }
        }
        function getRidOffAutocomplete(){

            var timer = window.setTimeout( function(){
                    $('#password,#name,#email_address,#password1').prop('disabled',false);
                    clearTimeout(timer);
                },
                800);
        }

        // Invoke the function, handle page load autocomplete by chrome.
        getRidOffAutocomplete();
    </script>
    <script>
        $.fn.fileinputBsVersion = "3.3.7";
        $("#profilePic, #coverPic").fileinput({
            'showUpload':true,
            'previewFileType':'any',
            'browseClass': "btn btn-success btn-block",
            'showCaption': false,
            'showRemove': true,
            'maxFileCount': 1,
            'allowedFileTypes': ["image"],
            //'elErrorContainer': "#errorBlock"
            //allowedFileExtensions: ["jpg", "gif", "png", "txt"]
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/admin/user-action.blade.php ENDPATH**/ ?>