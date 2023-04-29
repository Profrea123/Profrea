<?php


namespace App\Classes\RealEstate;

use App\Classes\Model\Database;
use PDO,PDOException;

 
class Spaces extends Database
{
    private $id;
    private $owner_id;
    private $phone;
    private $hourly_charges;
    private $space_type;
    private $capacity;
    private $images;
    private $amenities;
    private $utility;
    private $paid_utilities;
    private $speciality_operating;
    private $speciality_exclude;
    private $speciality_exclusively;
    private $description;
    private $available_day_slots;
    private $available_time_slots;
    private $address;
    private $locality;
    private $landmark;
    private $city;
    private $state;
    private $pin_code;
    private $gmap_location;
    private $ws_name;
    private $security_deposit;
    private $ws_desc;
    private $setup_desc;
    private $setup_rules;
  

    //Setting up Data
    public function setData($arrData){
        if(array_key_exists('id',$arrData)){
            $this->id = $arrData['id'];
        }
        if(array_key_exists('name',$arrData)){
            $this->name = $arrData['name'];
        }
        if(array_key_exists('monthly_charges',$arrData)){
            $this->monthly_charges = $arrData['monthly_charges'];
        }
        if(array_key_exists('images',$arrData)){
            $this->images = $arrData['images'];
        }
        if(array_key_exists('address',$arrData)){
            $this->address = $arrData['address'];
        }
        if(array_key_exists('access',$arrData)){
            $this->access = $arrData['access'];
        }
        if(array_key_exists('floor_space',$arrData)){
            $this->floor_space = $arrData['floor_space'];
        }
        if(array_key_exists('utility',$arrData)){
            $this->utility = $arrData['utility'];
        }
        if(array_key_exists('description',$arrData)){
            $this->description = $arrData['description'];
        }

    }
    //Setting up data ends
    
        //
    function get_unique_value($array,$key)
    {
       $temp_array = [];
       foreach ($array as &$v) {
           if (!isset($temp_array[$v->$key]) && !in_array($v->$key, $temp_array))
           array_push($temp_array, $v->$key);
       }
       sort($temp_array);
       return $temp_array;
    }

    function get_unique_result($array,$key)
    {
       $temp_array = [];
       foreach ($array as &$v) {
        if (!isset($temp_array[$v->$key]))
        $temp_array[$v->$key] =& $v;
       }
       return $temp_array;
    }

    //

    //Get All Data
    public function index(){
        $sql = "SELECT * FROM spaces where is_deleted = '0'";
        $statementHandler = $this->getDbHandler()->query($sql);
        $statementHandler->setFetchMode(PDO::FETCH_OBJ);
        return $statementHandler->fetchAll();
    }
    //Get All Data Ends

    //Get Single Data
    public function viewSingleData($id){
        $sql = "SELECT * FROM spaces WHERE is_deleted = '0' AND id = ".$id;
        $statementHandler = $this->getDbHandler()->query($sql);
        $statementHandler->setFetchMode(PDO::FETCH_OBJ);
        return $statementHandler->fetch();
    }
    //Get Single Data Ends


    //Get Filter Data 
    public function viewFilterData($city='',$locality='', $spaceType='', $selectedTime = '',$offset = 0,$count = "false",$exclude = array()){
        if($count === "false"){
            $sql = "SELECT * FROM spaces where is_deleted = '0' ";
        }
        else{
            $sql = "SELECT count(*) as count FROM spaces where is_deleted = '0' ";
        }
        
        if($city != '' && $city != 'All')
        {
            $sql = $sql." and city = '".$city."'";
        }
        if($locality != '' && $locality != 'All')
        {
            $sql = $sql." and locality = '".$locality."'";
        }
        if(sizeof($exclude) > 0){
            $sql = $sql." and id not in (".implode(",",$exclude).")";
        }

        if($spaceType != '' && $spaceType != 'All')
        {
            $sql = $sql." and space_type = '".$spaceType."'";
        }

        if($selectedTime != '' && $selectedTime != 'All')
        {
            $sql = $sql." and available_day_slots LIKE '%".$selectedTime."%'";
        }
        if($count === "false"){
            $sql = $sql." Limit $offset,9";
        }
        // echo $sql;
        $statementHandler = $this->getDbHandler()->query($sql);
        $statementHandler->setFetchMode(PDO::FETCH_OBJ);
        return $statementHandler->fetchAll();
    }
    //Get Filter Data 


      //Get Filter Data 
      public function viewFilterDataNew($city='',$speciality='', $selectedTime = '',$offset = 0,$count = "false",$exclude = array()){
        if($count === "false"){
            $sql = "SELECT * FROM spaces where is_deleted = '0' ";
        }
        else{
            $sql = "SELECT count(*) as count FROM spaces where is_deleted = '0' ";
        }
        
        if($city != '' && $city != 'All')
        {
            $sql = $sql." and city = '".$city."'";
        }
    /*    if($locality != '' && $locality != 'All')
        {
            $sql = $sql." and locality = '".$locality."'";
        }
        if(sizeof($exclude) > 0){
            $sql = $sql." and id not in (".implode(",",$exclude).")";
        }

        if($spaceType != '' && $spaceType != 'All')
        {
            $sql = $sql." and space_type = '".$spaceType."'";
        }
*/
        if($speciality != '' && $speciality != 'All')
        {
            $sql = $sql." and speciality_operating LIKE '%".$speciality."%'";
        }

        if($selectedTime != '' && $selectedTime != 'All')
        {
            $sql = $sql." and available_day_slots LIKE '%".$selectedTime."%'";
        }
        if($count === "false"){
            $sql = $sql." Limit $offset,9";
        }
        // echo $sql;
        $statementHandler = $this->getDbHandler()->query($sql);
        $statementHandler->setFetchMode(PDO::FETCH_OBJ);
        return $statementHandler->fetchAll();
    }
   
    

    //Get Data With SpaceType Filter
     public function viewDataWithSpaceFilter($spaceType){
         $sql = "SELECT * FROM spaces WHERE is_deleted = '0' AND space_type = '".$spaceType."'";
         $statementHandler = $this->getDbHandler()->query($sql);
         $statementHandler->setFetchMode(PDO::FETCH_OBJ);
         return $statementHandler->fetchAll();
     }
    //Get Data With SpaceType Filter


    // Start of search()
    public function search($requestArray){

        $sql = "SELECT * FROM `spaces` WHERE is_deleted = '0' AND `name` LIKE '%".$requestArray['search']."%' OR `address` LIKE '%".$requestArray['search']."%'";
        $STH = $this->getDbHandler()->query($sql);
        $STH->setFetchMode(PDO::FETCH_OBJ);
        $allData = $STH->fetchAll();

        return $allData;
    }
    // End of search()



    //get All Keywords For Search
    public function getAllKeywords(){
        $_allKeywords = array();
        $WordsArr = array();

        $allData = $this->index();

        foreach ($allData as $oneData) {
            $_allKeywords[] = trim($oneData->name);
        }

        $allData = $this->index();

        foreach ($allData as $oneData) {

            $eachString= strip_tags($oneData->name);
            $eachString=trim( $eachString);
            $eachString= preg_replace( "/\r|\n/", " ", $eachString);
            $eachString= str_replace("&nbsp;","",  $eachString);

            $WordsArr = explode(" ", $eachString);

            foreach ($WordsArr as $eachWord){
                $_allKeywords[] = trim($eachWord);
            }
        }
        // for each search field block end

        return array_unique($_allKeywords);
    }
    // get all keywords Ends

}