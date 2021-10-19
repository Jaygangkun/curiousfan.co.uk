@extends('welcome')

@push( 'extraJS' )
<script>
// audience size slider
AUDIENCE_MIN = {{ opt('SL_AUDIENCE_MIN', 10) }};
AUDIENCE_MAX = {{ opt('SL_AUDIENCE_MAX', 9000) }};
AUDIENCE_PREDEFINED_NO = {{ opt('SL_AUDIENCE_PRE_NUM', 100) }};
AUDIENCE_SL_STEP = {{ opt('SL_AUDIENCE_STEP', 100) }};

// membership fee slider
MEMBERSHIP_FEE_MIN = {{ opt('MSL_MEMBERSHIP_FEE_MIN', 9) }};
MEMBERSHIP_FEE_MAX = {{ opt('MSL_MEMBERSHIP_FEE_MAX', 999) }};
MEMBERSHIP_FEE_PRESET = {{ opt('MSL_MEMBERSHIP_FEE_PRESET', 9) }};
MEMBERSHIP_FEE_STEP = {{ opt('MSL_MEMBERSHIP_FEE_STEP', 1) }};
</script>

<script src="{{ asset('js/homepage-sliders.js') }}?v={{ microtime() }}"></script>
@endpush

@section('seo_title') @lang('navigation.login') - @endsection

@section('content')
<div class="guest_forms">
    <div class="form_content">
        <div class="guest_row">
            <div class="phones-col">
                <div class="guest_swiper_wrapper">
                    <div style="padding: 80px 19px 100px 112px;">
                        <div class="owl-carousel owl-theme" id="carousel3">
                            <div class="item">
                                <img src="/images/slide-2.jpg" alt="image1"> </div>
                            <div class="item">
                                <img src="/images/slide-3.jpg" alt="image2"> </div>
                            <div class="item">
                                <img src="/images/slide-4.jpg" alt="image3"> </div>
                            <div class="item">
                                <img src="/images/slide-5.jpg" alt="image4"> </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-col">
                <div class="login-form">
                    <div class="form-logo">
                        @if($logo = opt('form_logo'))
                            <img src="{{ asset($logo) }}" alt="logo" width="100%" height="100%"/>
                        @else
                            {{ opt( 'site_title' ) }}
                        @endif
                        {{--<img src="{{ config('app.url') }}/images/curiousfan-logo.svg" alt="logo" width="100%" height="100%"/>--}}
                    </div>
                    
                    <div class="text-center mb-3"><strong>@lang('auth.signInText')</strong></div><!-- /.text-center -->

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group row">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="@lang('auth.email')" name="email" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="form-group row">
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="@lang('auth.password')" name="password" required>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group row">
                            
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    @lang( 'auth.rememberMe' )
                                </label>
                            </div>
                            
                        </div>

                        <div class="form-group row">
                            <button type="submit" class="btn btn-primary form-control">
                                @lang( 'auth.login' )
                            </button>
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    @lang( 'auth.forgotPassword' )
                                </a>
                            @endif
                        </div>
                    </form>
                    @if (session('b_msg'))
                    <div class="alert alert-danger text-center mt-2">
                        {{ session('b_msg') }}
                    </div>
                    @endif
                    <div class="bottomer-border"></div>

                    <label class="form-check-label" style="margin-top: 20px;">
                        @lang( 'auth.donotHaveAccount' )
                    </label>
                    <br/>
                    <a class="btn btn-link" href="{{ route('register') }}">
                        @lang( 'auth.signUpText' )
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(opt('hideEarningsSimulator', 'Show') == 'Show') 
      <div class="container" style="margin-top: 150px;">
        <h2 class="bold text-center">@lang( 'homepage.earningsSimulator' )</h2>
        <br/>

        <div class="row">
        <div class="col-md-4 offset-md-2">
            <h5>@lang( 'homepage.audienceSize' ) <span class="text-muted audience-size">1000</span></h5>
            <div id="slider-audience"></div>
        </div><!-- /.col-md-3 ( audience size ) -->

        <div class="col-md-1">&nbsp;</div><!-- /.col-md-1 -->

        <div class="col-md-4">
            <h5>@lang( 'homepage.membershipFee' ) <span class="text-muted package-price">{{ opt( 'payment-settings.currency_symbol' )}}9</span></h5>
            <div id="slider-package"></div>
        </div><!-- /.col-md-3 ( audience size ) -->

        <div class="col-md-1">&nbsp;</div><!-- /.col-md-1 -->

        <div class="col-md-1">&nbsp;</div><!-- /.col-md-1 -->
            
        </div><!-- /.row -->
        
        <br/>
        <hr/>
        <div class="text-center">
        <h3 class="bold">
        <span class="per-month">{{ opt( 'payment-settings.currency_symbol' )}}85.5</span> @lang( 'homepage.perMonth' )
        </h3><!-- /.bold -->    

        {{ __('homepage.calcNote', [ 'site_fee' => opt('payment-settings.site_fee').'%']) }}
        
        <br/><br/>
        <a href="{{ route('startMyPage') }}" class="btn btn-danger">@lang('homepage.startCreatorProfile')</a>
        </div><!-- /.text-center -->

        <br/><br/>

      </div><!-- /.container -->
    @endif

</div>

@endsection
