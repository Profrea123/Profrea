<?php
namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;


class Medical_history extends Model
{
	protected $table = "medical_history";
	protected $primaryKey = 'm_id';
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
        'medical',
        'medication',
        'surgical',
        'drug',
        'restrictions',
        'habits',
        'occupation',
        'family_history',
		'status',
		'created_at',
		'updated_at'
	];
}



