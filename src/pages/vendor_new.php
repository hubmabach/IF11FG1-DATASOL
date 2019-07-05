<?php

/**
 * Auf dieser Seite kann der Nutzer ein neuen Lieferanten anlegen. Bei der Eingabe der Adresse wird geprüft,
 * ob die Addresse bereits vorhanden ist und falls ja wird keine neue Adresse angelegt, sondern die bereits vorhandene
 * Addresse verwendet. Falls keine Adresse vorhanden ist, wird eine angelegt und im Lieferanten gespeichert.
 * @author Reindl/Schmiedkunz
 *
 * Benedikt 13:00-15:00
 * Matthias 13:00-15:00
 */

$supplierData = array(
    'VendorName' => "",
);
$valid = true;

if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit-new-supplier'])) {
    $supplierData = array(
        'VendorName' => $_POST["vendor_name"],
    );

    $queryCheck = "SELECT * FROM vendor WHERE VendorName = '".$supplierData["VendorName"]."';";
    $resultCheck = mysqli_query($dbLink, $queryCheck);

    if(mysqli_num_rows($resultCheck) !== 0) {
        $id = mysqli_fetch_assoc($resultCheck)["VendorID"];
        echo "<div class='alert alert-danger'>Hersteller existiert bereits. <a href='index.php?page=vendor&detail=edit&id=$id'>Zur Detailansicht</a></div>";
        $valid = false;
    }

    if ($valid) {
        $id_query = "SELECT MAX(VendorID) AS VendorID FROM vendor;";
        $id_result = mysqli_query($dbLink, $id_query);

        $id = intval(mysqli_fetch_assoc($id_result)['VendorID']) + 1;

        $queryInsertSupplier = "INSERT INTO vendor (VendorID, VendorName) VALUES ($id, '".$supplierData['VendorName']."');";
        $result = mysqli_query($dbLink, $queryInsertSupplier);

        if (!$result) {
            echo '<div class="alert alert-danger">Leider tratt bei der Verarbeitung ein Fehler auf, bitte versuchen Sie es später erneut.</div>';
        } else {
            $id = mysqli_insert_id($dbLink);
            echo "<div class='alert alert-success'>Hersteller erfolgreich angelegt. <a href='index.php?page=vendor&detail=edit&id=$id'>Zur Detailansicht</a></div>";
        }
    }
}
?>


<h1>Stammdaten - Hersteller - Neuen Hersteller anlegen</h1>

<div class="card">
    <div class="card-body" style="background-color:#f8f9fa;">
        <form method="POST">
            <div class="form-group row">
                <label for="vendor_name" class="col-sm-2 col-form-label">Herstellername</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" id="vendor_name" name="vendor_name" required value="">
                </div>
            </div>
            <button type="submit" class="btn btn-success" name="submit-new-supplier">Speichern</button>
            <a class="btn btn-secondary" href="index.php?page=supplier">Abbrechen</a>
        </form>
    </div>
</div>
