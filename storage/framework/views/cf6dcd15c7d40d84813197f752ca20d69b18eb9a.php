<nav class="navbar navbar-expand-md navbar-light navbar-white fixed-top bg-white top-navbar">
  <a class="navbar-brand top-navbar-brand" href="<?php if(auth()->user()): ?><?php echo e(route('feed')); ?><?php else: ?> <?php echo e(route('home')); ?><?php endif; ?>">
    <?php if($logo = opt('site_logo')): ?>
      
      <img src="<?php echo e(asset($logo)); ?>" alt="logo" class="site-logo" style="width:180px;"/>
    <?php else: ?>
      <?php echo e(opt( 'site_title' )); ?>

    <?php endif; ?>
  </a>
  <div class="collapse navbar-collapse d-none d-sm-none d-md-block" id="navbarsExampleDefault">
    <ul class="navbar-nav">
      <?php if( auth()->guest() ): ?>
      <li class="nav-item">
        <a class="nav-link" href="/"><?php echo app('translator')->get( 'navigation.home' ); ?> <span class="sr-only">(current)</span></a>
      </li>
      <?php endif; ?>
      <?php if( !auth()->guest() ): ?>
      <!-- <li class="nav-item">
        <a class="nav-link" href="<?php echo e(route('feed')); ?>"><i class="fa fa-home" aria-hidden="true"></i>
    <?php echo app('translator')->get('navigation.feed'); ?></a>
      </li> -->
      <!-- uncommented as asked by client to do -->
      <!-- <li class="nav-item">
        <?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('notifications-icon')->dom;
} elseif ($_instance->childHasBeenRendered('HU0SKhN')) {
    $componentId = $_instance->getRenderedChildComponentId('HU0SKhN');
    $componentTag = $_instance->getRenderedChildComponentTagName('HU0SKhN');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('HU0SKhN');
} else {
    $response = \Livewire\Livewire::mount('notifications-icon');
    $dom = $response->dom;
    $_instance->logRenderedChild('HU0SKhN', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?> 
      </li> -->
      
      <!-- <li class="nav-item">
          <?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('unread-messages-count')->dom;
} elseif ($_instance->childHasBeenRendered('IH66hO7')) {
    $componentId = $_instance->getRenderedChildComponentId('IH66hO7');
    $componentTag = $_instance->getRenderedChildComponentTagName('IH66hO7');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('IH66hO7');
} else {
    $response = \Livewire\Livewire::mount('unread-messages-count');
    $dom = $response->dom;
    $_instance->logRenderedChild('IH66hO7', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>
      </li> -->
      <?php endif; ?>
      <!-- <li class="nav-item">
        <a class="nav-link" href="<?php if(auth()->guest()): ?> <?php echo e(route('register')); ?> <?php else: ?> <?php echo e(route('profile.show', ['username' => auth()->user()->profile->username ])); ?> <?php endif; ?>">
          <?php if( auth()->guest() ): ?>
            <i class="fas fa-sign-in-alt mr-1"></i>
            <?php echo app('translator')->get('navigation.startMyPage'); ?>
          <?php else: ?>
            <i class="fas fa-user-circle"></i> <?php echo app('translator')->get('navigation.myProfile'); ?>
          <?php endif; ?>
        </a>
      </li> -->
      <?php if(!auth()->guest()): ?>
      <!-- <li class="nav-item">
        <a class="nav-link" href="<?php echo e(route('accountSettings')); ?>">
          <i class="fas fa-cog"></i>
          <?php echo app('translator')->get('navigation.account'); ?>
        </a>
      </li> -->
      <?php endif; ?>
    </ul>
  </div>

  <ul class="navbar-nav ml-auto nav-flex-icons notification-nav">
    <li class="nav-item avatar dropdown">
      <?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('unread-messages-count')->dom;
} elseif ($_instance->childHasBeenRendered('X39DJzF')) {
    $componentId = $_instance->getRenderedChildComponentId('X39DJzF');
    $componentTag = $_instance->getRenderedChildComponentTagName('X39DJzF');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('X39DJzF');
} else {
    $response = \Livewire\Livewire::mount('unread-messages-count');
    $dom = $response->dom;
    $_instance->logRenderedChild('X39DJzF', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>
    </li>
    <li class="nav-item avatar dropdown">
      <a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
      <span class="badge badge-danger ml-2" id="unread-notification-count"
      <?php if(auth()->user()->unreadNotifications()->count() != 0): ?>
      style="display: inline-table;"
      <?php else: ?>
      style="display: none;"
      <?php endif; ?>
      ><?php echo e(auth()->user()->unreadNotifications()->count()); ?></span>
        <i class="fas fa-bell"></i>
      </a>
      <div class="dropdown-menu-lg-right dropdown-secondary" aria-labelledby="navbarDropdownMenuLink-5">
        <div class="notification-list">
          <?php $__currentLoopData = auth()->user()->notifications()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="notifications-item">
            <div class="text">
              <?php if($notification->type == 'App\Notifications\ReceivedLike'): ?>
                <?php echo app('translator')->get('general.userLikesPost', [ 
                                                'user' => '<a href="'.route('profile.show', 
                                                          [ 
                                                              'username' => $notification->data['user'] 
                                                          ]).'">@'.$notification->data['user'].'</a>', 
                                                'postUrl' => '<a href='.route('single-post', 
                                                            [
                                                                'post' => $notification->data['postId']
                                                            ]).'>post</a>'
                                                ]); ?>
              <?php elseif($notification->type == 'App\Notifications\NewSubscriberNotification'): ?> 
              
              
                  <?php echo app('translator')->get('general.newFan', [ 'user' => '<a href="'.route('profile.show', ['username' => $notification->data['username']]).'">@'.$notification->data['username'].'</a>' ]); ?>

              <?php elseif($notification->type == 'App\Notifications\PaymentActionRequired'): ?>

                  <?php echo app('translator')->get('general.paymentVerificationRequired', 
                          [
                              'amount' => opt('payment-settings.currency_symbol') .  $notification->data['amount'],
                          ]); ?>
                  <br>
                  <a href="<?php echo e($notification->data['invoice_url']); ?>" target="_blank"><?php echo app('translator')->get('general.fixVerification'); ?></a>

              <?php elseif($notification->type == 'App\Notifications\InovicePaidNotification'): ?>

                  <?php echo app('translator')->get('general.invoicePaidNotification', [
                  'amount' => opt('payment-settings.currency_symbol') . $notification->data['amount'],
                  'creator' => '<a href="'.route('profile.show', ['username' => $notification->data['to_creator']]).'">@'.$notification->data['to_creator'].'</a>',
                  'viewInvoice' => '<a href="'.$notification->data['invoice_url'].'" target="_blank">'.__('general.view_invoice').'</a>',
                  ]); ?>

              <?php elseif($notification->type == 'App\Notifications\ReceivedComment'): ?> 

              <?php if(isset($notification->data['commentator'])): ?>

                  <?php echo app('translator')->get('general.userCommentsOnPost', [ 
                                                      'user' => '<a href="'.route('profile.show', ['username' => $notification->data['commentator']['profile']['username'] ]).'" class="d-inline">
                                                              @'.$notification->data['commentator']['profile']['username'].'
                                                        </a>',
                                                      'postUrl' => '<a href="'.route('single-post', 
                                                              [
                                                                  'post' => $notification->data['commentable_id']
                                                              ]).'">post</a>'
                                                      ]); ?>

              <?php else: ?>
                  <?php echo app('translator')->get('general.userCommentsOnPost', [ 
                                                      'user' => '<a href="'.route('profile.show', ['username' => $notification->data['commentable']['user']['profile']['username'] ]).'" class="d-inline">
                                                              @'.$notification->data['commentable']['user']['profile']['username'].'
                                                        </a>',
                                                      'postUrl' => '<a href="'.route('single-post', 
                                                              [
                                                                  'post' => $notification->data['commentable_id']
                                                              ]).'">post</a>'
                                                      ]); ?>
              <?php endif; ?>

              <?php elseif($notification->type == 'App\Notifications\ReceivedPostMentionNotification'): ?>

                  <?php echo app('translator')->get('general.mentionNotification', [
                                                      'user' => '<a href="'.route('profile.show', ['username' => $notification->data[0]['user']['profile']['username'] ]).'" class="d-inline">
                                                              @'.$notification->data[0]['user']['profile']['username'].'
                                                        </a>',
                                                      'post' => '<a href="'.route('single-post', 
                                                              [
                                                                  'post' => $notification->data[0]['id']
                                                              ]).'">post</a>'
                                                      ]); ?>

              <?php elseif($notification->type == 'App\Notifications\NewFollower'): ?>

                  <?php echo app('translator')->get('general.newFreeFollowerNotification', [ 'user' => '<a href="'.route('profile.show', ['username' => $notification->data['profile']['username']]).'" class="d-inline">@'.$notification->data['profile']['username'].'</a>' ]); ?>

              <?php elseif($notification->type == 'App\Notifications\TipReceivedNotification'): ?>
                                          
                  <?php echo app('translator')->get('general.tipReceivedNotification', [
                      'tipper' => '<a href="'.route('profile.show', ['username' => $notification->data['from_user']]).'">'.$notification->data['from_handle'].'</a>',
                      'amount' => opt('payment-settings.currency_symbol') . $notification->data['amount']
                  ]); ?>

              <?php elseif($notification->type == 'App\Notifications\UnlockedMessageNotification'): ?>
                                          
                  <?php echo app('translator')->get('v19.unlockedMessageNotification', [
                      'tipper' => '<a href="'.route('profile.show', ['username' => $notification->data['from_user']]).'">'.$notification->data['from_handle'].'</a>',
                      'amount' => opt('payment-settings.currency_symbol') . $notification->data['amount']
                  ]); ?>                                    

              <?php elseif($notification->type == 'App\Notifications\ProfileApprovedNotification'): ?>
                                          
                  <?php echo app('translator')->get('v19.profileApproved', [
                  ]); ?>
            
              <?php elseif($notification->type == 'App\Notifications\ProfileRejectedNotification'): ?>
                                          
                  <?php echo app('translator')->get('v19.profileRejected', [
                  ]); ?>                                    

              <?php elseif($notification->type == 'App\Notifications\AdminNotify'): ?>
                  <b>
                  <?php echo e($notification->data['title']); ?>

                  </b>
                  <br/>
                  <span>
                  <?php echo e($notification->data['msg']); ?>

                  </span>
              <?php endif; ?>
              <br>
              <i class="fas fa-clock"></i> <?php echo e($notification->created_at->diffForHumans()); ?>

            </div>
            <hr>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="notification-bottom">
          <button type="button" class="btn btn-danger" id="delete-notifications-btn" aria-label="Right Align">
            <i class="fas fa-trash-alt"></i>
          </button>
        </div>
      </div>
    </li>
  </ul>

  <?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('search-creators')->dom;
} elseif ($_instance->childHasBeenRendered('VjWvNOY')) {
    $componentId = $_instance->getRenderedChildComponentId('VjWvNOY');
    $componentTag = $_instance->getRenderedChildComponentTagName('VjWvNOY');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('VjWvNOY');
} else {
    $response = \Livewire\Livewire::mount('search-creators');
    $dom = $response->dom;
    $_instance->logRenderedChild('VjWvNOY', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>

  <div class="mobile-navi d-block d-sm-block d-md-none custom-nv">
    <?php if( auth()->guest() ): ?>
      <a href="/" class="text-dark">
        <i class="fas fa-home mr-1"></i>
        <span>News Feed</span>
      </a>
    <?php else: ?>
      <a href="<?php echo e(route('feed')); ?>" class="text-dark">
        <i class="fas fa-home mr-1"></i>
        <span>News Feed</span>
      </a>

      <a href="<?php echo e(route('notifications.index')); ?>" data-count="<?php echo e(auth()->user()->unreadNotifications()->count()); ?>" class="text-dark m_n_c">
        <i class="fas fa-bell mr-1"></i>
        <small class="text-danger text-bold mob_notification" data-count="<?php echo e(auth()->user()->unreadNotifications()->count()); ?>"><?php echo e(auth()->user()->unreadNotifications()->count()); ?></small>
        <span> Notifications</span>
      </a>
      
      <a href="<?php echo e(route('profile.show', ['username' => auth()->user()->profile->username ])); ?>" class="text-dark">
        <i class="fas fa-user-circle mr-1"></i>
        <span> Profile</span>
      </a>
    <?php endif; ?>
 
  
  <?php if( auth()->guest() ): ?>
    <a href="<?php echo e(route('register')); ?>" class="text-dark">
    <span>Profile</span>
      <i class="fas fa-user-plus"></i>
    </a>
  <?php else: ?>
    <a href="<?php echo e(route('messages.inbox')); ?>" class="text-dark m_n_c">
      <i class="far fa-envelope mr-1"></i>
      <span>Messages</span>
      <?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('mob-unread-messages-count')->dom;
} elseif ($_instance->childHasBeenRendered('4BMd7Uo')) {
    $componentId = $_instance->getRenderedChildComponentId('4BMd7Uo');
    $componentTag = $_instance->getRenderedChildComponentTagName('4BMd7Uo');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('4BMd7Uo');
} else {
    $response = \Livewire\Livewire::mount('mob-unread-messages-count');
    $dom = $response->dom;
    $_instance->logRenderedChild('4BMd7Uo', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>
    </a>
  
    <a href="<?php echo e(route('startMyPage')); ?>" class="text-dark" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
      <i class="fas fa-bars mr-1"></i>
      <span>Menu</span>
    </a>
                                                 
  <?php endif; ?>
</ul>
</div>
</nav>

<?php if(! auth()->guest() ): ?>
<div class="collapse" id="collapseExample">
  <div class="card card-body mt-5">
    <ul class="nav flex-column">
      <?php if( isset( auth()->user()->profile ) ): ?>
      <li class="nav-item nav-item-side">
        <a class="nav-link nav-side-link" href="/<?php echo e(auth()->user()->profile->username); ?>">
          <i class="far fa-meh-blank mr-1"></i>
          <?php echo app('translator')->get('dashboard.viewProfile'); ?>
        </a>
      </li>
      <?php endif; ?>
      <!-- <li class="nav-item nav-item-side">
        <a class="nav-link nav-side-link <?php if(isset($active) && $active == 'my-profile'): ?> side-active <?php endif; ?>" href="<?php echo e(route('startMyPage')); ?>">
          <i class="far fa-edit mr-1"></i>
          <?php echo app('translator')->get('dashboard.myProfile'); ?>
        </a>
      </li>
      <li class="nav-item nav-item-side">
        <a class="nav-link nav-side-link" href="/<?php echo e(auth()->user()->profile->username); ?>">
          <i class="fas fa-pen-alt mr-1"></i>
            <?php echo app('translator')->get('dashboard.createPost'); ?>
        </a>
      </li>
      <li class="nav-item nav-item-side">
        <a class="nav-link nav-side-link" href="<?php echo e(route('messages.inbox')); ?>">
          <i class="far fa-envelope mr-1"></i> 
          <?php echo app('translator')->get('navigation.messages'); ?>
        </a>
      </li> -->
      <li class="nav-item nav-item-side">
        <a class="nav-link nav-side-link <?php if(isset($active) && $active == 'my-subscribers'): ?> side-active <?php endif; ?>" href="<?php echo e(route('mySubscribers')); ?>">
          <i class="fas fa-user-lock"></i> 
          <?php echo app('translator')->get('navigation.my-subscribers'); ?>
        </a>
      </li>
      <li class="nav-item nav-item-side">
        <a class="nav-link nav-side-link <?php if(isset($active) && $active == 'my-subscriptions'): ?> side-active <?php endif; ?>" href="<?php echo e(route('mySubscriptions')); ?>">
          <i class="fas fa-user-edit"></i>
          <?php echo app('translator')->get('navigation.my-subscriptions'); ?>
        </a>
      </li>
      <li class="nav-item nav-item-side">
        <a class="nav-link nav-side-link <?php if(isset($active) && $active == 'my-blocked-users'): ?> side-active <?php endif; ?>" href="<?php echo e(route('myBlockedUsers')); ?>">
          <i class="fas fa-user-edit"></i>
          <?php echo app('translator')->get('navigation.my-blocked-users'); ?>
        </a>
      </li>
      <li class="nav-item nav-item-side">
        <a class="nav-link nav-side-link" href="<?php echo e(route('billing.history')); ?>">
          <i class="fas fa-file-invoice-dollar mr-2"></i>
          <?php echo app('translator')->get('navigation.billing'); ?>
        </a>
      </li>
      <?php if( opt('stripeEnable', 'No') == 'Yes' OR opt('card_gateway', 'Stripe') == 'PayStack' ): ?>
      <li class="nav-item nav-item-side">
        <a class="nav-link nav-side-link" href="<?php echo e(route('billing.cards')); ?>">
          <i class="fas fa-credit-card mr-1"></i> 
          <?php echo app('translator')->get('navigation.cards'); ?>
        </a>
      </li>
      <?php endif; ?>
      <?php if(auth()->user()->profile->isVerified == 'Yes'): ?>
      <li class="nav-item nav-item-side">
        <a class="nav-link nav-side-link <?php if(isset($active) && $active == 'withdraw'): ?> side-active <?php endif; ?>" href="<?php echo e(route( 'profile.withdrawal' )); ?>">
          <i class="fas fa-coins mr-1"></i> <?php echo app('translator')->get('dashboard.withdrawal'); ?>
        </a>
      </li>
      <?php endif; ?>
      <li class="nav-item nav-item-side">
        <a class="nav-link nav-side-link <?php if(isset($active) && $active == 'set-fee'): ?> side-active <?php endif; ?>" href="<?php echo e(route( 'profile.setFee' )); ?>">
          <i class="fas fa-comment-dollar mr-1"></i> <?php echo app('translator')->get('dashboard.creatorSetup'); ?>
        </a>
      </li>
      <li class="nav-item nav-item-side">
        <a class="nav-link nav-side-link <?php if(isset($active) && $active == 'settings'): ?> side-active <?php endif; ?>" href="<?php echo e(route('accountSettings')); ?>">
          <i class="fas fa-cog mr-1"></i> <?php echo app('translator')->get('dashboard.accountSettings'); ?>
        </a>
      </li>
    </ul>
  </div>
</div>
<?php endif; ?><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/partials/topnavi.blade.php ENDPATH**/ ?>