<?php

use App\Classes\Profrea\CountryStateCity;

if (! empty($_POST["locality_id"])) {  
    $id = $_POST["locality_id"];
    require_once __DIR__ . './../src/Classes/Profrea/CountryState.php';
    $countryStateCity = new CountryStateCity();
    $result = $countryStateCity->getPinCodeByLocalityId($id);
    ?>
<option  >Select Landmark</option>
<?php
foreach ($result as $it) {
        ?>
<option value="<?php echo $it["id"]; ?>"><?php echo $it["name"]; ?></option>
<?php
}
}
?>