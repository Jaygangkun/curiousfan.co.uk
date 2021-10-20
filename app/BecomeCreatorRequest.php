<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BecomeCreatorRequest extends Model
{

    // set table name
    public $table = 'become_creator_requests';

    protected $fillable = ['approved'];

    // relationship to profile
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
