<?php
/**
 * Auf dieser Seite hat der Nutzer die Möglichkeit, ein Lieferanten zu bearbeiten. Dieser wird über die
 * ID in der URL herausgesucht. Sollte keine ID gesetzt sein, wird er auf die Übersichtsseite zurück verwiesen. 
 * Ansonsten werden die Felder mit den in der Datenbank gespeicherten Werten vorbefüllt. Der Nutzer kann diese anschließend
 * nach belieben bearbeiten und Speichern.
 * @author Benedikt/Matthais
 * Benedikt 13:00-15:00
 * Matthias 13:00-15:00
 */
$currentPage = $_GET["page"];
if (!isset($_GET["id"])) {
    header("Location: index.php?page=$currentPage");
    exit;
}

$id = $_GET["id"];
$query = "SELECT * FROM Supplier INNER JOIN Address ON Supplier.AddressID = Address.AddressID WHERE SupplierID = $id;";
$result = mysqli_query($dbLink, $query);

if (mysqli_num_rows($result) !== 0) {

    if (isset($_POST["submit-edit-supplier"])) {
        
        $supplierId = $id;
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
            $queryAddress = "SELECT * FROM address WHERE Street LIKE '$street' AND PostalCode LIKE '$postcode' AND City LIKE '$city' AND MailAddress LIKE '$email'";
            $resultAddress = mysqli_query($dbLink, $queryAddress);
            $addressId = mysqli_fetch_assoc($resultAddress)["AddressID"];

            $queryUpdateAddress = "UPDATE address SET Street = '$street', PostalCode = '$postcode', City = '$city', " .
                                    "Country = '$country', TelNo = '$telephone', MobilNo = '$mobile', FaxNo = '$fax', " . 
                                    " MailAddress = '$email' WHERE AddressID = $addressId;";
            $queryUpdateCompany = "UPDATE supplier SET SupplierCompanyName = '$supplierCompanyName' WHERE SupplierID = $supplierId";

            mysqli_query($dbLink, "BEGIN");
            $resultAddress = mysqli_query($dbLink, $queryUpdateAddress);
            $resultCompany = mysqli_query($dbLink, $queryUpdateCompany);

            if($resultAddress === false || $resultCompany === false)
            {
                mysqli_query($dbLink, "ROLLBACK");
                // Todo ausgabe einer Fehlermeldung.
            }
            else 
            {
                mysqli_query($dbLink, "COMMIT");
                header("Location: index.php?page=$currentPage");
            }
        }
    }
}

if (mysqli_num_rows($result) === 0) : ?>

    <h3 class="text-danger">Der angeforderte Lieferant wurde leider nicht gefunden.</h3>
    <p>Vielleicht wurde er durch einen anderen Nutzer gelöscht.</p>
    <a class="btn btn-secondary" href="index.php?page=supplier">Zur Übersicht</a>
<?php
endif;

if (mysqli_num_rows($result) !== 0) :

    $supplier = mysqli_fetch_assoc($result);
?>


<h1>Stammdaten - Lieferanten - Neuen Lieferanten anlegen</h1>

<div class="container" style="margin-top:30px;">
    <form method="POST">
        <div class="form-group row">
            <label for="input-supplier-id" class="col-sm-2 col-form-label">Lieferanten-ID</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="input-supplier-id" name="input-supplier-id" disabled value="<?php echo $supplier["SupplierID"] ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="input-supplier-name" class="col-sm-2 col-form-label">Lieferantennamen</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="input-supplier-name" name="input-supplier-name" maxlength="45" value="<?php echo $supplier["SupplierCompanyName"] ?>" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="input-street" class="col-sm-2 col-form-label">Straße</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="input-street" name="input-street" maxlength="255" value="<?php echo $supplier["Street"] ?>" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="input-postcode" class="col-sm-2 col-form-label">Postleitzahl</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" id="input-postcode" rows="3" name="input-postcode" maxlength="5" value="<?php echo $supplier["PostalCode"] ?>" required/>
            </div>
            <label for="input-city" class="col-sm-1 col-form-label">Stadt</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="input-city" rows="3" name="input-city" maxlength="45" value="<?php echo $supplier["City"] ?>" required/>
            </div>
        </div>
        <div class="form-group row">
            <label for="input-country" class="col-sm-2 col-form-label">Land</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="input-country" rows="3" name="input-country" maxlength="45" value="<?php echo $supplier["Country"] ?>" required/>
            </div>
        </div>
        <div class="form-group row">
            <label for="input-email" class="col-sm-2 col-form-label">E-Mail</label>
            <div class="col-sm-7">
                <input type="email" class="form-control" id="input-email" rows="3" name="input-email" maxlength="45" value="<?php echo $supplier["MailAddress"] ?>" required/>
            </div>
        </div>
        <div class="form-group row">
            <label for="input-telephone" class="col-sm-2 col-form-label">Telefonnummer</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="input-telephone" rows="3" name="input-telephone" maxlength="20" value="<?php echo $supplier["TelNo"] ?>"/>
            </div>
        </div>
        <div class="form-group row">
            <label for="input-mobile" class="col-sm-2 col-form-label">Handynummer</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="input-mobile" rows="3" name="input-mobile" maxlength="20" value="<?php echo $supplier["MobilNo"] ?>"/>
            </div>
        </div>
        <div class="form-group row">
            <label for="input-fax" class="col-sm-2 col-form-label">Faxnummer</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="input-fax" rows="3" name="input-fax" maxlength="20" value="<?php echo $supplier["FaxNo"] ?>"/>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-2">
                <button type="submit" class="btn btn-primary" name="submit-edit-supplier">Speichern</button>
            </div>
            <div class="col-sm-6">
                <a class="btn btn-secondary" href="index.php?page=supplier">Abbrechen</a>
            </div>
        </div>
    </form>
</div>
<?php endif; ?>