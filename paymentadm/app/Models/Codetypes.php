<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Codetypes extends Model
{
    //
    protected $fillable = [
        'codetype', 'spid', 'desc', 'script',
    ];
}