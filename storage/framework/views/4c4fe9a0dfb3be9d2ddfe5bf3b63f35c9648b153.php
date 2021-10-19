<div>
    <h3 class="title">
    <i class="far fa-envelope"></i> <?php echo app('translator')->get('messages.messages'); ?>
</h3>
<div class="card">
    <div class="row d-flex d-md-none">
        <div class="col-md-12">
            <ul class="box-gridmobPic">
        <?php $__currentLoopData = $people; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="<?php if($toUserId == $p->id): ?> selectedLi <?php endif; ?>">
            <a class="<?php if($p->isOnline()): ?> profilePicOnlineBob <?php else: ?> profilePicOfflineBob <?php endif; ?>" wire:click="clickConversation(<?php echo e($p->id); ?>)">
            <img src="<?php echo e($p->profile->profilePicture); ?>" alt="" width="50" height="50" class="box-img" style="border-radius: 50%;border:2px solid <?php if($p->isOnline()): ?> #4caf50; <?php else: ?> #727272; <?php endif; ?>">
            </a>
            <?php if($this->unreadMessageCount($p->id) > 0): ?>
            <span class="unreadmessagecount">
                <?php echo e($this->unreadMessageCount($p->id)); ?>

            </span>
            <?php endif; ?>
        </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
<div class="row no-gutters">


<div class="d-none d-sm-block d-md-block d-lg-block col-sm-4 col-md-4 col-lg-4 border-right" id="people-container">
    <style>
        .profilePicOnline:after,.profilePicOffline:after{
            width:12px;
            height:12px;
            top:25px;
            right:5px;
        }
        .profilePicOffline:after{
            background: #727272;
        }
        .profilePicOnline:after{
            background: #4caf50;
        }
        .profilePicXS {width:50px;height:50px;}
    </style>
    <?php $__empty_1 = true; $__currentLoopData = $people; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="row no-gutters pt-2 pb-2 border-top" wire:click="clickConversation(<?php echo e($p->id); ?>)" style="cursor:pointer;<?php if($toUserId == $p->id): ?>background: #eee;<?php endif; ?>">
    <div class="col-12 col-sm-12 col-md-2">
    <div class="profilePicXS mt-0 ml-0 mr-2 ml-2 shadow-sm">
        <a class="select-message-user <?php if($p->isOnline()): ?> profilePicOnline <?php else: ?> profilePicOffline <?php endif; ?>">
            <img src="<?php echo e($p->profile->profilePicture); ?>" alt="" width="50" height="50" class="select-message-user">
        </a>
    </div>
    </div>
    <div class="col-12 col-sm-12 col-md-10">
        <a class="d-none d-sm-none d-md-block text-dark select-message-user" wire:click="clickConversation(<?php echo e($p->id); ?>)" >
            <?php echo e($p->profile->name); ?>

        </a>
        <small>
            <a class="text-secondary ml-2 ml-sm-2 ml-md-0 select-message-user" wire:click="clickConversation(<?php echo e($p->id); ?>)">
                <?php echo e($p->profile->handle); ?> 
            </a>
            
            <?php if(isset($unreadMsg) AND count($unreadMsg) AND $lastMsg = $unreadMsg->where('from_id', $p->id)->first()): ?> 
                <?php if($lastMsg->is_read == 'No'): ?>
                    <strong>
                        <?php echo e(substr($lastMsg->message, 0, 55)); ?>

                        <?php if(strlen($lastMsg->message) > 55): ?> ... <?php endif; ?>
                    </strong>
                <?php else: ?>
                    <em>
                        <?php echo e(substr($lastMsg->message, 0, 55)); ?>

                        <?php if(strlen($lastMsg->message) > 55): ?> ... <?php endif; ?>
                    </em>
                <?php endif; ?>
            <?php endif; ?>
            
        </small>
        
        <?php if($this->unreadMessageCount($p->id) > 0): ?>
                <span class="messageNotification">
                    <?php echo e($this->unreadMessageCount($p->id)); ?>

                </span>
                <br>
        <?php endif; ?>
    </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <?php echo app('translator')->get('profile.noSubscriptions'); ?>
    <?php endif; ?>


    <br>
</div>

<div class="col-12 col-sm-8 col-md-8 col-lg-8 border-top" id="messages-container">

<?php if(isset($toName) AND !empty($toName)): ?>

