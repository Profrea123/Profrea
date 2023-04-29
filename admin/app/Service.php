<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class Service extends Model
{
	protected $table = "doctor_services";
	public $timestamps = false;
	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = [
		'name',
		'description',
		'speciality',
		'coverpic',
		'benefits',
		'updated_on'
	];
}



