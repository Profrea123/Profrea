<?php
use App\Classes\Profrea\CountryStateCity;
if (! empty($_POST["search"])) {    
    $name = $_POST["search"];
    $space_type = $_POST["space_type"];
    

    require_once __DIR__ . './../src/Classes/Profrea/CountryState.php';
    
    $countryStateCity = new CountryStateCity();
    $result = $countryStateCity->get_utility_by_space_type($name, $space_type);
    
    ?>
<!-- <option  >Select Locality</option> -->
<?php
if(!empty($result)){
foreach ($result as $it) { ?>
        <option value="<?php echo $it["name"].",".$it["id"]; ?>"><?php echo $it["name"]; ?></option>
<?php } 
} else{ ?>
    <option value="<?php echo $it["name"].",".$it["id"]; ?>"><?php echo $name; ?></option>
<?php }
}
?>