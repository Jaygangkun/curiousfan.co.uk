@if( $post->media_type == 'Image' )
    <div class="profile">
        <div class="profile-img-list">
            @if( $post->disk == 'backblaze' )
                <div class="profile-img-list-item main" 
                    @if(count($post->postmedia) == 0)
                        style="width:100%"
                    @endif
                >
                    <a class="profile-img-list-link" href="javascript:void(0);" data-toggle="lightbox" data-remote="https://{{ opt('BACKBLAZE_BUCKET') . '.' . opt('BACKBLAZE_REGION') . '/' .  $post->media_content}}" data-gallery="post-{{ $post->id }}">
                        <span class="profile-img-content" style="background-image: url(https://{{ opt('BACKBLAZE_BUCKET') . '.' . opt('BACKBLAZE_REGION') . '/' .  $post->media_content}})"></span>
                    </a>
                </div>
            @else
                <div class="profile-img-list-item main" 
                    @if(count($post->postmedia) == 0)
                        style="width:100%"
                    @endif
                >
                    <a class="profile-img-list-link" href="javascript:void(0);" data-toggle="lightbox" data-remote="{{ \Storage::disk($post->disk)->url($post->media_content) }}" data-gallery="post-{{ $post->id }}">
                        <span class="profile-img-content" style="background-image: url({{ \Storage::disk($post->disk)->url($post->media_content) }})"></span>
                    </a>
                </div>
            @endif

            @foreach($post->postmedia as $key => $extraMedia)
                @if($key < 2)
                    @if( $post->disk == 'backblaze' )
                        <div class="profile-img-list-item 
                        @if($key == 1 && count($post->postmedia) > 2)
                            with-number
                        @endif
                        ">
                            <a class="profile-img-list-link" href="javascript:void(0);" data-toggle="lightbox" data-remote="https://{{ opt('BACKBLAZE_BUCKET') . '.' . opt('BACKBLAZE_REGION') . '/' .  $extraMedia->media_content}}" data-gallery="post-{{ $post->id }}">
                                <span class="profile-img-content" style="background-image: url(https://{{ opt('BACKBLAZE_BUCKET') . '.' . opt('BACKBLAZE_REGION') . '/' .  $extraMedia->media_content}})">
                                </span>
                                @if($key == 1 && count($post->postmedia) > 2)
                                    <div class="profile-img-number">+{{count($post->postmedia) - ($key + 1)}}</div>
                                @endif
                            </a>
                        </div>
                    @else
                        <div class="profile-img-list-item
                        @if($key == 1 && count($post->postmedia) > 2)
                            with-number
                        @endif
                        ">
                            <a class="profile-img-list-link" href="javascript:void(0);" data-toggle="lightbox" data-remote="{{ \Storage::disk($extraMedia->disk)->url($extraMedia->media_content) }}" data-gallery="post-{{ $post->id }}">
                                <span class="profile-img-content" style="background-image: url({{ \Storage::disk($extraMedia->disk)->url($extraMedia->media_content) }})">
                                </span>
                                @if($key == 1 && count($post->postmedia) > 2)
                                    <div class="profile-img-number">+{{count($post->postmedia) - ($key + 1)}}</div>
                                @endif
                            </a>
                        </div>
                    @endif
                @else
                    <div class="profile-img-list-item" style="display: none">
                        <a class="profile-img-list-link" href="javascript:void(0);" data-toggle="lightbox" data-remote="{{ \Storage::disk($extraMedia->disk)->url($extraMedia->media_content) }}" data-gallery="post-{{ $post->id }}">
                            <span class="profile-img-content" style="background-image: url({{ \Storage::disk($extraMedia->disk)->url($extraMedia->media_content) }})">
                            </span>
                        </a>
                    </div>
                @endif
            @endforeach

            @if(count($post->postmedia) == 1)
            <div class="profile-img-list-item main"><span class="profile-img-content" style="background-color: white"></span></div>
            @endif
        </div>
    </div>
@elseif( $post->media_type == 'Video' )

<div class="embed-responsive embed-responsive-16by9">
<video controls @if(opt('enableMediaDownload', 'No') == 'No') controlsList="nodownload" @endif preload="metadata" disablePictureInPicture>
    @if( $post->disk == 'backblaze' )
        <source src="https://{{ opt('BACKBLAZE_BUCKET') . '.' . opt('BACKBLAZE_REGION') . '/' .  $post->media_content}}#t=0.5" type="video/mp4" />
    @else
        <source src="{{ \Storage::disk($post->disk)->url($post->video_url) }}#t=0.5" type="video/mp4" />
    @endif
    @lang('post.videoTag')
</video>
</div>

@elseif( $post->media_type == 'Audio' )

<div class="p-2">
<audio class="w-100 mb-4" controls @if(opt('enableMediaDownload', 'No') == 'No') controlsList="nodownload" @endif>
    @if( $post->disk == 'backblaze' )
        <source src="https://{{ opt('BACKBLAZE_BUCKET') . '.' . opt('BACKBLAZE_REGION') . '/' .  $post->media_content}}" type="audio/mp3">
    @else
        <source src="{{ \Storage::disk($post->disk)->url($post->audio_url) }}" type="audio/mp3">
    @endif
    @lang('post.audioTag')
</audio>
</div>

@elseif( $post->media_type == 'ZIP' )

<h5>
    <a href="{{ route('downloadZip', ['post' => $post]) }}" target="_blank" class="ml-4 mb-3">
        <i class="fas fa-file-archive"></i> @lang('v16.zipDownload')
    </a>
</h5><br>

@endif

@push('extraCSS')
<style>
    .ekko-lightbox-nav-overlay a {
        opacity:1;
        color:black;
    }
</style>
@endpush
