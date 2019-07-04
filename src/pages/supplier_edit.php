<?php

/**
 * Auf dieser Seite hat der Nutzer die Möglichkeit, ein Lieferanten zu bearbeiten. Dieser wird über die
 * ID in der URL herausgesucht. Sollte keine ID gesetzt sein, wird er auf die Übersichtsseite zurück verwiesen. 
 * Ansonsten werden die Felder mit den in der Datenbank gespeicherten Werten vorbefüllt. Der Nutzer kann diese anschließend
 * nach belieben bearbeiten und Speichern.
 * @author Reindl/Schmiedkunz
 * Benedikt 13:00-15:00
 * Matthias 13:00-15:00
 */
$supplierId = (isset($_GET['id']) and !empty($_GET['id'])) ? intval($_GET['id']) : -1;
$query = "SELECT * FROM Supplier INNER JOIN Address ON Supplier.AddressID = Address.AddressID WHERE SupplierID = $supplierId;";
$result = mysqli_query($dbLink, $query);
$supplier = mysqli_fetch_assoc($result);
$valid = true;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['submit-edit-supplier'])) {

        $supplierId = $supplierId;
        $supplierCompanyName = $_POST["input-supplier-name"];
        $street = $_POST["input-street"];
        $postcode = $_POST["input-postcode"];
        $city = $_POST["input-city"];
        $country = $_POST["input-country"];
        $email = $_POST["input-email"];
        $telephone = $_POST["input-telephone"];
        $mobile = $_POST["input-mobile"];
        $fax = $_POST["input-fax"];

        $addressId = $supplier["AddressID"];

        if ($valid) {
            $queryUpdateAddress = "UPDATE address SET Street = '$street', PostalCode = '$postcode', City = '$city', " .
                "Country = '$country', TelNo = '$telephone', MobilNo = '$mobile', FaxNo = '$fax', " .
                " MailAddress = '$email' WHERE AddressID = $addressId;";
            $queryUpdateCompany = "UPDATE supplier SET SupplierCompanyName = '$supplierCompanyName' WHERE SupplierID = $supplierId";

            mysqli_query($dbLink, "BEGIN");
            $resultAddress = mysqli_query($dbLink, $queryUpdateAddress);
            $resultCompany = mysqli_query($dbLink, $queryUpdateCompany);

            if ($resultAddress === false || $resultCompany === false) {
                mysqli_query($dbLink, "ROLLBACK");
                echo '<div class="alert alert-danger">Upps, da ist was schief gelaufen, versuchen Sie es bitte erneut.</div>';
            } else {
                mysqli_query($dbLink, "COMMIT");
                echo "<div class='alert alert-success'>Änderungen erfolgreich gespeichert.</div>";
                $result = mysqli_query($dbLink, $query);
                $supplier = mysqli_fetch_assoc($result);
            }
        }
    } else if (isset($_POST['submit-delete-supplier'])) {
        $queryDelete = "DELETE FROM supplier WHERE SupplierID = $supplierId";

        $resultDelete = mysqli_query($dbLink, $queryDelete);

        if ($resultDelete) {
            header("Location: ./index.php?page=supplier");
            die();
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
    ?>

    <h1>Stammdaten - Lieferanten - <?php echo $supplier["SupplierCompanyName"]; ?></h1>

    <div class="card">
        <div class="card-body" style="background-color:#f8f9fa;">
            <form method="POST">
                <div class="form-group row">
                    <label for="input-supplier-id" class="col-sm-2 col-form-label">Lieferanten-ID</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="input-supplier-id" name="input-supplier-id" disabled value="<?php echo $supplier["SupplierID"] ?>">
                    </div>
                    <label for="input-supplier-name" class="col-sm-1 col-form-label">Name</label>
                    <div class="col-sm-4">
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
                        <input type="text" class="form-control" id="input-postcode" rows="3" name="input-postcode" maxlength="5" value="<?php echo $supplier["PostalCode"] ?>" required />
                    </div>
                    <label for="input-city" class="col-sm-1 col-form-label">Stadt</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="input-city" rows="3" name="input-city" maxlength="45" value="<?php echo $supplier["City"] ?>" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="input-country" class="col-sm-2 col-form-label">Land</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="input-country" rows="3" name="input-country" maxlength="45" value="<?php echo $supplier["Country"] ?>" required />
                    </div>
                </div>
                <hr />
                <div class="form-group row">
                    <label for="input-email" class="col-sm-2 col-form-label">E-Mail</label>
                    <div class="col-sm-7">
                        <input type="email" class="form-control" id="input-email" rows="3" name="input-email" maxlength="45" value="<?php echo $supplier["MailAddress"] ?>" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="input-telephone" class="col-sm-2 col-form-label">Telefonnummer</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="input-telephone" rows="3" name="input-telephone" maxlength="20" value="<?php echo $supplier["TelNo"] ?>" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="input-mobile" class="col-sm-2 col-form-label">Handynummer</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="input-mobile" rows="3" name="input-mobile" maxlength="20" value="<?php echo $supplier["MobilNo"] ?>" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="input-fax" class="col-sm-2 col-form-label">Faxnr.</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="input-fax" rows="3" name="input-fax" maxlength="20" value="<?php echo $supplier["FaxNo"] ?>" />
                    </div>
                </div>
                <button type="submit" class="btn btn-success" name="submit-edit-supplier">Speichern</button>
                <button type="submit" class="btn btn-danger" name="submit-delete-supplier">Löschen</button>
                <a class="btn btn-secondary" href="index.php?page=supplier">Abbrechen</a>
            </form>
        </div>
    </div>
<?php endif; ?>