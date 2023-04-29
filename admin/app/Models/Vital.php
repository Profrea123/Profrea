<?php
namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;


class Vital extends Model
{
	protected $table = "vital1";
	protected $primaryKey = 'v_id';
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
		'height',
		'weight',
		'blood_pressure',
		'temperature',
		'status',
		'created_at',
		'updated_at'
	];
}



