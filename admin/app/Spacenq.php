<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class Spacenq extends Model
{
	protected $table = "space_enquiry";
	public $timestamps = true;
	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = [
		'status',
		'comment'
	];
}
