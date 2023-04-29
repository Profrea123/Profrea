<?php
namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;


class Prescription extends Model
{
	protected $table = "prescription";
	protected $primaryKey = 'idprescription';
	public $timestamps = false;
	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = [
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