<div class="p-2 text-secondary">
    <strong><?php echo app('translator')->get('messages.to'); ?>: <?php echo e($toName); ?></strong>
    <span style="color:red;font-size:12px;position: absolute;right:10px;cursor: pointer;"
            onclick="confirm('Are you sure you want to delete this conversation?') || event.stopImmediatePropagation()"
            wire:click="deleteConversation('<?php echo e(auth()->id()); ?>', <?php echo e($toUserId); ?>)"
    >Delete Conversation</span>
</div>
<?php else: ?>
<div class="d-flex justify-content-center align-items-center h-100">Please choose a contact and say Hi.</div>
<?php endif; ?>

<?php if(isset($messages) AND count($messages)): ?>
<div class="row no-gutters" wire:poll.3000ms="openConversation(<?php echo e($toUserId); ?>)" style="margin-bottom: 20px;">

    <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($msg->from_id == auth()->id()): ?>
            <div class="col-12 mt-3">
                <div class="text-secondary ml-2" style="z-index: 1;position: absolute;left:10px;font-size:12px;">
                    <img src="<?php echo e(auth()->user()->profile->profilePicture); ?>" alt="" width="40" height="40" class="select-message-user" style="border-radius: 50%;">
                    <span style="font-size: 16px; font-weight: bold;">You | </span>
                    <?php if($msg->is_read == 'Yes'): ?>
                        <i class="fas fa-check-double"></i>
                    <?php else: ?>
                        <i class="fas fa-check-circle"></i>
                    <?php endif; ?>
                    <?php echo e($msg->created_at->diffForHumans()); ?>

                </div>
                <div class="text-white p-2 rounded-right toMessage">
                    <?php echo e($msg->message); ?>

                    <span class="btn delMessage"
                            onclick="confirm('Are you sure you want to delete this message?') || event.stopImmediatePropagation()"
                            wire:click="deleteMessage('<?php echo e($msg->id); ?>', <?php echo e(auth()->id()); ?>, 'sender')"><i class="fa fa-trash"></i></span>

                    <?php if($msg->media->count()): ?>
                        <br>
                        <?php echo $__env->make('messages.message-media', ['media' => $msg->media, 'msg' => $msg, 'utype' => 'toUser'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="col-11 mt-3" style="margin-left: auto;">
                
                    <div class="fromMessage">
                        <span class="btn delMessageFrom"
                                onclick="confirm('Are you sure you want to delete this message?') || event.stopImmediatePropagation()"
                                wire:click="deleteMessage('<?php echo e($msg->id); ?>', <?php echo e(auth()->id()); ?>, 'receiver')"><i class="fa fa-trash"></i></span>
                    <?php echo e($msg->message); ?>


                    <?php if($msg->media->count()): ?>
                        <br>
                        <?php echo $__env->make('messages.message-media', ['media' => $msg->media, 'msg' => $msg, 'utype' => 'fromUser'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                </div>
                <div class="text-right">
                    <div class="text-secondary ml-2" style="z-index: 1;position: absolute;right:20px;font-size:12px;">
                        <?php
                            $msg->is_read = 'Yes';
                            $msg->save();
                        ?>

                        <small class="text-secondary ml-2">
                            <?php if($msg->is_read == 'No'): ?>
                                <i class="fas fa-check-double"></i>
                            <?php else: ?>
                                <i class="fas fa-check-circle"></i>
                            <?php endif; ?>
                            <?php echo e($msg->created_at->diffForHumans()); ?>

                        </small>
                        <span style="font-size: 16px; font-weight: bold;"> | <?php echo e($toName); ?></span>
                        <img src="<?php echo e(config('app.url')); ?>/public/uploads/<?php echo e($toUserProfileImage); ?>" alt="" width="40" height="40" class="select-message-user" style="border-radius: 50%;">

                    </div>
                </div>
            </div>
        <?php endif; ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>

</div>
</div>
<?php if(isset($toName) AND !empty($toName)): ?>
<div class="row no-gutters mobHeightTxta">
<div class="col-12 offset-0 col-sm-8 offset-sm-4 col-md-8 offset-md-4 col-lg-8 offset-lg-4">
    <form wire:submit.prevent="sendMessage">
    <div class="containerTextarea">
    <textarea name="message" id="message-inp" placeholder="Type a message" data-id="" class="" wire:model.lazy="message" wire:ignore

    ><?php if($message): ?><?php echo e($message); ?><?php endif; ?></textarea>

        <button type="submit" class="sendB">
            <i class="iconSend fas fa-paper-plane"></i>
        </button>
    </div>
        <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="alert alert-danger"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <div class="row" style="margin: 10px 0;">
        <div class="col-12 col-sm-12 col-md-6">

            <?php if($attachmentType == 'None'): ?>
                <?php if(auth()->user()->isCreating == 'Yes'): ?>
                    <a href="javascript:void(0);" class="mr-2 noHover text-danger" wire:click="setAttachmentType('Images')">
                        <h5 class="d-inline"><i class="fas fa-image"></i></h5>
                    </a>

                    <a href="javascript:void(0);" class="mr-2 noHover text-info videoUploadLink" wire:click="setAttachmentType('Videos')">
                        <h5 class="d-inline"><i class="fas fa-video"></i></h5>
                    </a>

                    <a href="javascript:void(0);" class="mr-2 noHover text-warning audioUploadLink" wire:click="setAttachmentType('Audios')">
                        <h5 class="d-inline"><i class="fas fa-music"></i></h5>
                    </a>

                    <a href="javascript:void(0);" class="ml-1 mr-2 noHover text-dark zipUploadLink" wire:click="setAttachmentType('Zips')">
                        <h5 class="d-inline"><i class="fas fa-file-archive"></i></h5>
                    </a>
                <?php else: ?>
                    <?php if($m->status == 1): ?>
                    <p><?php echo e($m->msg); ?></p>
                    <?php endif; ?>
                <?php endif; ?>

            <?php else: ?>

                <label class="text-bold">
                    <?php if($attachmentType == 'Images'): ?>
                        <?php echo app('translator')->get('v19.attachImages'); ?>
                    <?php elseif($attachmentType == 'Audios'): ?>
                        <?php echo app('translator')->get('v19.attachAudio'); ?>
                    <?php elseif($attachmentType == 'Videos'): ?>
                        <?php echo app('translator')->get('v19.attachVideo'); ?>
                    <?php elseif($attachmentType == 'Zips'): ?>
                        <?php echo app('translator')->get('v19.attachZip'); ?>
                    <?php endif; ?>

                    <a href="javascript:void(0);" class="mr-2 noHover text-danger" wire:click="setAttachmentType('None')">
                        <?php echo app('translator')->get('v19.cancel'); ?>
                    </a>

                </label>
                <br>

            <?php endif; ?>

            <input type="file" multiple wire:model="images" class="<?php if($attachmentType != 'Images'): ?> d-none <?php endif; ?>">
            <input type="file" wire:model="audios" class="<?php if($attachmentType != 'Audios'): ?> d-none <?php endif; ?>">
            <input type="file" wire:model="videos" class="<?php if($attachmentType != 'Videos'): ?> d-none <?php endif; ?>">
            <input type="file" wire:model="zips" class="<?php if($attachmentType != 'Zips'): ?> d-none <?php endif; ?>">
        </div>

        <div class="col-12 col-sm-12 col-md-6 text-right">
        <div class="row">
            <div class="col-md-6">
                <select name="lock_type" class="form-control <?php if($attachmentType == 'None'): ?> d-none <?php endif; ?>" wire:model="lockType">
                    <option value="Free"><?php echo app('translator')->get('v19.freeMessage'); ?></option>
                    <option value="Paid"><?php echo app('translator')->get('v19.paidMessage'); ?></option>
                </select>
            </div>
            <div class="col-md-6">
                <?php if($lockType == 'Paid'): ?>
                    <div class="input-group mb-2 groupInput <?php if($attachmentType == 'None' || $lockType == 'Free'): ?> d-none <?php endif; ?>">
                        <div class="input-group-prepend">
                            <div class="input-group-text">£</div>
                        </div>
                        <input type="text" class="form-control <?php if($attachmentType == 'None' || $lockType == 'Free'): ?> d-none <?php endif; ?>" placeholder="<?php echo app('translator')->get('v19.unlockPrice'); ?>" wire:model="unlockPrice"/>
                    </div>
                <?php endif; ?>
            </div>
        </div>


        <?php $__errorArgs = ['unlockPrice'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="alert alert-danger"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <?php $__errorArgs = ['images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="alert alert-danger"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <?php $__errorArgs = ['audios'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="alert alert-danger"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <?php $__errorArgs = ['zips'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="alert alert-danger"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <?php $__errorArgs = ['videos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="alert alert-danger"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        
        </div>
    </div>

    </form>
</div>
</div>
<?php endif; ?>

</div><!-- ./row -->
</div><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/livewire/message.blade.php ENDPATH**/ ?>