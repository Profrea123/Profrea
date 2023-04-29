<?php
use App\Classes\Profrea\CountryStateCity;
if (! empty($_REQUEST["search"])) {    
    $name = $_REQUEST["search"];
    $city_id = $_REQUEST["city"];

    if(!$city_id)
    return false;

    require_once __DIR__ . './../src/Classes/Profrea/CountryState.php';
    
    $countryStateCity = new CountryStateCity();
    $result = $countryStateCity->getLocalityByName($name,$city_id);

    $rest = array();
if(!empty($result)){

foreach ($result as $it) { 
    $obj = array();
    $obj['id'] = $it["name"]; //.",".$it["id"];
    $obj['text'] = $it["name"];
    array_push($rest,$obj);
   } 
} else{
    $obj = array();
    $obj['id'] =  's52';
    $obj['text'] = $name;
    array_push($rest,$obj);
     }

}
$output = array();
$output["results"] = $rest;

echo json_encode($rest);

?>