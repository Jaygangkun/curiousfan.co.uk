@foreach($media->groupBy('message_id') as $msgMedia)

    @if($msgMedia->first()->lock_type == 'Free' || auth()->id() == $msg->from_id ||  App\Unlock::where('message_id', $msg->id)->where('payment_status', 'Paid')->where('tipper_id', auth()->id())->exists())

        <div class="row">
            @foreach($msgMedia as $mm)
                @include('messages.single-media', ['media' => $mm])
            @endforeach
        </div>

    @elseif($msgMedia->first()->lock_type == 'Paid' && $msgMedia->first()->lock_price > 0)

    <div class="dropdown show z-9999">

        <a href="javascript:void(0)" class="btn btn-primary btn-sm mb-2 dropdown-toggle" id="premiumPostsLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @lang('v19.unlockLinkTitle') {{ opt('payment-settings.currency_symbol') . number_format($msgMedia->first()->lock_price,2) }}
        </a>

        <div class="dropdown-menu" aria-labelledBy="premiumPostsLink">

            {{-- Stripe Button --}}
            @if(opt('card_gateway', 'Stripe') == 'Stripe')
                @if(auth()->check() && opt('stripeEnable', 'No') == 'Yes' && auth()->user()->paymentMethods()->count())
                    <a class="dropdown-item" href="{{ route('unlockMessage', [ 'gateway' => 'Card', 'message' => $msg->id ]) }}">
                        @lang('general.creditCard')
                    </a>
                @elseif(auth()->check() && !auth()->user()->paymentMethods()->count() && opt('stripeEnable', 'No') == 'Yes')
                    <a class="dropdown-item" href="{{ route('billing.cards') }}">
                        @lang('general.addNewCard')
                    </a>
                @elseif(opt('stripeEnable', 'No') == 'Yes')
                    <a class="dropdown-item" href="{{ route('login') }}">
                        @lang('general.creditCard')
                    </a>
                @endif
            @endif

            {{-- CCBill Button --}}
            @if(opt('card_gateway', 'Stripe') == 'CCBill')
                <a class="dropdown-item" href="{{ route('unlockMessage', [ 'gateway' => 'Card', 'message' => $msg->id ]) }}">
                    @lang('general.creditCard')
                </a>
            @endif

            {{-- PayStack Button --}}
            @if(opt('card_gateway', 'Stripe') == 'PayStack')
                @if(auth()->check() && auth()->user()->paymentMethods()->count())
                    <a class="dropdown-item" href="{{ route('unlockMessage', [ 'gateway' => 'Card', 'message' => $msg->id ]) }}">
                        @lang('general.creditCard')
                    </a>
                @elseif(auth()->check() && !auth()->user()->paymentMethods()->count())
                    <a class="dropdown-item" href="{{ route('billing.cards') }}">
                        @lang('general.addNewCard')
                    </a>
                @else
                    <a class="dropdown-item" href="{{ route('login') }}">
                        @lang('general.creditCard')
                    </a>
                @endif
            @endif

            {{-- MercadoPago Button --}}
            @if(opt('card_gateway', 'Stripe') == 'MercadoPago')
                <a class="dropdown-item" href="{{ route('unlockMessage', [ 'gateway' => 'Card', 'message' => $msg->id ]) }}">
                    @lang('general.creditCard')
                </a>
            @endif

            {{-- TransBank WebpayPlus Button --}}
            @if(opt('card_gateway', 'Stripe') == 'TransBank')
                <a class="dropdown-item" href="{{ route('unlockMessage', [ 'gateway' => 'Card', 'message' => $msg->id ]) }}">
                    @lang('general.creditCard')
                </a>
            @endif

            {{-- PayPal Button --}}
            @if(opt('paypalEnable', 'No') == 'Yes')
                <a class="dropdown-item" href="{{ route('unlockMessage', [ 'gateway' => 'PayPal', 'message' => $msg->id ]) }}">
                    @lang('general.PayPal')
                </a>
            @endif
        </div>
    </div>

    @endif

@endforeach