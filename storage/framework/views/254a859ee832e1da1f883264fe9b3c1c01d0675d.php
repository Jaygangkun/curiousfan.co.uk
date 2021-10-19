<?php if( $media->media_type == 'Image' ): ?>

    <div class="col-12">
        <?php if( $media->disk == 'backblaze' ): ?>
            <a href="javascript:void(0);" data-toggle="lightbox" data-remote="https://<?php echo e(opt('BACKBLAZE_BUCKET') . '.' . opt('BACKBLAZE_REGION') . '/' .  $media->media_content); ?>" data-gallery="msg-<?php echo e($msg->id); ?>">
                <img src="https://<?php echo e(opt('BACKBLAZE_BUCKET') . '.' . opt('BACKBLAZE_REGION') . '/' .  $media->media_content); ?>" alt="" class="img-fluid"/>
            </a>
        <?php else: ?>
            <a href="javascript:void(0);" data-toggle="lightbox" data-remote="<?php echo e(\Storage::disk($media->disk)->url($media->media_content)); ?>" data-gallery="msg-<?php echo e($msg->id); ?>">
                <img src="<?php echo e(\Storage::disk($media->disk)->url($media->media_content)); ?>" alt="" class="img-fluid"/>
            </a>
        <?php endif; ?>
    </div>

<?php elseif( $media->media_type == 'Video' ): ?>

    <div class="embed-responsive embed-responsive-16by9 m-2">
    <video controls <?php if(opt('enableMediaDownload', 'No') == 'No'): ?> controlsList="nodownload" <?php endif; ?> preload="metadata" disablePictureInPicture>
        <?php if( $media->disk == 'backblaze' ): ?>
            <source src="https://<?php echo e(opt('BACKBLAZE_BUCKET') . '.' . opt('BACKBLAZE_REGION') . '/' .  $media->media_content); ?>#t=0.5" type="video/mp4" />
        <?php else: ?>
            <source src="<?php echo e(\Storage::disk($media->disk)->url($media->media_content)); ?>#t=0.5" type="video/mp4" />
        <?php endif; ?>
        <?php echo app('translator')->get('post.videoTag'); ?>
    </video>
    </div>

<?php elseif( $media->media_type == 'Audio' ): ?>

    <div class="col-12">
    <audio class="w-100 p-2" controls <?php if(opt('enableMediaDownload', 'No') == 'No'): ?> controlsList="nodownload" <?php endif; ?>>
        <?php if( $media->disk == 'backblaze' ): ?>
            <source src="https://<?php echo e(opt('BACKBLAZE_BUCKET') . '.' . opt('BACKBLAZE_REGION') . '/' .  $media->media_content); ?>" type="audio/mp3">
        <?php else: ?>
            <source src="<?php echo e(\Storage::disk($media->disk)->url($media->media_content)); ?>" type="audio/mp3">
        <?php endif; ?>
        <?php echo app('translator')->get('post.audioTag'); ?>
    </audio>
    </div>

<?php elseif( $media->media_type == 'ZIP' ): ?>

    <h5>
        <a href="<?php echo e(route('downloadMessageZip', ['messageMedia' => $media])); ?>" target="_blank" class="ml-3 mt-2 btn btn-primary btn-sm">
            <i class="fas fa-file-archive"></i> <?php echo app('translator')->get('v16.zipDownload'); ?>
        </a>
    </h5><br>

<?php endif; ?><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/messages/single-media.blade.php ENDPATH**/ ?>