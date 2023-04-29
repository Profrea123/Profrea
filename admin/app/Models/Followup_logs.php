<?php
namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;


class Followup_logs extends Model
{
	protected $table = "followup_logs";
	protected $primaryKey = 'ful_id';
	public $timestamps = false;
	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = [
		'fu_id',
		'user_id',
		'doctor_id',
		'booking_no',
        'created_at'
	];
}



