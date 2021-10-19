<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportUser extends Model
{

    // set table name
    public $table = 'report_users';

    // relationship to profile
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function reported_user()
    {
        return $this->hasOne('App\User', 'id', 'reported_by');
    }
}
