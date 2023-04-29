<?php
namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;


class Patient_condition extends Model
{
	protected $table = "patient_condition";
	protected $primaryKey = 'pc_id';
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
        'condition',
		'status',
		'created_at',
		'updated_at'
	];
}



