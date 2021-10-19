@extends('welcome')

@section('seo_title') @lang('navigation.messages') - @endsection

@section('content')

<div class="white-smoke-bg pt-4 pb-3">
<div class="container no-padding">

    @livewire('message')
    {{-- @include('livewire.message-in') --}}

</div>
</div>

@endsection

@push('extraCSS')
<style>
    #messages-container, #people-container {
        height: 500px;
        overflow: scroll;
    }
    .ekko-lightbox-nav-overlay a {
        opacity:1;
        color:black;
    }
</style>
@endpush

{{-- attention, this is dynamically appended using stack() and push() functions of BLADE --}}
@push('extraJS')
<script src="{{ asset('js/jquery.MultiFile.min.js') }}"></script>
<script>
    // listen to livewire growl messages
    window.livewire.on('scroll-to-last', function () {
        var elem = document.getElementById('messages-container');
        elem.scrollTop = elem.scrollHeight;
    });

    // listen to image upload click
    window.livewire.on('imageUploadClicked', function() {
        $(".multipleImgUpload").trigger('click');
    });

    // listen to video upload click
    window.livewire.on('videoUploadClicked', function() {
        $("input[name=videoUpload]").trigger('click');
    });
    
    // listen to audio upload click
    window.livewire.on('audioUploadClicked', function() {
        $("input[name=audioUpload]").trigger('click');
    });

    // listen to zip upload click
    window.livewire.on('zipUploadClicked', function() {
        $("input[name=zipUpload]").trigger('click');
    });

    // reset message field
    window.livewire.on('reset-message', function () {
        var elem = document.getElementById('message-inp').value = "";
    });

    // scroll to last on switching users
    function hasClass(elem, className) {
        return elem.className.split(' ').indexOf(className) > -1;
    }

    function scrollToLast() {
        window.livewire.emit('scroll-to-last');
        window.livewire.emit('scrollToLast');
    }

    $(function() {

        $('.multipleImgUpload').MultiFile({
            accept:'gif|jpg|png|jpeg', 
            max:10, 
            STRING: { 
                remove:'X', 
                selected:'$file', 
                denied:'Not allowed $ext!', 
                duplicate:'Already selected:\n$file!'
            }
        });

    });
</script>
@endpush