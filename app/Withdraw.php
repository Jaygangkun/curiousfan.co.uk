<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    // set table name
    public $table = 'withdraws';

    public $fillable = ['amount', 'created_at'];

    public function getformattedAmountAttribute()
    {
        return number_format($this->amount, 2);
    }

    // relationship to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
