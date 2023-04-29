<?php
namespace App;

use App\Filters\BookingFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Auth\Authenticatable;

class BookingDetail extends Model
{
	protected $table = "booking_details";
	public $timestamps = false;
	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = [
		'payment_id',
		'doctor_id',
		'user_id',
		'booking_no',
		'booking_date',
		'booking_time',
		'transaction_date',
		'amount',
		'transaction_charge',
		'service_charge',
		'sub_total',
		'tax_amount',
		'tax_percentage',
		'discount_amount',
		'payment_mode',
		'booking_type',
		'booking_status',
		'reason',
		'refund_status',
		'refund_date',
		'refund_remarks'
	];

	public function doctor(){
		return $this->belongsTo(User::class, 'doctor_id', 'id');
	}

	public function family_member(){
		return $this->belongsTo(FamilyMember::class, 'family_member_id', 'id');
	}

	public function user(){
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function attachments(){
		return $this->hasMany(Attachment::class, 'booking_no', 'booking_no');
	}

	// public function scopeFilter(Builder $builder, $request)
    // {
    //     return (new BookingFilter($request))->filter($builder);
    // }
	public function scopeFilter($query, $filters)
    {
        return (new BookingFilter($filters))->apply($query);
    }
}
