<div>
    <div class="alert alert-success alert-dismissible" id="massMessageAlertSuccess" style="display:none">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        Success Sent!
    </div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="title mb-0">
            <i class="far fa-envelope"></i> @lang('messages.messages')
        </h3>
        @if(auth()->user()->isCreating == 'Yes')
            <button class="btn btn-primary" data-toggle="modal" data-target="#massMessagesPopup"> @lang('messages.massMessagesButton')</button>
        @endif
        
    </div>
    <div class="card">
        <div class="row d-flex d-md-none">
            <div class="col-md-12">
                <ul class="box-gridmobPic">
                    @foreach($people as $p)
                    <li class="@if($toUserId == $p->id) selectedLi @endif">
                        <a class="@if($p->isOnline()) profilePicOnlineBob @else profilePicOfflineBob @endif" wire:click="clickConversation({{ $p->id }})">
                            <img src="{{  $p->profile->profilePicture }}" alt="" width="50" height="50" class="box-img" style="border-radius: 50%;border:2px solid @if($p->isOnline()) #4caf50; @else #727272; @endif">
                        </a>
                        @if($this->unreadMessageCount($p->id) > 0)
                        <span class="unreadmessagecount">
                            {{ $this->unreadMessageCount($p->id) }}
                        </span>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row no-gutters">
            {{--<div class="col-12 d-sm-none d-md-none d-lg-none">
                <select class="form-control" wire:model="mobileProfileId">
                --}}{{--<option value="" @if($toUserId == $p->id) selected @endif>@lang('v19.selectRecipient')</option>--}}{{--
                <option value="{{ $toUserId }}" selected="selected">{{ $toName }}</option>
                @forelse($people as $p)
                    <option value="{{ $p->id }}" @if($toUserId == $p->id) selected @endif>{{  $p->profile->handle }} ({{ $p->profile->name }})</option>
                @empty
                    <option value="">@lang('profile.noSubscriptions')</option>
                @endforelse
                </select>
            </div>--}}

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

                    .massMessagesList {
                        max-height: 402px;
                        overflow: auto;
                        margin-bottom: 20px;
                    }
                </style>
                
                @forelse($people as $p)
                    <div class="row no-gutters pt-2 pb-2 border-top" wire:click="clickConversation({{ $p->id }})" style="cursor:pointer;@if($toUserId == $p->id)background: #eee;@endif">
                        <div class="col-12 col-sm-12 col-md-2">
                            <div class="profilePicXS mt-0 ml-0 mr-2 ml-2 shadow-sm">
                                <a class="select-message-user @if($p->isOnline()) profilePicOnline @else profilePicOffline @endif">
                                    <img src="{{  $p->profile->profilePicture }}" alt="" width="50" height="50" class="select-message-user">
                                </a>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-10">
                            <a class="d-none d-sm-none d-md-block text-dark select-message-user" wire:click="clickConversation({{ $p->id }})" >
                                {{ $p->profile->name }}
                            </a>
                            <small>
                                <a class="text-secondary ml-2 ml-sm-2 ml-md-0 select-message-user" wire:click="clickConversation({{ $p->id }})">
                                    {{  $p->profile->handle }} 
                                </a>
                                {{-- <p class="ml-2 ml-sm-2 ml-md-0"> --}}
                                @if(isset($unreadMsg) AND count($unreadMsg) AND $lastMsg = $unreadMsg->where('from_id', $p->id)->first()) 
                                    @if($lastMsg->is_read == 'No')
                                        <strong>(new)</strong>
                                    @endif
                                @endif
                                {{-- </p> --}}
                            </small>
                            {{--@php
                                $lastMsgC = \App\Message::where([
                                            ['to_id', auth()->id()],
                                            ['from_id', $p->id],
                                            ['is_read', 'No']
                                        ])->count();
                            @endphp--}}
                            @if($this->unreadMessageCount($p->id) > 0)
                                <span class="messageNotification">
                                    {{ $this->unreadMessageCount($p->id) }}
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    @lang('profile.noSubscriptions')
                @endforelse
            </div>

            <div class="col-12 col-sm-8 col-md-8 col-lg-8 border-top" id="messages-container">
                @if(isset($toName) AND !empty($toName))
                    <div class="p-2 text-secondary">
                        <strong>@lang('messages.to'): {{  $toName }}</strong>
                        <span style="color:red;font-size:12px;position: absolute;right:10px;cursor: pointer;"
                                onclick="confirm('Are you sure you want to delete this conversation?') || event.stopImmediatePropagation()"
                                wire:click="deleteConversation('{{ auth()->id() }}', {{ $toUserId }})"
                        >Delete Conversation</span>
                    </div>
                @else
                    <div class="d-flex justify-content-center align-items-center h-100">Please choose a contact and say Hi.</div>
                @endif

                @if(isset($messages) AND count($messages))
                    <div class="row no-gutters" wire:poll.3000ms="openConversation({{ $toUserId  }})" style="margin-bottom: 20px;">
                        @foreach($messages as $msg)
                            @if($msg->from_id == auth()->id())
                                <div class="col-12 mt-3 messageRow messageRowRead{{$msg->is_read}}">
                                    <div class="text-secondary ml-2" style="z-index: 1;position: absolute;left:10px;font-size:12px;">
                                        <img src="{{  auth()->user()->profile->profilePicture }}" alt="" width="40" height="40" class="select-message-user" style="border-radius: 50%;">
                                        <span style="font-size: 16px; font-weight: bold;">You | </span>
                                        @if($msg->is_read == 'Yes')
                                            <i class="fas fa-check-double"></i>
                                        @else
                                            <i class="fas fa-check-circle"></i>
                                        @endif
                                        {{ $msg->created_at->diffForHumans() }}
                                    </div>
                                    <div class="text-white p-2 rounded-right toMessage">
                                        <div class="delMessageWrap">
                                            <span class="btn delMessage" onclick="confirm('Are you sure you want to delete this message?') || event.stopImmediatePropagation()" wire:click="deleteMessage('{{ $msg->id }}', {{ auth()->id() }}, 'sender')">
                                                <i class="fa fa-times"></i>
                                            </span>
                                        </div>
                                        <div class="toMessageTextWrap">
                                            {{  $msg->message }}
                                        </div>
                                        @if($msg->media->count())
                                            <div class="toMessageMediaWrap">
                                                @include('messages.message-media', ['media' => $msg->media, 'msg' => $msg, 'utype' => 'toUser'])
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="col-11 mt-3 messageRow messageRowRead{{$msg->is_read}}" style="margin-left: auto;">
                                    {{--<div class="bg-secondary text-white p-2 rounded-left">--}}
                                    <div class="fromMessage">
                                        <div class="delMessageFromWrap">
                                            <span class="btn delMessageFrom" onclick="confirm('Are you sure you want to delete this message?') || event.stopImmediatePropagation()" wire:click="deleteMessage('{{ $msg->id }}', {{ auth()->id() }}, 'receiver')">
                                                <i class="fa fa-times"></i>
                                            </span>
                                        </div>
                                        <div class="fromMessageTextWrap">
                                            {{ $msg->message }}
                                        </div>

                                        @if($msg->media->count())
                                            <div class="fromMessageMediaWrap">
                                                @include('messages.message-media', ['media' => $msg->media, 'msg' => $msg, 'utype' => 'fromUser'])
                                            </div>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <div class="text-secondary ml-2" style="z-index: 1;position: absolute;right:20px;font-size:12px;">
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
                                            <span style="font-size: 16px; font-weight: bold;"> | {{  $toName }}</span>
                                            <img src="{{ config('app.url') }}/public/uploads/{{ $toUserProfileImage }}" alt="" width="40" height="40" class="select-message-user" style="border-radius: 50%;">

                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        @if(isset($toName) AND !empty($toName))
            <div class="row no-gutters mobHeightTxta">
                <div class="col-12 offset-0 col-sm-8 offset-sm-4 col-md-8 offset-md-4 col-lg-8 offset-lg-4">
                    <form wire:submit.prevent="sendMessage">
                        <div class="containerTextarea">
                            <textarea name="message" id="message-inp" placeholder="Type a message" data-id="" class="" wire:model.lazy="message" wire:ignore >@if($message){{ $message }}@endif</textarea>
                            <button type="submit" class="sendB">
                                <i class="iconSend fas fa-paper-plane"></i>
                            </button>
                        </div>
                        @error('message')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="row" style="margin: 10px 0;">
                            <div class="col-12 col-sm-12 col-md-6">
                                @if($attachmentType == 'None')
                                    @if(auth()->user()->isCreating == 'Yes')
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
                                    @else
                                        @if($m->status == 1)
                                            <p>{{ $m->msg }}</p>
                                        @endif
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

                            <div class="col-12 col-sm-12 col-md-6 text-right">
                                <div class="row">
                                    <div class="col-md-6">
                                        <select name="lock_type" class="form-control @if($attachmentType == 'None') d-none @endif" wire:model="lockType">
                                            <option value="Free">@lang('v19.freeMessage')</option>
                                            <option value="Paid">@lang('v19.paidMessage')</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        @if($lockType == 'Paid')
                                            <div class="input-group mb-2 groupInput @if($attachmentType == 'None' || $lockType == 'Free') d-none @endif">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">£</div>
                                                </div>
                                                <input type="text" class="form-control @if($attachmentType == 'None' || $lockType == 'Free') d-none @endif" placeholder="@lang('v19.unlockPrice')" wire:model="unlockPrice"/>
                                            </div>
                                        @endif
                                    </div>
                                </div>


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

                                {{--<button type="submit" class="btn btn-primary mr-0 mt-2 mb-2">
                                    <i class="far fa-paper-plane mr-1"></i> @lang('v19.sendMessage')
                                </button>--}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif

    </div><!-- ./row -->
    <div class="modal fade" id="massMessagesPopup" tabindex="-1" aria-labelledby="massMessagesPopupLabel" aria-hidden="true" wire:ignore>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="massMessagesPopupLabel">@lang('messages.massMessagesPopupTitle')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="massMessagesList">
                    @forelse($massMessageUsers as $p)
                        <div class="row no-gutters pt-2 pb-2 border-top">
                            <div class="col-12 col-sm-12 col-md-2">
                                <div class="profilePicXS mt-0 ml-0 mr-2 ml-2 shadow-sm">
                                    <span class="select-message-user @if($p->isOnline()) profilePicOnline @else profilePicOffline @endif">
                                        <img src="{{  $p->profile->profilePicture }}" alt="" width="50" height="50" class="select-message-user">
                                    </spsan>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-10">
                                <span class="d-none d-sm-none d-md-block text-dark select-message-user">
                                    {{ $p->profile->name }}
                                </span>
                                <small>
                                    <span class="text-secondary ml-2 ml-sm-2 ml-md-0 select-message-user">
                                        {{  $p->profile->handle }} 
                                    </span>
                                </small>
                            </div>
                        </div>
                        @empty
                            @lang('profile.noSubscriptions')
                    @endforelse
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" placeholder="Type a message" wire:model.lazy="massMessage" wire:ignore></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" wire:click="sendMassMessage">Send</span></button>
                </div>
            </div>
        </div>
    </div>

</div>

