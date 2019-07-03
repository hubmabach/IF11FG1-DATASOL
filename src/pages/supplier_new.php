<?php

/**
 * Auf dieser Seite kann der Nutzer ein neuen Lieferanten anlegen. Bei der Eingabe der Adresse wird geprüft, 
 * ob die Addresse bereits vorhanden ist und falls ja wird keine neue Adresse angelegt, sondern die bereits vorhandene
 * Addresse verwendet. Falls keine Adresse vorhanden ist, wird eine angelegt und im Lieferanten gespeichert.
 * @author Benedikt/Matthias
 * 
 * Benedikt 13:00-15:00
 * Matthias 13:00-15:00
 */

$supplierData = array(
    'SupplierName' => "",
    'Street' => "",
    'Postcode' => "",
    'City' => "",
    'Country' => "",
    "Email" => "",
    "Telephone" => "",
    "Mobile" => "",
    "Fax" => ""
);

if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit-new-supplier'])) {
    $supplierData = array(
        'SupplierName' => $_POST["input-supplier-name"],
        'Street' => $_POST["input-street"],
        'Postcode' => $_POST["input-postcode"],
        'City' => $_POST["input-city"],
        'Country' => $_POST["input-country"],
        "Email" => $_POST["input-email"],
        "Telephone" => $_POST["input-telephone"],
        "Mobile" => $_POST["input-mobile"],
        "Fax" => $_POST["input-fax"]
    );

    $queryAddressID = "SELECT AddressID FROM address WHERE ".
                         "Street LIKE '".$supplierData["Street"]."' AND ".
                         "PostalCode LIKE '".$supplierData["Postcode"]."' AND ".
                         "City LIKE '".$supplierData["City"]."' AND ".
                         "MailAddress LIKE '".$supplierData["Email"]."'";
                         
    $resultAddressID = mysqli_query($dbLink, $queryAddressID);

    if (mysqli_num_rows($resultAddressID) === 0) {

        $queryInsertAddress = "INSERT INTO address (Street, PostalCode, City, Country, TelNo, MobilNo, FaxNo, MailAddress) " .
            "VALUES ( ".
            "'".$supplierData["Street"]."', ".
            "'".$supplierData["Postcode"]."', ".
            "'".$supplierData["City"]."', ".
            "'".$supplierData["Country"]."', ".
            "'".$supplierData["Telephone"]."', ".
            "'".$supplierData["Mobile"]."', ".
            "'".$supplierData["Fax"]."', ".
            "'".$supplierData["Email"]."');";
        $resultInsertAddress = mysqli_query($dbLink, $queryInsertAddress);

        if ($resultInsertAddress === false) {
            echo '<div class="alert alert-danger">Upps, da ist was schief gelaufen, versuchen Sie es bitte erneut.</div>';
        } else {
            $resultAddressID = mysqli_query($dbLink, $queryAddressID);
        }
    }

    if ($resultAddressID) {
        $addressId = mysqli_fetch_assoc($resultAddressID)["AddressID"];

        $queryInsertSupplier = "INSERT INTO supplier (SupplierCompanyName, AddressID) VALUES ('".
                                $supplierData["SupplierName"]."', ".
                                $addressId.
                                ");";
        $result = mysqli_query($dbLink, $queryInsertSupplier);

        if (!$result) {
            echo '<div class="alert alert-danger">Leider tratt bei der Verarbeitung ein Fehler auf, bitte versuchen Sie es später erneut.</div>';
        } else {
            $id = mysqli_insert_id($dbLink);
            echo "<div class='alert alert-success'>Lieferant erfolgreich angelegt. <a href='index.php?page=supplier&detail=edit&id=$id'>Zur Detailansicht</a></div>";
        }
    }
}
?>


<h1>Stammdaten - Lieferanten - Neuen Lieferanten anlegen</h1>

<div class="card">
    <div class="card-body" style="background-color:#f8f9fa;">
        <form method="POST">
            <div class="form-group row">
                <label for="input-supplier-name" class="col-sm-2 col-form-label">Lieferantennamen</label>
                <div class="col-sm-7">
                    <input  type="text" class="form-control" id="input-supplier-name" 
                            placeholder="Datasol GmbH" name="input-supplier-name" maxlength="45" 
                            required value="<?php $supplierData["SupplierName"] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="input-street" class="col-sm-2 col-form-label">Straße</label>
                <div class="col-sm-7">
                    <input  type="text" class="form-control" id="input-street" 
                            placeholder="Häußsterweg 4" name="input-street" maxlength="255" 
                            required value="<?php $supplierData["Street"] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="input-postcode" class="col-sm-2 col-form-label">Postleitzahl</label>
                <div class="col-sm-2">
                    <input  type="text" class="form-control" id="input-postcode" 
                            rows="3" placeholder="12345" name="input-postcode" maxlength="5" 
                            required value="<?php $supplierData["Postcode"] ?>"/>
                </div>
                <label for="input-city" class="col-sm-1 col-form-label">Stadt</label>
                <div class="col-sm-4">
                    <input  type="text" class="form-control" id="input-city" 
                            rows="3" placeholder="Berlin" name="input-city" maxlength="45" 
                            required value="<?php $supplierData["City"] ?>"/>
                </div>
            </div>
            <div class="form-group row">
                <label for="input-country" class="col-sm-2 col-form-label">Land</label>
                <div class="col-sm-7">
                    <input  type="text" class="form-control" id="input-country" 
                            rows="3" placeholder="Deutschland" name="input-country" maxlength="45" 
                            required value="<?php $supplierData["Country"] ?>"/>
                </div>
            </div>
            <hr />
            <div class="form-group row">
                <label for="input-email" class="col-sm-2 col-form-label">E-Mail</label>
                <div class="col-sm-7">
                    <input  type="email" class="form-control" id="input-email" 
                            rows="3" placeholder="test@lieferant.de" name="input-email" maxlength="45" 
                            required value="<?php $supplierData["Email"] ?>"/>
                </div>
            </div>
            <div class="form-group row">
                <label for="input-telephone" class="col-sm-2 col-form-label">Telefonnummer</label>
                <div class="col-sm-7">
                    <input  type="text" class="form-control" id="input-telephone" 
                            rows="3" placeholder="0123/456789" name="input-telephone" maxlength="20" 
                            value="<?php $supplierData["Telephone"] ?>"/>
                </div>
            </div>
            <div class="form-group row">
                <label for="input-mobile" class="col-sm-2 col-form-label">Handynummer</label>
                <div class="col-sm-7">
                    <input  type="text" class="form-control" id="input-mobile" 
                            rows="3" placeholder="0123/456789" name="input-mobile" maxlength="20" 
                            value="<?php $supplierData["Mobile"] ?>"/>
                </div>
            </div>
            <div class="form-group row">
                <label for="input-fax" class="col-sm-2 col-form-label">Faxnummer</label>
                <div class="col-sm-7">
                    <input  type="text" class="form-control" id="input-fax" 
                            rows="3" placeholder="0123/456789" name="input-fax" maxlength="20" 
                            value="<?php $supplierData["Fax"] ?>"/>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-1">
                    <button type="submit" class="btn btn-success" name="submit-new-supplier">Speichern</button>
                </div>
            </div>
        </form>
    </div>
</div>