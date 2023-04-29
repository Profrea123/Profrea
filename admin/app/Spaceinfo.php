<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;


class Spaceinfo extends Model
{
    protected $table = "space_info";
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'space_type',
        'city',
        'locality',
        'landmark',
    ];
    
}
