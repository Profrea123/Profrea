<?php
namespace App\Classes\Profrea;
use App\Classes\Model\Database;
class CountryStateCity
{
    private $db;
    
    function __construct()
    {
        require_once __DIR__ . './../Model/Database.php';
        $this->db = new Database();
    }
    
    /**
     * to get the country record set
     */
    public function getAllCountry()
    {
        $query = "SELECT * FROM country";
        return $this->db->select($query);   
    }
    
    /**
     * to get the state record based on the country_id
     */
    public function getStateByCountryId($countryId)
    {
        $query = "SELECT * FROM states WHERE country_id = ".$countryId;
        return $this->db->select($query);
    }
    
    /**
     * to get the city record based on the state_id
     */
    public function getCityByStateId($stateId)
    {
         $query = "SELECT * FROM city WHERE state_id = ".$stateId;
        return $this->db->select($query);
    }

       /**
     * to get the city record based on the state_id
     */
    public function getAllCity()
    {
         $query = "SELECT * FROM city" ;
        return $this->db->select($query);
    }
    
    /**
     * to get the locality record based on the cityId
     */
    public function getLocalityByCityId($cityId)
    {
        $query = "SELECT * FROM locality WHERE city_id = ".$cityId;
        return $this->db->select($query);
    }


     /**
     * to get the locality record based on the cityId
     */
    public function getLocalityByCityName($cityName)
    {
       $query = 'select * from locality  where city_id =  ( select id from city where name = "'.$cityName .'")';
       return $this->db->select($query);
    }

        /**
     * to get the landmark record based on the localityId
     */
    public function getLandmarkByLocalityId($localityId)
    {
        $query = "SELECT * FROM landmark WHERE locality_id = ".$localityId;
        return $this->db->select($query);
    }
    
    /**
     * to get the locality record based on the cityId
     */
    public function getLandmarkByLocalityName($locality)
    {
       $query = 'select * from landmark  where locality_id =  ( select id from locality where name = "'.$locality .'")';
       return $this->db->select($query);
    }

    /**Arpit */
    public function getLocalityByName($name,$city_id)
    {
        $query = "SELECT * FROM locality WHERE name LIKE '%" . $name . "%' AND city_id = ".$city_id;   
        return $this->db->select($query);
    }

    public function getLandmarkByName($name,$locality,$city_id)
    {
        $query1 = "SELECT id FROM locality WHERE name LIKE '%" . $locality . "%' AND city_id = ".$city_id;
        $id = $this->db->select($query1);
        if($id){
            $query = "SELECT * FROM landmark WHERE name LIKE '%" . $name . "%' AND locality_id = ".$id[0]['id'];      
            return $this->db->select($query);
        }
        
    }

    public function get_operating_specialty($name, $space_type)
    {
        $query = "SELECT * FROM operating_specialty WHERE name LIKE '%" . $name . "%' AND space_type LIKE '%" . $space_type . "%'";   
        return $this->db->select($query);
    }

    public function get_utility_by_space_type($name, $space_type)
    {
        $query = "SELECT * FROM utility WHERE name LIKE '%" . $name . "%' AND space_type LIKE '%" . $space_type . "%'";   
        return $this->db->select($query);
    }

    public function get_paid_utilities_by_space_type($name, $space_type)
    {
        $query = "SELECT * FROM paid_utilities WHERE name LIKE '%" . $name . "%' AND space_type LIKE '%" . $space_type . "%'";   
        return $this->db->select($query);
    }

    public function get_amenities_by_space_type($name, $space_type)
    {
        $query = "SELECT * FROM amenities WHERE name LIKE '%" . $name . "%' AND space_type LIKE '%" . $space_type . "%'";   
        return $this->db->select($query);
    }

    /*End*/
}