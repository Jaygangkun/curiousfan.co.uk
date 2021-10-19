@extends('welcome')

@section('seo_title') @lang('navigation.signUp') - @endsection

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
                <div class="register-form">
                    <div class="form-logo">
                        @if($logo = opt('form_logo'))
                            <img src="{{ asset($logo) }}" alt="logo" width="100%" height="100%"/>
                        @else
                            {{ opt( 'site_title' ) }}
                        @endif
                    </div>
                    
                    <div class="text-center mb-3"><strong>@lang('auth.signUpText')</strong></div><!-- /.text-center -->

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <input id="name" type="text" placeholder="@lang('auth.name')" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                            
                        </div>

                        <div class="form-group row">
                            <input id="email" type="email" placeholder="@lang('auth.email')" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group row">
                            <select id="isCreating" name="isCreating" class="form-control">
                                <option value="No">Supporters Account</option>
                                <option value="Yes">Creators Account</option>
                            </select>
                        </div>

                        <div class="form-group row">
                            <input id="password" type="password" placeholder="@lang('auth.password')" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group row">
                            <input id="password-confirm" type="password" class="form-control" placeholder="@lang('auth.confirmPassword')" name="password_confirmation" required>
                        </div>
                        <div class="form-group row" style="margin-bottom: 40px;">
                            
                            <button type="submit" class="btn btn-primary form-control">
                                @lang( 'navigation.signUp' )
                            </button>
                            
                        </div>
                    </form>
                    @if (session('b_msg'))
                    <div class="alert alert-danger text-center mt-2">
                        {{ session('b_msg') }}
                    </div>
                    @endif
                    <div class="bottomer-border"></div>

                    <label class="form-check-label" style="margin-top: 20px;">
                        @lang( 'auth.haveAccount' )
                    </label>
                    <br/>
                    <a class="btn btn-link" href="{{ route('login') }}">
                        @lang( 'auth.signInText' )
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
