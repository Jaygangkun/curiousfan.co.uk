@extends('welcome')
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
                        </div>

                        <div class="text-center mb-3"><strong>Verify Your Email Address</strong></div><!-- /.text-center -->

                        <div class="card-body">
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </div>
                            @endif

                            {{ __('Please check your email for a verification link.') }}
                            {{ __('If you did not receive the email') }}, <br> <br> <a href="#" class="btn btn-primary form-control" onclick="event.preventDefault(); document.getElementById('email-form').submit();">{{ __('Click here to request another one') }}</a>
                            <form id="email-form" action="{{ route('verification.resend') }}" method="POST" style="display: none;">@csrf</form>
                        </div>

                        {{--<div class="bottomer-border"></div>

                        <label class="form-check-label" style="margin-top: 20px;">
                            @lang( 'auth.donotHaveAccount' )
                        </label>
                        <br/>
                        <a class="btn btn-link" href="{{ route('register') }}">
                            @lang( 'auth.signUpText' )
                        </a>--}}
                    </div>
                </div>
            </div>
        </div>
{{--
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
        @endif--}}

    </div>
{{--<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}, <a href="#" onclick="event.preventDefault(); document.getElementById('email-form').submit();">{{ __('click here to request another one') }}</a>.
                        <form id="email-form" action="{{ route('verification.resend') }}" method="POST" style="display: none;">@csrf</form>
                </div>
            </div>
        </div>
    </div>
</div>--}}
@endsection
