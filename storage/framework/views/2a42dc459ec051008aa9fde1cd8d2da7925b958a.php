<div>
    <a href="javascript:void(0);" class="btn btn-danger btn-sm" style="border-radius:16px; padding:6px 15px;" data-toggle="modal" data-target="#userBlockReport">
	<i class="fas fa-user-slash mr-1"></i> 
    <span class="follow-text">
        <?php echo app('translator')->get( 'profile.blockUser' ); ?>
	</span>
	</a>
	<div wire:loading wire:target="toggleFollow">
        <i class="fas fa-spinner fa-spin"></i> <?php echo app('translator')->get( 'profile.pleaseWait' ); ?>
    </div>
</div>

<div class="modal fade" id="userBlockReport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" wire:click="toggleFollow" >Submit</button>
      </div>
    </div>
  </div>
</div><?php /**PATH /home/ay8h3a64vt1a/public_html/resources/views/livewire/user-block-button.blade.php ENDPATH**/ ?>