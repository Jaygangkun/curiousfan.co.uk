<div>
    <h3 class="title">
    <i class="far fa-envelope"></i> <?php echo app('translator')->get('messages.messages'); ?>
    </h3>

    <div class="card">
    <div class="row no-gutters">
    
    <div class="col-12 d-sm-none d-md-none d-lg-none">
        <select class="form-control" wire:model="mobileProfileId">
        <option value=""><?php echo app('translator')->get('v19.selectRecipient'); ?></option>
        <?php $__empty_1 = true; $__currentLoopData = $people; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <option value="<?php echo e($p->id); ?>"><?php echo e($p->profile->handle); ?> (<?php echo e($p->profile->name); ?>)</option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <option value=""><?php echo app('translator')->get('profile.noSubscriptions'); ?></option>
        <?php endif; ?>
        </select>
    </div>
    <div class="d-none d-sm-block d-md-block d-lg-block col-sm-4 col-md-4 col-lg-4 border-right" id="people-container">
        
        <?php $__empty_1 = true; $__currentLoopData = $people; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="row no-gutters pt-2 pb-2 border-top">
        <div class="col-12 col-sm-12 col-md-2">
        <div class="profilePicXS mt-0 ml-0 mr-2 ml-2 shadow-sm">
		    <a href="javascript:scrollToLast()" class="select-message-user" wire:click="openConversation(<?php echo e($p->id); ?>)">
			    <img src="<?php echo e($p->profile->profilePicture); ?>" alt="" width="40" height="40" class="select-message-user">
		    </a>
        </div>
        </div>

        <div class="col-12 col-sm-12 col-md-10">
            <a href="javascript:scrollToLast()" class="d-none d-sm-none d-md-block text-dark select-message-user" wire:click="openConversation(<?php echo e($p->id); ?>)" >
                <?php echo e($p->profile->name); ?>

            </a>
            <small>
                <a href="javascript:scrollToLast()" class="text-secondary ml-2 ml-sm-2 ml-md-0 select-message-user" wire:click="openConversation(<?php echo e($p->id); ?>)">
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
            <br>
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
        <?php echo app('translator')->get('messages.to'); ?>: <?php echo e($toName); ?>

    </div>

    <?php endif; ?>

    <?php if(isset($messages) AND count($messages)): ?>
    <div class="row no-gutters" wire:poll.3000ms="openConversation(<?php echo e($toUserId); ?>)">
        <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($msg->from_id == auth()->id()): ?>
                <div class="col-9 mt-3">
                    <div class="bg-primary text-white p-2 rounded-right">
                        <?php echo e($msg->message); ?>


                        <?php if($msg->media->count()): ?>
                            <br>
                            <?php echo $__env->make('messages.message-media', ['media' => $msg->media, 'msg' => $msg], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endif; ?>
                    </div>
                    <small class="text-secondary ml-2">
                        <?php if($msg->is_read == 'No'): ?>
                            <i class="fas fa-check-double"></i> 
                        <?php else: ?>
                            <i class="fas fa-check-circle"></i> 
                        <?php endif; ?>
                        <?php echo e($msg->created_at->diffForHumans()); ?>

                    </small>
                </div>
            <?php else: ?>
                <div class="col-9 mt-3 offset-3">
                    <div class="bg-secondary text-white p-2 rounded-left">
                        <?php echo e($msg->message); ?>


                        <?php if($msg->media->count()): ?>
                            <br>
                            <?php echo $__env->make('messages.message-media', ['media' => $msg->media, 'msg' => $msg], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endif; ?>
                    </div>
                    <div class="text-right">
                        <small class="text-secondary mr-2">
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
                            
                        </small>
                    </div>
                </div>
            <?php endif; ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>
        
    </div>
    </div>

    <?php if(isset($toName) AND !empty($toName)): ?>

    <div class="row no-gutters">
    <div class="col-12 offset-0 col-sm-8 offset-sm-4 col-md-8 offset-md-4 col-lg-8 offset-lg-4">
        <form wire:submit.prevent="sendMessage">

        <textarea name="message" id="message-inp" data-id="" class="form-control bg-light p-2 rounded-0" wire:model.lazy="message" wire:ignore><?php echo e($message); ?></textarea><br>
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
        
		  <div class="row">
          	<div class="col-12 col-sm-12 col-md-8">
                
                <?php if($attachmentType == 'None'): ?>

                    <?php if(auth()->user()->profile->isVerified == 'Yes'): ?>
                        <a href="javascript:void(0);" class="mr-2 noHover text-danger" wire:click="setAttachmentType('Images')">
                            <h5 class="d-inline"><i class="fas fa-image"></i></h5>
                        </a>

                        <a href="javascript:void(0);" class="mr-2 noHover text-info videoUploadLink" wire:click="setAttachmentType('Videos')">
                            <h5 class="d-inline"><i class="fas fa-video"></i></h5>
                        </a>

                        <a href="javascript:void(0);" class="mr-2 noHover text-secondary audioUploadLink" wire:click="setAttachmentType('Audios')">
                            <h5 class="d-inline"><i class="fas fa-music"></i></h5>
                        </a>

                        <a href="javascript:void(0);" class="ml-1 mr-2 noHover text-dark zipUploadLink" wire:click="setAttachmentType('Zips')">
                            <h5 class="d-inline"><i class="fas fa-file-archive"></i></h5>
                        </a>
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
		
			<div class="col-12 col-sm-12 col-md-4 text-right">
            
            <select name="lock_type" class="form-control <?php if($attachmentType == 'None'): ?> d-none <?php endif; ?>" wire:model="lockType">
                <option value="Free"><?php echo app('translator')->get('v19.freeMessage'); ?></option>
                <option value="Paid"><?php echo app('translator')->get('v19.paidMessage'); ?></option>
            </select>
        
            <input type="text" class="form-control <?php if($attachmentType == 'None' || $lockType == 'Free'): ?> d-none <?php endif; ?>" placeholder="<?php echo app('translator')->get('v19.unlockPrice'); ?>" wire:model="unlockPrice"/>
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

			<button type="submit" class="btn btn-primary mr-0 mt-2 mb-2">
				<i class="far fa-paper-plane mr-1"></i> <?php echo app('translator')->get('v19.sendMessage'); ?>
			</button>
			</div>
		</div>

        </form>
    </div>
    </div>
    <?php endif; ?>

    </div><!-- ./row -->
    </div>
</div><?php /**PATH /home/jr5az3t0ng0l/public_html/resources/views/livewire/message.blade.php ENDPATH**/ ?>