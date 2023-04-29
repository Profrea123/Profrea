<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class Plan extends Model
{
	protected $table = "p2_plans";
	public $timestamps = false;
	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = [
		'title',
		'plan_days',
		'hours_per_day',
		'hours_per_week',
		'hours_per_month',
		'plan_amount',
		'cost_per_hour',
		'initial_payment',
		'branding',
		'profrea_doctor_kit',
		 'receptionist_cum_helper',
		  'live_receptionist', 
		  'practo_prime',
		   'on_call_feature',
		    'gmb', 
			'social_media_management',
			 'opd_percent', 
			 'feature15',
			  'lab_referrals', 
			  'radiological_referrals',
			   'medicine_referrals',
			    'personalised_website', 
				'opd_management_software',
				'mon_slots',
'tue_slots',
'wed_slots',
'thu_slots',
'fri_slots',
'sat_slots',
'sun_slots',
		'status'
	];
}



