<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class Booking extends Model
{
	protected $table = "space_bookings";
	public $timestamps = false;
	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = [
		'booking_code',
		'user_id',
		'space_id',
		'plan_id'
	];
}
