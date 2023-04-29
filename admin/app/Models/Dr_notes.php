<?php
namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;


class Dr_notes extends Model
{
	protected $table = "dr_notes";
	protected $primaryKey = 'dn_id';
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
        'jr_dr_note',
        'test_result',
        'clinical_note',
        'personal_note',
		'status',
		'created_at',
		'updated_at'
	];
}



