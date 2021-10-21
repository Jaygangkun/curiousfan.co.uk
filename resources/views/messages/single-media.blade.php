@if( $media->media_type == 'Image' )

    <div class="mediaAttachmentWrap imageAttachmentWrap">
        @if( $media->disk == 'backblaze' )
            <a href="javascript:void(0);" data-toggle="lightbox" data-remote="https://{{ opt('BACKBLAZE_BUCKET') . '.' . opt('BACKBLAZE_REGION') . '/' .  $media->media_content}}" data-gallery="msg-{{ $msg->id }}">
                <img src="https://{{ opt('BACKBLAZE_BUCKET') . '.' . opt('BACKBLAZE_REGION') . '/' .  $media->media_content}}" alt="" class="img-fluid"/>
            </a>
        @else
            <a href="javascript:void(0);" data-toggle="lightbox" data-remote="{{ \Storage::disk($media->disk)->url($media->media_content) }}" data-gallery="msg-{{ $msg->id }}">
                <img src="{{ \Storage::disk($media->disk)->url($media->media_content) }}" alt="" class="img-fluid"/>
            </a>
        @endif
    </div>

@elseif( $media->media_type == 'Video' )

    <div class="mediaAttachmentWrap embed-responsive embed-responsive-16by9 m-2 videoAttachmentWrap">
        <video controls @if(opt('enableMediaDownload', 'No') == 'No') controlsList="nodownload" @endif preload="metadata" disablePictureInPicture>
            @if( $media->disk == 'backblaze' )
                <source src="https://{{ opt('BACKBLAZE_BUCKET') . '.' . opt('BACKBLAZE_REGION') . '/' .  $media->media_content}}#t=0.5" type="video/mp4" />
            @else
                <source src="{{ \Storage::disk($media->disk)->url($media->media_content) }}#t=0.5" type="video/mp4" />
            @endif
            @lang('post.videoTag')
        </video>
    </div>

@elseif( $media->media_type == 'Audio' )

    <div class="mediaAttachmentWrap audioAttachmentWrap">
        <audio class="w-100 p-2" controls @if(opt('enableMediaDownload', 'No') == 'No') controlsList="nodownload" @endif>
            @if( $media->disk == 'backblaze' )
                <source src="https://{{ opt('BACKBLAZE_BUCKET') . '.' . opt('BACKBLAZE_REGION') . '/' .  $media->media_content}}" type="audio/mp3">
            @else
                <source src="{{ \Storage::disk($media->disk)->url($media->media_content) }}" type="audio/mp3">
            @endif
            @lang('post.audioTag')
        </audio>
    </div>

@elseif( $media->media_type == 'ZIP' )

    <div class="mediaAttachmentWrap fileAttachmentWrap">
        <h5>
            <a href="{{ route('downloadMessageZip', ['messageMedia' => $media]) }}" target="_blank" class="ml-3 mt-2 btn btn-primary btn-sm">
                <i class="fas fa-file-archive"></i> @lang('v16.zipDownload')
            </a>
        </h5>
    </div>

@endif