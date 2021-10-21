<nav class="navbar navbar-expand-md navbar-light navbar-white fixed-top bg-white top-navbar">
  <a class="navbar-brand top-navbar-brand" href="@if(auth()->user()){{ route('feed') }}@else {{ route('home') }}@endif">
    @if($logo = opt('site_logo'))
      {{-- <img src="{{ config('app.url') }}/images/curiousfan-logo-new.svg" alt="logo" class="site-logo" style="width:180px;"/> --}}
      <img src="{{ asset($logo) }}" alt="logo" class="site-logo"/>
    @else
      {{ opt( 'site_title' ) }}
    @endif
  </a>
  <div class="collapse navbar-collapse d-none d-sm-none d-md-block" id="navbarsExampleDefault">
    <ul class="navbar-nav">
      @if( auth()->guest() )
      <li class="nav-item">
        <a class="nav-link" href="/">@lang( 'navigation.home' ) <span class="sr-only">(current)</span></a>
      </li>
      @endif
      @if( !auth()->guest() )
      <!-- <li class="nav-item">
        <a class="nav-link" href="{{ route('feed') }}"><i class="fa fa-home" aria-hidden="true"></i>
    @lang('navigation.feed')</a>
      </li> -->
      <!-- uncommented as asked by client to do -->
      <!-- <li class="nav-item">
        @livewire('notifications-icon') 
      </li> -->
      
      <!-- <li class="nav-item">
          @livewire('unread-messages-count')
      </li> -->
      @endif
      <!-- <li class="nav-item">
        <a class="nav-link" href="@if(auth()->guest()) {{ route('register') }} @else {{ route('profile.show', ['username' => auth()->user()->profile->username ]) }} @endif">
          @if( auth()->guest() )
            <i class="fas fa-sign-in-alt mr-1"></i>
            @lang('navigation.startMyPage')
          @else
            <i class="fas fa-user-circle"></i> @lang('navigation.myProfile')
          @endif
        </a>
      </li> -->
      @if(!auth()->guest())
      <!-- <li class="nav-item">
        <a class="nav-link" href="{{  route('accountSettings') }}">
          <i class="fas fa-cog"></i>
          @lang('navigation.account')
        </a>
      </li> -->
      @endif
    </ul>
  </div>

  <ul class="navbar-nav ml-auto nav-flex-icons notification-nav">
    <li class="nav-item avatar dropdown">
      @livewire('unread-messages-count')
    </li>
    <li class="nav-item avatar dropdown">
      <a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
      <span class="badge badge-danger ml-2" id="unread-notification-count"
      @if(auth()->user()->unreadNotifications()->count() != 0)
      style="display: inline-table;"
      @else
      style="display: none;"
      @endif
      >{{auth()->user()->unreadNotifications()->count()}}</span>
        <i class="fas fa-bell"></i>
      </a>
      <div class="dropdown-menu-lg-right dropdown-secondary" aria-labelledby="navbarDropdownMenuLink-5">
        <div class="notification-list">
          @foreach(auth()->user()->notifications()->get() as $notification)
          <div class="notifications-item">
            <div class="text">
              @if($notification->type == 'App\Notifications\ReceivedLike')
                @lang('general.userLikesPost', [ 
                                                'user' => '<a href="'.route('profile.show', 
                                                          [ 
                                                              'username' => $notification->data['user'] 
                                                          ]).'">@'.$notification->data['user'].'</a>', 
                                                'postUrl' => '<a href='.route('single-post', 
                                                            [
                                                                'post' => $notification->data['postId']
                                                            ]).'>post</a>'
                                                ])
              @elseif($notification->type == 'App\Notifications\NewSubscriberNotification') 
              
              
                  @lang('general.newFan', [ 'user' => '<a href="'.route('profile.show', ['username' => $notification->data['username']]).'">@'.$notification->data['username'].'</a>' ])

              @elseif($notification->type == 'App\Notifications\PaymentActionRequired')

                  @lang('general.paymentVerificationRequired', 
                          [
                              'amount' => opt('payment-settings.currency_symbol') .  $notification->data['amount'],
                          ])
                  <br>
                  <a href="{{ $notification->data['invoice_url'] }}" target="_blank">@lang('general.fixVerification')</a>

              @elseif($notification->type == 'App\Notifications\InovicePaidNotification')

                  @lang('general.invoicePaidNotification', [
                  'amount' => opt('payment-settings.currency_symbol') . $notification->data['amount'],
                  'creator' => '<a href="'.route('profile.show', ['username' => $notification->data['to_creator']]).'">@'.$notification->data['to_creator'].'</a>',
                  'viewInvoice' => '<a href="'.$notification->data['invoice_url'].'" target="_blank">'.__('general.view_invoice').'</a>',
                  ])

              @elseif($notification->type == 'App\Notifications\ReceivedComment') 

              @if(isset($notification->data['commentator']))

                  @lang('general.userCommentsOnPost', [ 
                                                      'user' => '<a href="'.route('profile.show', ['username' => $notification->data['commentator']['profile']['username'] ]).'" class="d-inline">
                                                              @'.$notification->data['commentator']['profile']['username'].'
                                                        </a>',
                                                      'postUrl' => '<a href="'.route('single-post', 
                                                              [
                                                                  'post' => $notification->data['commentable_id']
                                                              ]).'">post</a>'
                                                      ])

              @else
                  @lang('general.userCommentsOnPost', [ 
                                                      'user' => '<a href="'.route('profile.show', ['username' => $notification->data['commentable']['user']['profile']['username'] ]).'" class="d-inline">
                                                              @'.$notification->data['commentable']['user']['profile']['username'].'
                                                        </a>',
                                                      'postUrl' => '<a href="'.route('single-post', 
                                                              [
                                                                  'post' => $notification->data['commentable_id']
                                                              ]).'">post</a>'
                                                      ])
              @endif

              @elseif($notification->type == 'App\Notifications\ReceivedPostMentionNotification')

                  @lang('general.mentionNotification', [
                                                      'user' => '<a href="'.route('profile.show', ['username' => $notification->data[0]['user']['profile']['username'] ]).'" class="d-inline">
                                                              @'.$notification->data[0]['user']['profile']['username'].'
                                                        </a>',
                                                      'post' => '<a href="'.route('single-post', 
                                                              [
                                                                  'post' => $notification->data[0]['id']
                                                              ]).'">post</a>'
                                                      ])

              @elseif($notification->type == 'App\Notifications\NewFollower')

                  @lang('general.newFreeFollowerNotification', [ 'user' => '<a href="'.route('profile.show', ['username' => $notification->data['profile']['username']]).'" class="d-inline">@'.$notification->data['profile']['username'].'</a>' ])

              @elseif($notification->type == 'App\Notifications\TipReceivedNotification')
                                          
                  @lang('general.tipReceivedNotification', [
                      'tipper' => '<a href="'.route('profile.show', ['username' => $notification->data['from_user']]).'">'.$notification->data['from_handle'].'</a>',
                      'amount' => opt('payment-settings.currency_symbol') . $notification->data['amount']
                  ])

              @elseif($notification->type == 'App\Notifications\UnlockedMessageNotification')
                                          
                  @lang('v19.unlockedMessageNotification', [
                      'tipper' => '<a href="'.route('profile.show', ['username' => $notification->data['from_user']]).'">'.$notification->data['from_handle'].'</a>',
                      'amount' => opt('payment-settings.currency_symbol') . $notification->data['amount']
                  ])                                    

              @elseif($notification->type == 'App\Notifications\ProfileApprovedNotification')
                                          
                  @lang('v19.profileApproved', [
                  ])
            
              @elseif($notification->type == 'App\Notifications\ProfileRejectedNotification')
                                          
                  @lang('v19.profileRejected', [
                  ])                                    

              @elseif($notification->type == 'App\Notifications\AdminNotify')
                  <b>
                  {{ $notification->data['title'] }}
                  </b>
                  <br/>
                  <span>
                  {{ $notification->data['msg'] }}
                  </span>
              @endif
              <br>
              <i class="fas fa-clock"></i> {{ $notification->created_at->diffForHumans() }}
            </div>
            <hr>
          </div>
          @endforeach
        </div>
        <div class="notification-bottom">
          <button type="button" class="btn btn-danger" id="delete-notifications-btn" aria-label="Right Align">
            <i class="fas fa-trash-alt"></i>
          </button>
        </div>
      </div>
    </li>
  </ul>

  @livewire('search-creators')

  <div class="mobile-navi d-block d-sm-block d-md-none custom-nv">
    @if( auth()->guest() )
      <a href="/" class="text-dark">
        <i class="fas fa-home mr-1"></i>
        <span>News Feed</span>
      </a>
    @else
      <a href="{{ route('feed') }}" class="text-dark">
        <i class="fas fa-home mr-1"></i>
        <span>News Feed</span>
      </a>

      <a href="{{ route('notifications.index') }}" data-count="{{auth()->user()->unreadNotifications()->count()}}" class="text-dark m_n_c">
        <i class="fas fa-bell mr-1"></i>
        <small class="text-danger text-bold mob_notification" data-count="{{auth()->user()->unreadNotifications()->count()}}">{{auth()->user()->unreadNotifications()->count()}}</small>
        <span> Notifications</span>
      </a>
      
      <a href="{{ route('profile.show', ['username' => auth()->user()->profile->username ]) }}" class="text-dark">
        <i class="fas fa-user-circle mr-1"></i>
        <span> Profile</span>
      </a>
    @endif
 {{-- <a href="{{ route('browseCreators') }}" class="text-dark">
    <i class="fab fa-safari mr-1"></i>
  </a> --}}
  {{--<a href="@if(auth()->guest()) {{ route('startMyPage') }} @else {{ route('profile.show', ['username' => auth()->user()->profile->username ]) }} @endif" class="text-dark">
    @if( auth()->guest() )
      <i class="fas fa-sign-in-alt mr-1"></i>
    @else
      <i class="fas fa-at mr-1"></i>
    @endif
  </a> --}}
  @if( auth()->guest() )
    <a href="{{ route('register') }}" class="text-dark">
    <span>Profile</span>
      <i class="fas fa-user-plus"></i>
    </a>
  @else
    <a href="{{ route('messages.inbox') }}" class="text-dark m_n_c">
      <i class="far fa-envelope mr-1"></i>
      <span>Messages</span>
      @livewire('mob-unread-messages-count')
    </a>
  
    <a href="{{ route('startMyPage') }}" class="text-dark" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
      <i class="fas fa-bars mr-1"></i>
      <span>Menu</span>
    </a>
   {{-- <a class="text-dark" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                     <i class="fas fa-sign-out-alt"></i></a>  --}}                                              
  @endif
