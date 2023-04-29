<?php
use App\Classes\Profrea\CountryStateCity;

if (! empty($_POST["search"])) {  
    $name = $_POST["search"];
    $locality = $_POST["locality"];
    $city_id = $_POST["city_id"];
    require_once __DIR__ . './../src/Classes/Profrea/CountryState.php';
    $countryStateCity = new CountryStateCity();
    $result = $countryStateCity->getLandmarkByName($name,$locality,$city_id);
    ?>
<!-- <option  >Select Landmark</option> -->
<?php
if(!empty($result)){
foreach ($result as $it) { ?>
        <option value="<?php echo $it["name"].",".$it["id"]; ?>"><?php echo $it["name"]; ?></option>
<?php } 
} else{ ?>
    <option value=""><?php echo $name; ?></option>
<?php }
}
?>