<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
    <meta name="author" content="crivion">
    <meta name="description" content="Users can pay for content (photos and videos) via a monthly membership. Content is mainly created by YouTubers, fitness trainers and models.">
    <meta name="robots" content="FOLLOW, INDEX">
    
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6431223658198810"
     crossorigin="anonymous"></script>

    {{--Social Media Tags--}}
    <!--  Essential META Tags -->
    <meta property="og:type" content= "website" />
    <meta property="og:title" content="@yield('title', 'Curiousfan - Interact with your fans and make money.')">
    <meta property="og:description" content="@yield('description', 'Users can pay for content (photos and videos) via a monthly membership. Content is mainly created by YouTubers, fitness trainers and models.')">
    <meta property="og:image"  content="@yield('image', asset('images/curiousfan-meta-logo-new.png'))">
    <meta property="og:url" content="{{ url()->full() }}">
    <meta property="og:updated_time" content="1000" />
    <meta name="twitter:card" content="summary">
    <meta name="twitter:domain" content="curiousfan.co.uk"/>
    <meta name="twitter:title" property="og:title" itemprop="name" content="Curiousfan - Interact with your fans and make money." />
    <meta name="twitter:description" property="og:description" itemprop="description" content="Users can pay for content (photos and videos) via a monthly membership. Content is mainly created by YouTubers, fitness trainers and models." />
    <!--  Non-Essential, But Recommended -->

    <meta property="og:site_name" content="Curiousfan - Interact with your fans and make money.">
    <meta name="twitter:image:alt" content="Curiousfan - Interact with your fans and make money.">


    <!--  Non-Essential, But Required for Analytics -->

    {{--<meta property="fb:app_id" content="your_app_id" />
    <meta name="twitter:site" content="@Curiousfan">--}}
    {{--Social Media Tags--}}

    <link rel="shortcut icon" type="image/png" href="{{ asset(opt('favicon', 'favicon.png')) }}" sizes="128x128" />
    <meta name="_token" content="{{ csrf_token() }}" />

    <title>@yield('seo_title', '') {{ opt( 'seo_title' ) }}</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!-- Growl CSS -->
    <link href="{{ asset('css/jquery.growl.css') }}" rel="stylesheet">

    <!-- FA CSS -->
    <link rel="stylesheet" href="{{ asset('css/fa/css/all.min.css') }}">

    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}" />

    <!-- Lightbox CSS -->
    <link href="{{ asset('css/ekko-lightbox.css') }}" rel="stylesheet">

    <!-- Cookie Consent -->
    <link href="{{ asset('css/cookieconsent.min.css') }}" rel="stylesheet">

    <!-- APP CSS -->
    <link href="{{ asset('css/app.css?v='.time()) }}" rel="stylesheet">

    <!-- At.js to autocomplete in Area -->
    <link href="{{ asset('css/jquery.atwho.css') }}" rel="stylesheet" type="text/css" />

    <!-- LOGIN PAGE CSS -->
    <link href="{{ asset('css/login.css?v='.time()) }}" rel="stylesheet">
    <link href="{{ asset('css/owl.carousel.css?v='.time()) }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/owl.theme.css?v='.time()) }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/owl.transitions.css?v='.time()) }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/carousel.css?v='.time()) }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.2/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
    <!-- Web Application Manifest -->
    <link rel="manifest" href="{{ route('pwa-manifest') }}">

    <!-- Chrome for Android theme color -->
    <meta name="theme-color" content="{{ config('pwa.manifest.theme_color') }}">

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="{{ config('pwa.manifest.display') == 'standalone' ? 'yes' : 'no' }}">
    <meta name="application-name" content="{{ opt('laravel_short_pwa', 'FansApp') }}">
    <link rel="icon" sizes="512x512" href="/{{ cache()->has('pwa_512x512') ? cache()->get('pwa_512x512') : opt('pwa_512x512', config('pwa.manifest.icons.512x512.path')) }}">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="{{ config('pwa.manifest.display') == 'standalone' ? 'yes' : 'no' }}">
    <meta name="apple-mobile-web-app-status-bar-style" content="{{  config('pwa.manifest.status_bar') }}">
    <meta name="apple-mobile-web-app-title" content="{{ opt('laravel_short_pwa', 'FansApp') }}">
    <link rel="apple-touch-icon" href="/{{ cache()->has('pwa_512x512') ? cache()->get('pwa_512x512') : opt('pwa_512x512', config('pwa.manifest.icons.512x512.path')) }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pace-js@latest/pace-theme-default.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('js/emoji/emojionearea.min.css?v='.time()) }}" media="screen">

    <link href="/{{ cache()->has('pwa_72x72') ? cache()->get('pwa_72x72') : opt('pwa_72x72', config('pwa.manifest.splash.640x1136')) }}" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="/{{ cache()->has('pwa_750x1334') ? cache()->get('pwa_750x1334') : opt('pwa_750x1334', config('pwa.manifest.splash.750x1334')) }}" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="/{{ cache()->has('pwa_1242x2208') ? cache()->get('pwa_1242x2208') : opt('pwa_1242x2208', config('pwa.manifest.splash.1242x2208')) }}" media="(device-width: 621px) and (device-height: 1104px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
    <link href="/{{ cache()->has('pwa_1125x2436') ? cache()->get('pwa_1125x2436') : opt('pwa_1125x2436', config('pwa.manifest.splash.1125x2436')) }}" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
    <link href="/{{ cache()->has('pwa_1536x2048') ? cache()->get('pwa_1536x2048') : opt('pwa_1536x2048', config('pwa.manifest.splash.1536x2048')) }}" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="/{{ cache()->has('pwa_1668x2224') ? cache()->get('pwa_1668x2224') : opt('pwa_1668x2224', config('pwa.manifest.splash.1668x2224')) }}" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="/{{ cache()->has('pwa_2048x2732') ? cache()->get('pwa_2048x2732') : opt('pwa_2048x2732', config('pwa.manifest.splash.2048x2732')) }}" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />

    <!-- Tile for Win8 -->
    <meta name="msapplication-TileColor" content="{{ config('pwa.manifest.background_color') }}">
    <meta name="msapplication-TileImage" content="/{{ cache()->has('pwa_512x512') ? cache()->get('pwa_512x512') : opt('pwa_512x512', config('pwa.manifest.icons.512x512.path')) }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css"/>
    <script type="text/javascript">
      // Initialize the service worker
      if ('serviceWorker' in navigator) {
          navigator.serviceWorker.register('/serviceworker.js', {
              scope: '.'
          }).then(function (registration) {
              // Registration was successful
              console.log('PWA: ServiceWorker registration successful with scope: ', registration.scope);
          }, function (err) {
              // registration failed :(
              console.log('PWA: ServiceWorker registration failed: ', err);
          });
      }
    </script>

    @livewireStyles
    <link href="{{ asset('css/custom.css?v='.time()) }}" rel="stylesheet" type="text/css" />
    <!-- Views CSS -->
    @stack( 'extraCSS' )

    <!-- Custom CSS from admin panel -->
    <style>
      @if($leftGradient = opt('hgr_left') AND $rightGradient = opt('hgr_right') AND $fontColor = opt('header_fcolor'))
      .website-header {
        background: {{ $leftGradient }};
        background: -webkit-linear-gradient(to left, {{ $leftGradient }}, {{ $rightGradient }});
        background: linear-gradient(to left, {{ $leftGradient }}, {{ $rightGradient }});
        color: {{ $fontColor }};
      }
      @endif
      @if($btnBg = opt('red_btn_bg') AND $btnFt = opt('red_btn_font'))
      .btn-danger, .btn-danger:hover, .btn-danger:active, .btn-danger:focus, .badge-danger, .btn-danger:not(:disabled):not(.disabled).active, .btn-danger:not(:disabled):not(.disabled):active, .show>.btn-danger.dropdown-toggle, .btn-danger:not(:disabled):not(.disabled).active:focus, .btn-danger:not(:disabled):not(.disabled):active:focus, .show>.btn-danger.dropdown-toggle:focus {
          background: {{ $btnBg }};
          border: {{ $btnBg }};
          color: {{ $btnFt }};
          box-shadow: none;
      }
      @endif
    </style>

    @if($extraCSS = opt('admin_extra_CSS'))
    <style>
    {!! $extraCSS !!}
    </style>
    @endif

    @if($extraRawJS = opt('admin_raw_JS'))
    {!! $extraRawJS !!}
    @endif

    <!-- Set JS variables -->
    <script>
    var currencySymbol = '{{ opt( 'payment-settings.currency_symbol' ) }}';
    var currencyCode   = '{{ opt( 'payment-settings.currency_code' ) }}';
    var platformFee    = {{ opt( 'payment-settings.site_fee' ) }};
    var pleaseWriteSomething = '@lang('post.pleaseWriteSomething')';
    var loadPostById = '{{ route( 'loadPostById', [ 'post' => '/' ] ) }}';
    var successfullyCopiedLink = '@lang('post.successfullyCopiedLink')';
    var friendRequestURI = '{{ route( 'followUser', [ 'user' => '/' ] ) }}';
    var loginURI = '{{ route( 'login') }}';
    var likeURI = '{{ route( 'likePost', [ 'post' => '/' ]) }}';
    var commentsURI = '{{ route( 'loadCommentsForPost', [ 'post' => '/', 'lastId' => '/' ]) }}';
    var postCommentURI = '{{ route('postComment', ['post'=>'/']) }}';
    var loadCommentByIdURI = '{{ route('loadCommentById', ['comment'=>'/', 'post' => '/']) }}';
    var deleteCommentURI = '{{ route('deleteComment', ['comment' => '/']) }}';
    var editCommentsURI = '{{  route('editComment', ['comment' => '/']) }}';
    var updateCommentsURI = '{{  route('updateComment') }}';
    var reportUserURI = '{{ route('reportUser') }}';
    var markAsReadNotificationsURI = '{{ route('markAsReadNotifications') }}';
    var deleteNotificationsURI = '{{ route('deleteNotifications') }}';
    var blockedUsersPageURI = '{{ route('myBlockedUsers') }}';
    var confirmButton = '@lang('validation.confirm-button')';
    var cancelButton = '@lang('validation.cancel-button')';
    var confirmationTitle = '@lang('validation.confirmation')';
    var confirmationMessage = '@lang('validation.confirmation_message')';
    var successfullyRemovedComment = '@lang('post.successfullyRemovedComment')';
    var successfullyRemovedPost =  '@lang('post.successfullyRemovedPost')';
    var textNo = '@lang('general.no')';
    var textYes = '@lang('general.yes')';
    </script>
    <!-- jQuery Lib -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/emoji/emojionearea.js') }}"></script>
    
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6431223658198810"
     crossorigin="anonymous"></script>

  </head>
  <body>
  @if($current_time_zone=Session::get('current_time_zone'))@endif
  <input type="hidden" id="hd_current_time_zone" value="{{{$current_time_zone}}}">
  <div id="wrap">
  <div id="main">

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    @if( !auth()->guest() )
      <div class="container">
        @include( 'partials/topnavi' )
      </div>
    @endif

    <main role="main">
      @yield( 'content' )
    </main>

  </div>
  </div>

      @include( 'partials/bottomnavi' )



    <script src="{{ asset('js/owl.carousel.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/carousel.js') }}"></script>
    <!-- Popper JS -->
    <script src="{{ asset('js/popper.min.js') }}"></script>

    <!-- Twitter Bootstrap 4 Lib -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <!-- jQuery UI JS -->
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

    <!-- FA JS -->
    <script src="{{ asset('css/fa/js/all.min.js') }}"></script>

    <!-- Clipboard JS -->
    <script src="{{ asset('js/clipboard.min.js') }}"></script>

    <!-- Growl JS -->
    <script src="{{ asset('js/jquery.growl.js') }}"></script>

    <!-- Ajax Form -->
    <script src="{{ asset('js/jquery.form.min.js') }}"></script>

    <!-- jquery jscroll -->
    <script src="{{ asset('js/jquery.jscroll.min.js') }}"></script>

    <!-- Lightbox JS -->
    <script src="{{ asset('js/ekko-lightbox.min.js') }}"></script>

    @livewireScripts

    <!-- SweetAlert JS -->
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>

    <!-- App JS -->
    <script src="{{ asset('js/app.js?v='.time()) }}"></script>

    <!-- At JS -->
    <script src="{{ asset('js/jquery.atwho.min.js') }}"></script>
    <script src="{{ asset('js/jquery.caret.js') }}"></script>

    <script src="{{ asset( 'js/cookieconsent.min.js' ) }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.2/js/plugins/piexif.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.2/js/plugins/sortable.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.2/js/fileinput.min.js"></script>
    <script>
        $(document).ready(function() {
          if($('#hd_current_time_zone').val() ==""){ // Check for hidden field is empty. if is it empty only execute the post function
            var current_date = new Date();
            curent_zone = -current_date.getTimezoneOffset() * 60;
            var token = "{{csrf_token()}}";
            $.ajax({
              method: "POST",
              url: "{{URL::to('ajax/set_current_time_zone/')}}",
              data: {  '_token':token, curent_zone: curent_zone } 
            }).done(function( data ){
            });   
          }
          /* $("#creatEditablePost").emojioneArea({
            hideSource: true,
            autocomplete: true,
            autocorrect       : true,
            pickerPosition: "bottom"
          }); */
        });


      $.fn.fileinputBsVersion = "3.3.7";
      $("#idUpload,#profilePic,#coverPic").fileinput({
        'showUpload':true,
        'previewFileType':'any',
        'browseClass': "btn btn-success btn-block",
        'showCaption': false,
        'showRemove': true,
        'maxFileCount': 1,
        'allowedFileTypes': ["image"],
        //'elErrorContainer': "#errorBlock"
        //allowedFileExtensions: ["jpg", "gif", "png", "txt"]
      });
    </script>
    {{-- attention, this is required inline because users can translate it --}}
    <script>
        window.cookieconsent.initialise({
          "palette": {
            "popup": {
              "background": "#edeff5",
              "text": "#838391"
            },
            "button": {
              "background": "#4b81e8"
            }
          },
          "content": {
            "message": "@lang('general.cookieMessage')",
            "dismiss": "@lang('general.cookieDismiss')",
            "link": "@lang('general.privacyPolicyText')",
            "href": "@lang('v14.privacyPolicyLink')",
          }
        });

        $(document).on('contextmenu', 'img', function() {
            return false;
        });

        $( function() {
          $("video, audio, a[data-toggle=lightbox]").bind("contextmenu",function(){
            return false;
          });
        });
    </script>

    @include('sweet::alert')

    @if ($errors->any())
    <script type="text/javascript">
        var errorList = '';
        @foreach ($errors->all() as $error)
            errorList += '{{ $error }}. ';
        @endforeach

        swal({ title   : '', icon    : 'error', text : errorList });
        
    </script>
    @endif

    <!-- Entry Popup -->
    @if(opt('site_entry_popup', 'No') == 'Yes' AND !request()->cookie('entryConfirmed'))
    <script>
    swal({
      title: '{{ opt('entry_popup_title', 'Entry popup title') }}',
      text: '{{ opt('entry_popup_message', 'Entry popup message') }}',
      icon: "info",
      buttons: true,
      dangerMode: true,
      buttons: ['{{ opt('entry_popup_cancel_text', 'Cancel') }}', '{{ opt('entry_popup_confirm_text', 'Continue') }}'],
    })
    .then((isConfirmed) => {
        if (isConfirmed) {
          $.get('{{ route('entryPopupCookie') }}', function(resp) {
            document.location.href = document.location.href;
          });
        } else {
          return window.location.href= "{{ opt('entry_popup_awayurl', 'https://google.com') }}";
        }
    });
    </script>
    @endif

    <!-- Extra JS -->
    @stack( 'extraJS' )

    <!-- Extra JS FROM Admin Panel -->
    @if($extraJS = opt('admin_extra_JS'))
    <script>
    {!! $extraJS !!}
    </script>
    @endif
  </body>
</html>