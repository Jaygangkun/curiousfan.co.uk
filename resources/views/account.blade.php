@extends( 'welcome' )

@section( 'content' )
<div class="white-smoke-bg">
<br/>

<div class="container add-padding">
<div class="row">
    <div class="col-md-12">
        @if( isset( $p ) AND $p->isVerified != 'Yes' )
                @if( $p->isVerified == 'No' )
                <div class="alert alert-danger" role="alert"> @lang( 'dashboard.not-verified' ) <a href="{{ route( 'profile.verifyProfile' ) }}">@lang('dashboard.verify-profile')</a></div>
                @elseif( $p->isVerified = 'Pending' )
                <div class="alert alert-warning" role="alert">@lang( 'dashboard.verification-pending' )</div>
                @endif

        @endif
        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('A new verification link has been sent to your email address.') }}
            </div>
        @endif
        @if(!auth()->user()->hasVerifiedEmail())
            <div class="alert alert-danger" role="alert">
                Please verify your email address, <a href="#" onclick="event.preventDefault(); document.getElementById('email-form').submit();">click here</a> to verify now.
                <form id="email-form" action="{{ route('verification.resend') }}" method="POST" style="display: none;">@csrf</form>
            </div>
        @endif
    </div>
</div>
<div class="row">
<div class="col-md-4 d-block d-sm-none mb-3">
<a class="btn btn-dark" data-toggle="collapse" href="#mobileAccountNavi" role="button" aria-expanded="false" aria-controls="collapseExample">
    <i class="fas fa-list mr-1"></i> @lang('navigation.accountNavigation')
  </a>
<div class="collapse mt-2" id="mobileAccountNavi">
    @include( 'partials/dashboardnavi' )
</div>
</div><!-- /.col-md-3 -->

<div class="col-md-8">
@yield( 'account_section' )
</div><!-- /.col-md-8 -->

<div class="col-md-4 d-none d-sm-block">
@include( 'partials/dashboardnavi' )
</div><!-- /.col-md-3 -->

</div><!-- ./row ( main ) -->
</div><!-- /.container -->
</div>

@endsection