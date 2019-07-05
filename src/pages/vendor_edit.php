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
$query = "SELECT * FROM vendor WHERE VendorID = $supplierId;";
$result = mysqli_query($dbLink, $query);
$supplier = mysqli_fetch_assoc($result);
$valid = true;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['submit-edit-supplier'])) {

        $supplierId = $supplierId;
        $supplierCompanyName = $_POST["vendor_name"];

        if ($valid) {
            $queryUpdateCompany = "UPDATE vendor SET VendorName = '$supplierCompanyName' WHERE VendorID = $supplierId";

            mysqli_query($dbLink, "BEGIN");
            $resultCompany = mysqli_query($dbLink, $queryUpdateCompany);

            if ($resultCompany === false) {
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
        $queryDelete = "DELETE FROM vendor WHERE VendorID = $supplierId";

        $resultDelete = mysqli_query($dbLink, $queryDelete);

        if ($resultDelete) {
            header("Location: ./index.php?page=vendor");
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

    <h1>Stammdaten - Hersteller - <?php echo $supplier["VendorName"]; ?></h1>

    <div class="card">
        <div class="card-body" style="background-color:#f8f9fa;">
            <form method="POST">
                <div class="form-group row">
                    <label for="vendor_name" class="col-sm-1 col-form-label">Herstellername</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="vendor_name" name="vendor_name" maxlength="45" value="<?php echo $supplier["VendorName"] ?>" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-success" name="submit-edit-supplier">Speichern</button>
                <button type="submit" class="btn btn-danger" name="submit-delete-supplier">Löschen</button>
                <a class="btn btn-secondary" href="index.php?page=supplier">Abbrechen</a>
            </form>
        </div>
    </div>
<?php endif; ?>