</ul>
</div>
</nav>

@if(! auth()->guest() )
<div class="collapse" id="collapseExample">
  <div class="card card-body mt-5">
    <ul class="nav flex-column">
      @if( isset( auth()->user()->profile ) )
      <li class="nav-item nav-item-side">
        <a class="nav-link nav-side-link" href="/{{ auth()->user()->profile->username }}">
          <i class="far fa-meh-blank mr-1"></i>
          @lang('dashboard.viewProfile')
        </a>
      </li>
      @endif
      <!-- <li class="nav-item nav-item-side">
        <a class="nav-link nav-side-link @if(isset($active) && $active == 'my-profile') side-active @endif" href="{{ route('startMyPage') }}">
          <i class="far fa-edit mr-1"></i>
          @lang('dashboard.myProfile')
        </a>
      </li>
      <li class="nav-item nav-item-side">
        <a class="nav-link nav-side-link" href="/{{ auth()->user()->profile->username }}">
          <i class="fas fa-pen-alt mr-1"></i>
            @lang('dashboard.createPost')
        </a>
      </li>
      <li class="nav-item nav-item-side">
        <a class="nav-link nav-side-link" href="{{ route('messages.inbox') }}">
          <i class="far fa-envelope mr-1"></i> 
          @lang('navigation.messages')
        </a>
      </li> -->
      <li class="nav-item nav-item-side">
        <a class="nav-link nav-side-link @if(isset($active) && $active == 'my-subscribers') side-active @endif" href="{{ route('mySubscribers') }}">
          <i class="fas fa-user-lock"></i> 
          @lang('navigation.my-subscribers')
        </a>
      </li>
      <li class="nav-item nav-item-side">
        <a class="nav-link nav-side-link @if(isset($active) && $active == 'my-subscriptions') side-active @endif" href="{{ route('mySubscriptions') }}">
          <i class="fas fa-user-edit"></i>
          @lang('navigation.my-subscriptions')
        </a>
      </li>
      <li class="nav-item nav-item-side">
        <a class="nav-link nav-side-link @if(isset($active) && $active == 'my-blocked-users') side-active @endif" href="{{ route('myBlockedUsers') }}">
          <i class="fas fa-user-edit"></i>
          @lang('navigation.my-blocked-users')
        </a>
      </li>
      <li class="nav-item nav-item-side">
        <a class="nav-link nav-side-link" href="{{ route('billing.history') }}">
          <i class="fas fa-file-invoice-dollar mr-2"></i>
          @lang('navigation.billing')
        </a>
      </li>
      @if( opt('stripeEnable', 'No') == 'Yes' OR opt('card_gateway', 'Stripe') == 'PayStack' )
      <li class="nav-item nav-item-side">
        <a class="nav-link nav-side-link" href="{{ route('billing.cards') }}">
          <i class="fas fa-credit-card mr-1"></i> 
          @lang('navigation.cards')
        </a>
      </li>
      @endif
      @if(auth()->user()->profile->isVerified == 'Yes')
      <li class="nav-item nav-item-side">
        <a class="nav-link nav-side-link @if(isset($active) && $active == 'withdraw') side-active @endif" href="{{ route( 'profile.withdrawal' )}}">
          <i class="fas fa-coins mr-1"></i> @lang('dashboard.withdrawal')
        </a>
      </li>
      @endif
      <li class="nav-item nav-item-side">
        <a class="nav-link nav-side-link @if(isset($active) && $active == 'set-fee') side-active @endif" href="{{ route( 'profile.setFee' )}}">
          <i class="fas fa-comment-dollar mr-1"></i> @lang('dashboard.creatorSetup')
        </a>
      </li>
      <li class="nav-item nav-item-side">
        <a class="nav-link nav-side-link @if(isset($active) && $active == 'settings') side-active @endif" href="{{ route('accountSettings') }}">
          <i class="fas fa-cog mr-1"></i> @lang('dashboard.accountSettings')
        </a>
      </li>
    </ul>
  </div>
</div>
@endif