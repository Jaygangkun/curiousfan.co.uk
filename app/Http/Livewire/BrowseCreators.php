<?php

namespace App\Http\Livewire;

use App\Profile;
use Livewire\Component;
use Livewire\WithPagination;

class BrowseCreators extends Component
{

    use WithPagination;


    public $category;
    public $sortBy;

    public function mount($category)
    {
        $this->category = $category;
        $this->sortBy = 'popularity';
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }

    public function render()
    {

        // initial query
        $creators = Profile::where('isVerified', 'Yes')
            ->with('category')
            ->withCount('posts', 'followers');

        // get category
        $category = $this->category;

        // append category in the query
        $creators = $creators->whereHas('category', function ($q) use ($category) {
            if ($category != 'all') {
                $q->where('id', $this->category);
            }
        });
        // sort by
        switch ($this->sortBy) {

            case 'popularity':
                $creators = $creators->orderByDesc('popularity');
                break;

            case 'subscribers':
                $creators = $creators->orderByDesc('followers_count');
                break;

            case 'alphabetically':
                $creators = $creators->orderBy('name');
                break;

            case 'joindate':
                $creators = $creators->orderByDesc('created_at');
                break;

            case 'postscount':
                $creators = $creators->orderByDesc('posts_count');
                break;
        }
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
        // if hide admin from creators

            /*if (opt('hide_admin_creators', 'No') == 'Yes') {
                $creators->join('users', 'creator_profiles.user_id', 'users.id')
                    ->where('users.isAdmin', '!=', 'Yes');
            }*/

        // finally, output all of them
        $creators = $creators->paginate(opt('browse_creators_per_page', 15));

        return view('livewire.browse-creators', compact('creators'));
    }
}
