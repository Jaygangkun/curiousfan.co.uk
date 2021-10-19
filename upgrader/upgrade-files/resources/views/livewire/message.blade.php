<div>
    <h3 class="title">
    <i class="far fa-envelope"></i> @lang('messages.messages')
    </h3>

    <div class="card">
    <div class="row no-gutters">
    
    <div class="col-12 d-sm-none d-md-none d-lg-none">
        <select class="form-control" wire:model="mobileProfileId">
        <option value="">@lang('v19.selectRecipient')</option>
        @forelse($people as $p)
            <option value="{{ $p->id }}">{{  $p->profile->handle }} ({{ $p->profile->name }})</option>
        @empty
            <option value="">@lang('profile.noSubscriptions')</option>
        @endforelse
        </select>
    </div>
    <div class="d-none d-sm-block d-md-block d-lg-block col-sm-4 col-md-4 col-lg-4 border-right" id="people-container">
        
        @forelse($people as $p)
        <div class="row no-gutters pt-2 pb-2 border-top">
        <div class="col-12 col-sm-12 col-md-2">
        <div class="profilePicXS mt-0 ml-0 mr-2 ml-2 shadow-sm">
		    <a href="javascript:scrollToLast()" class="select-message-user" wire:click="openConversation({{ $p->id }})">
			    <img src="{{  $p->profile->profilePicture }}" alt="" width="40" height="40" class="select-message-user">
		    </a>
        </div>
        </div>

        <div class="col-12 col-sm-12 col-md-10">
            <a href="javascript:scrollToLast()" class="d-none d-sm-none d-md-block text-dark select-message-user" wire:click="openConversation({{ $p->id }})" >
                {{ $p->profile->name }}
            </a>
            <small>
                <a href="javascript:scrollToLast()" class="text-secondary ml-2 ml-sm-2 ml-md-0 select-message-user" wire:click="openConversation({{ $p->id }})">
                    {{  $p->profile->handle }} 
                </a>
                {{-- <p class="ml-2 ml-sm-2 ml-md-0"> --}}
                @if(isset($unreadMsg) AND count($unreadMsg) AND $lastMsg = $unreadMsg->where('from_id', $p->id)->first()) 
                    @if($lastMsg->is_read == 'No')
                        <strong>
                            {{ substr($lastMsg->message, 0, 55) }}
                            @if(strlen($lastMsg->message) > 55) ... @endif
                        </strong>
                    @else
                        <em>
                            {{ substr($lastMsg->message, 0, 55) }}
                            @if(strlen($lastMsg->message) > 55) ... @endif
                        </em>
                    @endif
                @endif
                {{-- </p> --}}
            </small>
            <br>
        </div>
        </div>
        @empty
            @lang('profile.noSubscriptions')
        @endforelse


        <br>
    </div>

    <div class="col-12 col-sm-8 col-md-8 col-lg-8 border-top" id="messages-container">

    @if(isset($toName) AND !empty($toName))

    <div class="p-2 text-secondary">
        @lang('messages.to'): {{  $toName }}
    </div>

    @endif

    @if(isset($messages) AND count($messages))
    <div class="row no-gutters" wire:poll.3000ms="openConversation({{ $toUserId  }})">
        @foreach($messages as $msg)
            @if($msg->from_id == auth()->id())
                <div class="col-9 mt-3">
                    <div class="bg-primary text-white p-2 rounded-right">
                        {{  $msg->message }}

                        @if($msg->media->count())
                            <br>
                            @include('messages.message-media', ['media' => $msg->media, 'msg' => $msg])
                        @endif
                    </div>
                    <small class="text-secondary ml-2">
                        @if($msg->is_read == 'No')
                            <i class="fas fa-check-double"></i> 
                        @else
                            <i class="fas fa-check-circle"></i> 
                        @endif
                        {{ $msg->created_at->diffForHumans() }}
                    </small>
                </div>
            @else
                <div class="col-9 mt-3 offset-3">
                    <div class="bg-secondary text-white p-2 rounded-left">
                        {{ $msg->message }}

                        @if($msg->media->count())
                            <br>
                            @include('messages.message-media', ['media' => $msg->media, 'msg' => $msg])
                        @endif
                    </div>
                    <div class="text-right">
                        <small class="text-secondary mr-2">
                            @php
                                $msg->is_read = 'Yes';
                                $msg->save();
                            @endphp
                            
                            <small class="text-secondary ml-2">
                                @if($msg->is_read == 'No')
                                    <i class="fas fa-check-double"></i> 
                                @else
                                    <i class="fas fa-check-circle"></i> 
                                @endif
                                {{ $msg->created_at->diffForHumans() }}
                            </small>
                            
                        </small>
                    </div>
                </div>
            @endif

        @endforeach
    </div>
    @endif
        
    </div>
    </div>

    @if(isset($toName) AND !empty($toName))

    <div class="row no-gutters">
    <div class="col-12 offset-0 col-sm-8 offset-sm-4 col-md-8 offset-md-4 col-lg-8 offset-lg-4">
        <form wire:submit.prevent="sendMessage">

        <textarea name="message" id="message-inp" data-id="" class="form-control bg-light p-2 rounded-0" wire:model.lazy="message" wire:ignore>{{ $message }}</textarea><br>
        @error('message')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        
		  <div class="row">
          	<div class="col-12 col-sm-12 col-md-8">
                
                @if($attachmentType == 'None')

                    @if(auth()->user()->profile->isVerified == 'Yes')
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
                    @endif
                    
                @else
                    
                    <label class="text-bold">
                        @if($attachmentType == 'Images')
                            @lang('v19.attachImages')
                        @elseif($attachmentType == 'Audios')
                            @lang('v19.attachAudio')
                        @elseif($attachmentType == 'Videos')
                            @lang('v19.attachVideo')
                        @elseif($attachmentType == 'Zips')
                            @lang('v19.attachZip')
                        @endif

                        <a href="javascript:void(0);" class="mr-2 noHover text-danger" wire:click="setAttachmentType('None')">
                            @lang('v19.cancel')
                        </a>

                    </label>
                    <br>

                @endif

                <input type="file" multiple wire:model="images" class="@if($attachmentType != 'Images') d-none @endif">
                <input type="file" wire:model="audios" class="@if($attachmentType != 'Audios') d-none @endif">
                <input type="file" wire:model="videos" class="@if($attachmentType != 'Videos') d-none @endif">
                <input type="file" wire:model="zips" class="@if($attachmentType != 'Zips') d-none @endif">
			</div>
		
			<div class="col-12 col-sm-12 col-md-4 text-right">
            
            <select name="lock_type" class="form-control @if($attachmentType == 'None') d-none @endif" wire:model="lockType">
                <option value="Free">@lang('v19.freeMessage')</option>
                <option value="Paid">@lang('v19.paidMessage')</option>
            </select>
        
            <input type="text" class="form-control @if($attachmentType == 'None' || $lockType == 'Free') d-none @endif" placeholder="@lang('v19.unlockPrice')" wire:model="unlockPrice"/>
            @error('unlockPrice')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
                
            @error('images.*')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            @error('audios')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            @error('zips')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            @error('videos')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

			<button type="submit" class="btn btn-primary mr-0 mt-2 mb-2">
				<i class="far fa-paper-plane mr-1"></i> @lang('v19.sendMessage')
			</button>
			</div>
		</div>

        </form>
    </div>
    </div>
    @endif

    </div><!-- ./row -->
    </div>
</div>