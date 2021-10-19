<?php

namespace App\Http\Livewire;

use App\ReportUser;
use Livewire\Component;
use Livewire\WithPagination;


class UserBlockList extends Component
{
    use WithPagination;

    public $tab;

    protected $listeners = ['unBlock'];

    public function mount()
    {
        $this->tab = 'Free';
    }

    public function tab($tab)
    {
        $this->resetPage();
        $this->tab = $tab;
    }

    public function confirmCancellation($blockId)
    {
        $this->emit('swal-confirm', [
            'title' => __('general.areYouSureToUnBlock'),
            'message' => '',
            'emitEvent' => 'unBlock',
            'parameter' => $blockId,
        ]);
    }

    public function unBlock($blockId)
    {

        try {
            // find blocked user
            $block = ReportUser::find($blockId);
            $block->delete();
            $this->emit('swal', [
                'title' => __('general.unBlockMessage'),
                'message' => '',
                'type' => 'info',
            ]);
        } catch (\Exception $e) {
            $this->emit('swal', [
                'title' => __('general.error'),
                'message' => $e->getMessage(),
                'type' => 'error',
            ]);
        }
    }

    public function render()
    {
        $blockedUsers = ReportUser::with('user')->where('reported_by', auth()->user()->id)
                ->simplePaginate(opt('blockListPerPage', 60));

        return view('livewire.user-blocked-users-list')
            ->with('blockedUsers', $blockedUsers);
    }
}
