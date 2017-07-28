<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appids extends Model
{
    //
    protected $fillable = [
        'appid',  'cpname', 'notify_url', 'notify_rate', 'notify_rate_m2',
    ];

}




