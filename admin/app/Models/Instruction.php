<?php
namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;


class Instruction extends Model
{
	protected $table = "frequently_used_instruction";
	protected $primaryKey = 'fui_id';
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



