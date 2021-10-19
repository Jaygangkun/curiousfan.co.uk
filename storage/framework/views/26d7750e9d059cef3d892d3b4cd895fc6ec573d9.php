<?php if( $post->media_type == 'Image' ): ?>
    <div class="profile">
        <div class="profile-img-list">
            <?php if( $post->disk == 'backblaze' ): ?>
                <div class="profile-img-list-item main" 
                    <?php if(count($post->postmedia) == 0): ?>
                        style="width:100%"
                    <?php endif; ?>
                >
                    <a class="profile-img-list-link" href="javascript:void(0);" data-toggle="lightbox" data-remote="https://<?php echo e(opt('BACKBLAZE_BUCKET') . '.' . opt('BACKBLAZE_REGION') . '/' .  $post->media_content); ?>" data-gallery="post-<?php echo e($post->id); ?>">
                        <span class="profile-img-content" style="background-image: url(https://<?php echo e(opt('BACKBLAZE_BUCKET') . '.' . opt('BACKBLAZE_REGION') . '/' .  $post->media_content); ?>)"></span>
                    </a>
                </div>
            <?php else: ?>
                <div class="profile-img-list-item main" 
                    <?php if(count($post->postmedia) == 0): ?>
                        style="width:100%"
                    <?php endif; ?>
                >
                    <a class="profile-img-list-link" href="javascript:void(0);" data-toggle="lightbox" data-remote="<?php echo e(\Storage::disk($post->disk)->url($post->media_content)); ?>" data-gallery="post-<?php echo e($post->id); ?>">
                        <span class="profile-img-content" style="background-image: url(<?php echo e(\Storage::disk($post->disk)->url($post->media_content)); ?>)"></span>
                    </a>
                </div>
            <?php endif; ?>

            <?php $__currentLoopData = $post->postmedia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $extraMedia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($key < 2): ?>
                    <?php if( $post->disk == 'backblaze' ): ?>
                        <div class="profile-img-list-item 
                        <?php if($key == 1 && count($post->postmedia) > 2): ?>
                            with-number
                        <?php endif; ?>
                        ">
                            <a class="profile-img-list-link" href="javascript:void(0);" data-toggle="lightbox" data-remote="https://<?php echo e(opt('BACKBLAZE_BUCKET') . '.' . opt('BACKBLAZE_REGION') . '/' .  $extraMedia->media_content); ?>" data-gallery="post-<?php echo e($post->id); ?>">
                                <span class="profile-img-content" style="background-image: url(https://<?php echo e(opt('BACKBLAZE_BUCKET') . '.' . opt('BACKBLAZE_REGION') . '/' .  $extraMedia->media_content); ?>)">
                                </span>
                                <?php if($key == 1 && count($post->postmedia) > 2): ?>
                                    <div class="profile-img-number">+<?php echo e(count($post->postmedia) - ($key + 1)); ?></div>
                                <?php endif; ?>
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="profile-img-list-item
                        <?php if($key == 1 && count($post->postmedia) > 2): ?>
                            with-number
                        <?php endif; ?>
                        ">
                            <a class="profile-img-list-link" href="javascript:void(0);" data-toggle="lightbox" data-remote="<?php echo e(\Storage::disk($extraMedia->disk)->url($extraMedia->media_content)); ?>" data-gallery="post-<?php echo e($post->id); ?>">
                                <span class="profile-img-content" style="background-image: url(<?php echo e(\Storage::disk($extraMedia->disk)->url($extraMedia->media_content)); ?>)">
                                </span>
                                <?php if($key == 1 && count($post->postmedia) > 2): ?>
                                    <div class="profile-img-number">+<?php echo e(count($post->postmedia) - ($key + 1)); ?></div>
                                <?php endif; ?>
                            </a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php if(count($post->postmedia) == 1): ?>
            <div class="profile-img-list-item main"><span class="profile-img-content" style="background-color: white"></span></div>
            <?php endif; ?>
        </div>
    </div>
<?php elseif( $post->media_type == 'Video' ): ?>

<div class="embed-responsive embed-responsive-16by9">
<video controls <?php if(opt('enableMediaDownload', 'No') == 'No'): ?> controlsList="nodownload" <?php endif; ?> preload="metadata" disablePictureInPicture>
    <?php if( $post->disk == 'backblaze' ): ?>
        <source src="https://<?php echo e(opt('BACKBLAZE_BUCKET') . '.' . opt('BACKBLAZE_REGION') . '/' .  $post->media_content); ?>#t=0.5" type="video/mp4" />
    <?php else: ?>
        <source src="<?php echo e(\Storage::disk($post->disk)->url($post->video_url)); ?>#t=0.5" type="video/mp4" />
    <?php endif; ?>
    <?php echo app('translator')->get('post.videoTag'); ?>
</video>
</div>

<?php elseif( $post->media_type == 'Audio' ): ?>

<div class="p-2">
<audio class="w-100 mb-4" controls <?php if(opt('enableMediaDownload', 'No') == 'No'): ?> controlsList="nodownload" <?php endif; ?>>
    <?php if( $post->disk == 'backblaze' ): ?>
        <source src="https://<?php echo e(opt('BACKBLAZE_BUCKET') . '.' . opt('BACKBLAZE_REGION') . '/' .  $post->media_content); ?>" type="audio/mp3">
    <?php else: ?>
        <source src="<?php echo e(\Storage::disk($post->disk)->url($post->audio_url)); ?>" type="audio/mp3">
    <?php endif; ?>
    <?php echo app('translator')->get('post.audioTag'); ?>
</audio>
</div>

<?php elseif( $post->media_type == 'ZIP' ): ?>

<h5>
    <a href="<?php echo e(route('downloadZip', ['post' => $post])); ?>" target="_blank" class="ml-4 mb-3">
        <i class="fas fa-file-archive"></i> <?php echo app('translator')->get('v16.zipDownload'); ?>
    </a>
</h5><br>

<?php endif; ?>

<?php $__env->startPush('extraCSS'); ?>
<style>
    .ekko-lightbox-nav-overlay a {
        opacity:1;
        color:black;
    }
</style>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/posts/post-media.blade.php ENDPATH**/ ?>