<div class="top-navbar-search">
    <div class="p-relative top-navar-search-wrap">
<!--  <a style="margin-right:10px" href="{{ route('notifications.index') }}" data-count="{{auth()->user()->unreadNotifications()->count()}}" class="text-dark m_n_c">
      <i class="fas fa-bell mr-1"></i>
      <small class="text-danger text-bold mob_notification" data-count="{{auth()->user()->unreadNotifications()->count()}}">{{auth()->user()->unreadNotifications()->count()}}</small>
    </a>

      <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
      <a style="margin-right:10px" onclick="myFunction()"><i class="fas fa-bell mr-1"></i></a>
      <div id="Demo" style="top:35px;margin-right:216px;min-width:120px;" class="w3-dropdown-content w3-bar-block w3-border" >
          
        <a href="#" class="w3-bar-item w3-button">Notification 1</a>
        <a href="#" class="w3-bar-item w3-button">Notification 2</a>
        <a href="#" class="w3-bar-item w3-button">Notification 3</a>
        <a href="#" class="w3-bar-item w3-button">Notification 4</a>
        <a href="#" class="w3-bar-item w3-button">Notification 5</a>
       
      </div>

      <script>
        function myFunction() {
          var x = document.getElementById("Demo");
          if (x.className.indexOf("w3-show") == -1) {
            x.className += " w3-show";
          } else { 
            x.className = x.className.replace(" w3-show", "");
          }
        }
        </script>

-->
        <span class="search-icon-wrap"><i class="fas fa-search"></i></span>
        <input class="form-control1 mr-sm-2 topSearch" type="search" placeholder="@lang('general.searchCreator')" aria-label="Search" wire:model.debounce.200ms="search">
        <div class="search-spinner" wire:loading>
            <i class="fas fa-spinner fa-spin"></i>
        </div>
    </div>

    @if(strlen($search) >= 2)
    <div class="card shadow autocomplete-results">
        @if(is_object($creators) AND $creators->count())
        <div class="row">
            @foreach($creators as $p)
            <div class="col-12 col-sm-12 col-md-4 text-center">
                <a href="{{ $p->url }}">
                    <img src="{{ secure_image($p->profilePic, 150, 150) }}" alt="p pic" class="img-fluid rounded-circle ml-2 mt-1">
                </a>
                <img src="" class="rounded p-1">
            </div>
            <div class="col-12 col-sm-12 col-md-8 text-center text-sm-left">
                <a href="{{ $p->url }}" class="text-dark d-block mt-1">
                    {{ $p->name }}
                </a>
                <a href="{{ $p->url }}">
                    {{ $p->handle }}
                </a>
            </div>
            <hr>
            @endforeach
        </div>
        @endif
    </div>
    @endif
</div>
