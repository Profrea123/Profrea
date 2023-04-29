<?php
namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;


class Tab_redirection extends Model
{
    public function __construct()
    {
        $this->db = new DB;
        $this->casesheettab = 'case_sheet_tab';
        $this->chiefcomplaints = 'chief_complaints';
        $this->patientchiefcomplaints = 'patient_chief_complaint';
    }
    
    public function insert_tab_redirection($data){
        $value = DB::table($this->casesheettab)
            ->insertOrIgnore($data);
            return $value;
    }

    public function get_one_record($booking_no){
        $value = $this->db::table($this->casesheettab)
        ->where('booking_no', $booking_no)
        //->orderBy('id','asc')
        ->first();
        return $value;
    }

    public function update_tab_redirection($data, $booking_no){
        $getAll = DB::table($this->casesheettab)
            ->where('booking_no', $booking_no)
            ->first();
        //if($getAll->complete_tab != 9):        
        $value = DB::table($this->casesheettab)
            ->where('booking_no', $booking_no)
            ->update($data);
            return $value;
        //else:
            //return 1;
       // endif;
    }

    public function get_all_tab_redirection(){
        $value = DB::table($this->casesheettab)
            ->orderBy('id', 'asc')
            ->get();
            return $value;
    }

    /********************start prescription****************** */
    public function get_chief_complaints(){
        $value = DB::table($this->chiefcomplaints)
            ->orderBy('comp_id', 'desc')
            ->where('status', 1)
            ->get();
            return $value;

    }
    public function insert_chief_complaints($data){
        $value = DB::table($this->chiefcomplaints)
            ->insertOrIgnore($data);
            return $value;
    }
    public function update_chief_complaints($data, $comp_id){
        $value = DB::table($this->chiefcomplaints)
            ->where('comp_id', $comp_id)
            ->update($data);
            return $value;
    }
    public function delete_complaints($comp_id){
        $value = DB::table($this->chiefcomplaints)
            ->where('comp_id', $comp_id)
            ->delete();
            return $value;
    }
    public function insert_patient_chief_complaints($data){
        $value = DB::table($this->patientchiefcomplaints)
            ->insertOrIgnore($data);
            return $value;
    }
    public function get_patient_chief_complaints($booking_no){
        $value = DB::table($this->patientchiefcomplaints)
            ->where('booking_no', $booking_no)
            ->where('status', 1)
            ->orderBy('pcc_id', 'desc')
            ->get();
            return $value;

    }
    public function delete_patient_chief_complaints($pcc_id){
        $value = DB::table($this->patientchiefcomplaints)
            ->where('pcc_id', $pcc_id)
            ->delete();
            return $value;
    }
    /********************end prescription****************** */
}



