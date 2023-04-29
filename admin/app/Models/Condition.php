<?php
namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;


class Condition extends Model
{
	protected $table = "health_condition";
	protected $primaryKey = 'hc_id';
	public $timestamps = false;
	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = [
		'title',
		'desc',
		'status',
		'created_at',
		'updated_at'
	];
}



