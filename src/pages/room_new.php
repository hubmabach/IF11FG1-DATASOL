<?php

/**
 * Auf dieser Seite hat der Nutzer die Möglichkeit, einen neuen Raum anzulegen. Es wird geprüft ob alle 
 * Pflichtfelder gesetzt sind oder nicht. 
 * 
 * @author Reindl/Schmiedkunz
 */

$roomnumber = "";
$roomname = "";
$roomdescription = "";

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit-new-room'])) {
    $roomnumber = $_POST["input-room-number"];
    $roomname = $_POST["input-room-name"];
    $roomdescription = $_POST["input-room-description"];
    $valid = true;

    if (strlen($roomnumber) !== 3) {
        echo "<div class='alert alert-danger' role='alert'> " .
            "Bitte geben Sie bei der Raumnummer genau 3 Zahlen an. " .
            "</div>";
        $valid = false;
    }

    $queryCheck = "SELECT * FROM rooms WHERE RoomNo = 'R$roomnumber'";
    $resultCheck = mysqli_query($dbLink, $queryCheck);

    if (mysqli_num_rows($resultCheck) !== 0) {
        $id = mysqli_fetch_assoc($resultCheck)["RoomID"];
        echo "<div class='alert alert-danger'>Raumnummer existiert bereits. <a href='index.php?page=room&detail=edit&id=$id'>Zur Detailansicht</a></div>";
        $valid = false;
     }

    if ($valid) {
        $query = "INSERT INTO rooms (RoomNo, RoomName, RoomNodes) VALUES ('R$roomnumber', '$roomname', '$roomdescription');";
        $result = mysqli_query($dbLink, $query);

        if ($result) {
            $id = mysqli_insert_id($dbLink);
            echo "<div class='alert alert-success'>Raum erfolgreich angelegt. <a href='index.php?page=room&detail=edit&id=$id'>Zur Detailansicht</a></div>";
        } else {
            echo '<div class="alert alert-danger">Leider tratt bei der Verarbeitung ein Fehler auf, bitte versuchen Sie es später erneut.</div>';
        }
    }
}
?>

<h1>Stammdaten - Räume - Neuen Raum anlegen</h1>

<div class="card">
    <div class="card-body" style="background-color:#f8f9fa;">
        <form method="POST">
            <div class="form-group row">
                <label for="input-room-number" class="col-sm-2 col-form-label">Raumnummer</label>
                <div class="col-sm-7">
                    <input type="number" class="form-control" id="input-room-number" placeholder="Raumnummer z.B. 001" name="input-room-number" maxlength="3" required value="<?php echo $roomnumber; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="input-room-name" class="col-sm-2 col-form-label">Raumname</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" id="input-room-name" placeholder="Raumname z.B. Computer-Lab" name="input-room-name" maxlength="45" required value="<?php echo $roomname; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="input-room-description" class="col-sm-2 col-form-label">Raumbeschreibung</label>
                <div class="col-sm-7">
                    <textarea class="form-control" id="input-room-description" rows="3" placeholder="Fügen Sie hier die Beschreibung für den Raum ein..." name="input-room-description" maxlength="500"><?php echo $roomdescription ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-1">
                    <button type="submit" class="btn btn-success" name="submit-new-room">Speichern</button>
                </div>
            </div>
        </form>
    </div>
</div>