<?php $__env->startSection('seo_title'); ?> <?php echo app('translator')->get('navigation.messages'); ?> - <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="white-smoke-bg pt-4 pb-3">
<div class="container no-padding">

    <?php
if (! isset($_instance)) {
    $dom = \Livewire\Livewire::mount('message')->dom;
} elseif ($_instance->childHasBeenRendered('tEPA2pP')) {
    $componentId = $_instance->getRenderedChildComponentId('tEPA2pP');
    $componentTag = $_instance->getRenderedChildComponentTagName('tEPA2pP');
    $dom = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('tEPA2pP');
} else {
    $response = \Livewire\Livewire::mount('message');
    $dom = $response->dom;
    $_instance->logRenderedChild('tEPA2pP', $response->id, \Livewire\Livewire::getRootElementTagName($dom));
}
echo $dom;
?>
    

</div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('extraCSS'); ?>
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
<?php $__env->stopPush(); ?>


<?php $__env->startPush('extraJS'); ?>
<script src="<?php echo e(asset('js/jquery.MultiFile.min.js')); ?>"></script>
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('welcome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/jr5az3t0ng0l/public_html/resources/views/messages/inbox.blade.php ENDPATH**/ ?>