<?php
namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;


class Followup extends Model
{
	protected $table = "followup";
	protected $primaryKey = 'fu_id';
	public $timestamps = false;
	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = [
		'user_id',
		'doctor_id',
		'booking_no',
        'days',
        'advice',
		'status',
		'created_at',
		'updated_at',
		'log_count'
	];
}



