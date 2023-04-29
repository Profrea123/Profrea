<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorDayTimeSlot extends Model
{
    use HasFactory;
    
    protected $fillable = ['id','doctor_time_slot_id','slot_time'];
}
