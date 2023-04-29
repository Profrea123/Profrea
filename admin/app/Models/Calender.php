<?php
namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;


class Calender extends Model
{
	protected $table = "tbl_calender";
	protected $primaryKey = 'cal_id';
	public $timestamps = false;
	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = [
        'doctor_id',
		'booking_no',
		'title',
		'comment',
		'start',
		'end',
		'status',
		'created_at',
		'updated_at'
	];
}



