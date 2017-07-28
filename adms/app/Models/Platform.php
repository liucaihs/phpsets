<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    protected $table = "tb_platform";

    public $timestamps = false;

    protected $fillable = [ 'name' ];
}
