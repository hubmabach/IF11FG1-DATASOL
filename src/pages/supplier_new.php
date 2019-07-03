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
if (isset($_POST["submit-new-supplier"])) {
    $supplierCompanyName = $_POST["input-supplier-name"];
    $street = $_POST["input-street"];
    $postcode = $_POST["input-postcode"];
    $city = $_POST["input-city"];
    $country = $_POST["input-country"];
    $email = $_POST["input-email"];
    $telephone = $_POST["input-telephone"];
    $mobile = $_POST["input-mobile"];
    $fax = $_POST["input-fax"];
    $valid = true;

    if (ctype_space($supplierCompanyName)) {
        echo "<p>Bitte geben Sie eine Lieferantenname ein!</p>";
        $valid = false;
    }
    if (ctype_space($street)) {
        echo "<p>Bitte geben Sie einen Straße ein!</p>";
        $valid = false;
    }
    if (ctype_space($postcode)) {
        echo "<p>Bitte geben Sie einen Postleitzahl ein!</p>";
        $valid = false;
    }
    if (ctype_space($city)) {
        echo "<p>Bitte geben Sie einen Stadt ein!</p>";
        $valid = false;
    }
    if (ctype_space($country)) {
        echo "<p>Bitte geben Sie eine Land ein!</p>";
        $valid = false;
    }
    if (ctype_space($email)) {
        echo "<p>Bitte geben Sie einen E-Mailaddresse ein!</p>";
        $valid = false;
    }


    if ($valid) {
        $queryCheckAddress = "SELECT * FROM address WHERE Street LIKE '$street' AND PostalCode LIKE '$postcode' AND City LIKE '$city' AND MailAddress LIKE '$email'";
        $result = mysqli_query($dbLink, $queryCheckAddress);

        if (mysqli_num_rows($result) === 0) {
            $queryInsertAddress = "INSERT INTO address (Street, PostalCode, City, Country, TelNo, MobilNo, FaxNo, MailAddress) " .
                "VALUES ('$street', '$postcode', '$city', '$country', '$telephone', '$mobile', '$fax', '$email');";
            $result = mysqli_query($dbLink, $queryInsertAddress);

            if ($result === false) {
                echo "<p>Upps, da ist was schief gelaufen, versuchen Sie es bitte erneut.</p>";
            } else {
                $result = mysqli_query($dbLink, $queryCheckAddress);
            }
        }

        if ($result) {
            $addressId = mysqli_fetch_assoc($result)["AddressID"];

            $queryInsertSupplier = "INSERT INTO supplier (SupplierCompanyName, AddressID) VALUES ('$supplierCompanyName', $addressId);";
            $result = mysqli_query($dbLink, $queryInsertSupplier);

            if (!$result) {
                echo "<p>Leider tratt bei der Verarbeitung ein Fehler auf, bitte versuchen Sie es später erneut!</p>";
            } else {
                header("Location: index.php?page=supplier");
                exit;
            }
        }
    }
}
?>


<h1>Stammdaten - Lieferanten - Neuen Lieferanten anlegen</h1>

<div class="container" style="margin-top:30px;">
    <form method="POST">
        <div class="form-group row">
            <label for="input-supplier-name" class="col-sm-2 col-form-label">Lieferantennamen</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="input-supplier-name" placeholder="Datasol GmbH" name="input-supplier-name" maxlength="45" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="input-street" class="col-sm-2 col-form-label">Straße</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="input-street" placeholder="Häußsterweg 4" name="input-street" maxlength="255" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="input-postcode" class="col-sm-2 col-form-label">Postleitzahl</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="input-postcode" rows="3" placeholder="12345" name="input-postcode" maxlength="5" required/>
            </div>
        </div>
        <div class="form-group row">
            <label for="input-city" class="col-sm-2 col-form-label">Stadt</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="input-city" rows="3" placeholder="Berlin" name="input-city" maxlength="45" required/>
            </div>
        </div>
        <div class="form-group row">
            <label for="input-country" class="col-sm-2 col-form-label">Land</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="input-country" rows="3" placeholder="Deutschland" name="input-country" maxlength="45" required/>
            </div>
        </div>
        <div class="form-group row">
            <label for="input-email" class="col-sm-2 col-form-label">E-Mail</label>
            <div class="col-sm-7">
                <input type="email" class="form-control" id="input-email" rows="3" placeholder="test@lieferant.de" name="input-email" maxlength="45" required/>
            </div>
        </div>
        <div class="form-group row">
            <label for="input-telephone" class="col-sm-2 col-form-label">Telefonnummer</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="input-telephone" rows="3" placeholder="0123/456789" name="input-telephone" maxlength="20" />
            </div>
        </div>
        <div class="form-group row">
            <label for="input-mobile" class="col-sm-2 col-form-label">Handynummer</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="input-mobile" rows="3" placeholder="0123/456789" name="input-mobile" maxlength="20" />
            </div>
        </div>
        <div class="form-group row">
            <label for="input-fax" class="col-sm-2 col-form-label">Faxnummer</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="input-fax" rows="3" placeholder="0123/456789" name="input-fax" maxlength="20" />
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-1">
                <button type="submit" class="btn btn-primary" name="submit-new-supplier">Anlegen</button>
            </div>
            <div class="col-sm-6">
                <button type="reset" class="btn btn-secondary">Zurücksetzen</button>
            </div>
        </div>
    </form>
</div>