<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class Spaceplan extends Model
{
	protected $table = "p2_space_plan";
	public $timestamps = false;
	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = [
		'space_id',
		'plan_id',
		'status'
	];
}
