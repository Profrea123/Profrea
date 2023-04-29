<?php
namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;


class Patient_medication extends Model
{
	protected $table = "patient_medication";
	protected $primaryKey = 'pm_id';
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
		'medicine_name',
		'how_to',
		'qty',
        'medication',
        'repetition',
        'in_the',
        'when',
        'course_time',
        'course_duration',
		'status',
		'created_at',
		'updated_at'
	];
}



