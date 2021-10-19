<?php

namespace App\Http\Livewire;

use App\Profile;
use App\ReportUser;
use Livewire\Component;
use Livewire\WithPagination;

class CreatorsSidebar extends Component
{
    use WithPagination;

    public function render()
    {
        //get a list id of blocked users
        $blockedUsers = ReportUser::where('reported_by', auth()->user()->id)->get();
        $blockedList = [];
        foreach ($blockedUsers as $b) {
            $blockedList[] = $b->user_id;
        }

        // get a list of all creators, sorted by popularity
        // current user must not already follow
        $followList = [];
        $followList[] = auth()->id();

        if (auth()->check()) {
            $userAlreadyFollowing = auth()->user()->followings;

            foreach ($userAlreadyFollowing as $f) {
                $followList[] = $f->id;
            }
        } else {
            $followList = [];
        }

        $creators = Profile::where('isVerified', 'Yes')
            ->with('category')
            ->whereHas('category')
            // ->orderByDesc('popularity')
            ->inRandomOrder()
            ->whereNotIn('user_id', $followList)
            ->whereNotIn('user_id', $blockedList);

        // if hide admin from creators
        if (opt('hide_admin_creators', 'No') == 'Yes') {
            if (opt('hide_creator_types') == 1) {
                $creators->join('users', 'creator_profiles.user_id', 'users.id')
                    ->where('isCreating', 'Yes')
                    ->where('users.isAdmin', '!=', 'Yes');
            } elseif (opt('hide_creator_types') == 2) {
                $creators->join('users', 'creator_profiles.user_id', 'users.id')
                    ->where('isCreating', 'No')
                    ->where('users.isAdmin', '!=', 'Yes');
            } else {
                $creators->join('users', 'creator_profiles.user_id', 'users.id')
                    ->where('users.isAdmin', '!=', 'Yes');
            }
        }else{
            if (opt('hide_creator_types') == 1) {
                $creators->join('users', 'creator_profiles.user_id', 'users.id')
                    ->where('isCreating', 'Yes');
            } elseif (opt('hide_creator_types') == 2) {
                $creators->join('users', 'creator_profiles.user_id', 'users.id')
                    ->where('isCreating', 'No');
            } else {
                $creators->join('users', 'creator_profiles.user_id', 'users.id');
            }
        }
        
        $creators = $creators->simplePaginate(2);


        $cols = 12;

        return view('livewire.creators-sidebar', compact('creators', 'cols'));
    }
}
