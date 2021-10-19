<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    // fillable
    protected $fillable = ['id','name', 'emailSubject', 'senderName', 'sentFrom','emailBody'];
}
