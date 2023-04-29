<?php

use App\Classes\Profrea\CountryStateCity;

if (! empty($_POST["country_id"])) {
    $countryId = $_POST["country_id"];
    require_once __DIR__ . './../src/Classes/Profrea/CountryState.php';
    $countryStateCity = new CountryStateCity();
    $stateResult = $countryStateCity->getStateByCountryId($countryId);
    ?>
<option   >Select State</option>
<?php
    foreach ($stateResult as $state) {
        ?>
<option value="<?php echo $state["id"]; ?>"><?php echo $state["name"]; ?></option>
<?php
    }
}
?>