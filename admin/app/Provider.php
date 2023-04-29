<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class Provider extends Model
{
	protected $table = "space_provider";
	public $timestamps = true;
	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = [
		'name',
		'email',
        'mobileNo',
		'landmark',
        'city',
		'locality'
	];
}
