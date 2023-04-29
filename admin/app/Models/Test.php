<?php
namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;


class Test extends Model
{
	protected $table = "blood_tests";
	protected $primaryKey = 'bt_id';
	public $timestamps = false;
	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = [
		'title',
		'desc',
		'doctor_id',
		'status',
		'created_at',
		'updated_at'
	];
}



