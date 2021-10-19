<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Message;

class MobUnreadMessagesCount extends Component
{
    public function render()
    {
        $count = Message::where('to_id', auth()->id())->where('is_read', 'No')->count();
        return view('livewire.mob-unread-messages-count', compact('count'));
    }
}
