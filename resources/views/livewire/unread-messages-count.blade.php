<a wire:poll.3000ms class="nav-link waves-effect waves-light" href="{{  route('messages.inbox') }}">
    @if($count != 0)
    <span class="badge badge-danger ml-2">{{$count}}</span>
    @endif
    <i class="fas fa-envelope"></i>
</a>