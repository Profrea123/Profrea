<?php


namespace App\Classes\RealEstate;

use App\Classes\Model\Database;
use PDO,PDOException;


class Users extends Database
{
    private $id;
    private $owner_id;
    private $phone;
    private $images;
    private $amenities;
    private $utility;
    private $hourly_charges;
    private $speciality_current;
    private $speciality_exclude;
    private $speciality_exclusively;
    private $description;
    private $accessabilities;
    private $available_slots;
    private $capacity;
    private $address;
    private $landmark;
    private $city;
    private $state;
    private $pinCode;
    private $rowstate;
    private $insert;
    private $update;
  

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

    //Get All Data
    public function index(){
        $sql = "SELECT * FROM users";
        $statementHandler = $this->getDbHandler()->query($sql);
        $statementHandler->setFetchMode(PDO::FETCH_OBJ);
        return $statementHandler->fetchAll();
    }
    //Get All Data Ends

    //Get Single Data
    public function viewSingleData($id){
        $sql = "SELECT * FROM users WHERE id = ".$id;
        $statementHandler = $this->getDbHandler()->query($sql);
        $statementHandler->setFetchMode(PDO::FETCH_OBJ);
        return $statementHandler->fetch();
    }
    //Get Single Data Ends

    // Start of search()
    public function search($requestArray){

        $sql = "SELECT * FROM `users` WHERE `name` LIKE '%".$requestArray['search']."%' OR `address` LIKE '%".$requestArray['search']."%'";
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