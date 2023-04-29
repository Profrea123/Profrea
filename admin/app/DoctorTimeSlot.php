<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorTimeSlot extends Model
{
    use HasFactory;

    public function timeslots(){
        return $this->hasMany(DoctorDayTimeSlot::class, 'doctor_time_slot_id', 'id');
    }
}
