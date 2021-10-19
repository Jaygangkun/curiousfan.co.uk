<?php
/**
 * Files updated array list
 * 
 * @var $filesList[]
**/
$filesList = [

    // folders
    'vendor/composer',
    'vendor/doctrine',
    'vendor/mercadopago',
    'vendor/autoload.php',
    'composer.json',
    'composer.lock',

    // controllers 
    'app/Http/Controllers/PostsController.php',
    'app/Http/Controllers/MessagesController.php',
    'app/Http/Livewire/Message.php',
    'app/Http/Livewire/NotificationsPage.php',
    'app/Http/Controllers/StripeController.php',
    'app/Http/Controllers/Admin.php',
    'app/Http/Controllers/CCBillController.php',
    'app/Http/Controllers/PayStackController.php',
    'app/Http/Controllers/WebpayPlusController.php',
    'app/Http/Controllers/TipsController.php',
    'app/Http/Controllers/MercadoPagoController.php',

    // middleware
    
    // models
    'app/User.php',
    'app/Post.php',
    'app/PostMedia.php',
    'app/Message.php',
    'app/MessageMedia.php',
    'app/Unlock.php',

    // views
    'resources/views/emails/adminContentReported.blade.php',
    'resources/views/subscribe/paypal.blade.php',
    'resources/views/user-feed.blade.php',
    'resources/views/profile/user-profile.blade.php',
    'resources/views/posts/create-post.blade.php',
    'resources/views/posts/edit-post.blade.php',
    'resources/views/posts/post-media.blade.php',
    'resources/views/livewire/message.blade.php',
    'resources/views/messages/message-media.blade.php',
    'resources/views/messages/single-media.blade.php',
    'resources/views/messages/inbox.blade.php',
    'resources/views/emails/unlockedMessageMail.blade.php',
    'resources/views/livewire/notifications-page.blade.php',
    'resources/views/admin/base.blade.php',
    'resources/views/admin/unlocks.blade.php',
    'resources/views/admin/dashboard.blade.php',
    'resources/views/messages/paypal-unlocking.blade.php',
    'resources/views/messages/transbank-unlock.blade.php',
    'resources/views/livewire/admin-payment-settings.blade.php',
    'resources/views/tips/tip-form.blade.php',
    'resources/views/profile/user-profile.blade.php',
    'resources/views/admin/content-moderation.blade.php',
    'resources/views/welcome.blade.php',

    // lang
    'resources/lang/en/v19.php',
    
    // routes
    'routes/web.php',
    
    // images
    'images/powered-by-mercadopago.png',

    // helpers

    // css

    // others
    'config/livewire.php',
    'js/jquery.MultiFile.min.js',
    'app/Providers/AppServiceProvider.php',
    'app/Notifications/UnlockedMessageNotification.php',
    'app/Mail/UnlockedMessageMail.php',
    'app/Http/Middleware/VerifyCsrfToken.php',
    'js/app.js',
    'config/database.php',
    'app/Http/Middleware/UserLastAuthMiddleware.php',

    // version related
    'index.php',

];
