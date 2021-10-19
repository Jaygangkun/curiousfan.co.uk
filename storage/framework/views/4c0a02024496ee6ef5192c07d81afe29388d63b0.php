<div class="top-navbar-search">
    <div class="p-relative" style="
    display: flex;
    justify-content: center;
    align-items: center;">
<!--  <a style="margin-right:10px" href="<?php echo e(route('notifications.index')); ?>" data-count="<?php echo e(auth()->user()->unreadNotifications()->count()); ?>" class="text-dark m_n_c">
      <i class="fas fa-bell mr-1"></i>
      <small class="text-danger text-bold mob_notification" data-count="<?php echo e(auth()->user()->unreadNotifications()->count()); ?>"><?php echo e(auth()->user()->unreadNotifications()->count()); ?></small>
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

        <input class="form-control mr-sm-2 topSearch" type="search" placeholder="<?php echo app('translator')->get('general.searchCreator'); ?>" aria-label="Search" wire:model.debounce.200ms="search">
        <div class="search-spinner" wire:loading>
            <i class="fas fa-spinner fa-spin"></i>
        </div>
    </div>

    <?php if(strlen($search) >= 2): ?>
    <div class="card shadow autocomplete-results">
        <?php if(is_object($creators) AND $creators->count()): ?>
        <div class="row">
            <?php $__currentLoopData = $creators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-12 col-sm-12 col-md-4 text-center">
                <a href="<?php echo e($p->url); ?>">
                    <img src="<?php echo e(secure_image($p->profilePic, 150, 150)); ?>" alt="p pic" class="img-fluid rounded-circle ml-2 mt-1">
                </a>
                <img src="" class="rounded p-1">
            </div>
            <div class="col-12 col-sm-12 col-md-8 text-center text-sm-left">
                <a href="<?php echo e($p->url); ?>" class="text-dark d-block mt-1">
                    <?php echo e($p->name); ?>

                </a>
                <a href="<?php echo e($p->url); ?>">
                    <?php echo e($p->handle); ?>

                </a>
            </div>
            <hr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>
<?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/livewire/search-creators.blade.php ENDPATH**/ ?>