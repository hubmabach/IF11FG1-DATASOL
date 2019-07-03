<?php

/**
 * Auf dieser Seite wird ein bestehender Raum anhander der ID in der URL angezeigt. Sollte keine ID gesetzt sein, 
 * wird der Nutzer zurück auf die Raumübersichtsseite verwiesen. Ansonsten hat er auf der Seite die Möglichkeit, 
 * alle erfassten Daten für diesen Raum abzuändern und dann anschließend zu speichern.
 */

$currentPage = $_GET["page"];
if (!isset($_GET["id"])) {
    header("Location: index.php?page=$currentPage");
    exit;
}

$id = $_GET["id"];
$query = "SELECT * FROM rooms WHERE RoomID = $id;";
$result = mysqli_query($dbLink, $query);

if (mysqli_num_rows($result) !== 0) {
    $room = mysqli_fetch_assoc($result);
    if (isset($_POST["submit-edit-room"])) {

        $roomName = $_POST["input-room-name"];
        $roomNumber = $_POST["input-room-number"];
        $roomNodes = $_POST["input-room-description"];
        $valid = true;

        if (ctype_space($roomNumber)) {
            echo "<div class='alert alert-danger' role='alert'> " .
            "Bitte geben Sie eine Raumnummer ein! " . 
          "</div>";
            $valid = false;
        }
        if (ctype_space($roomName)) {
            echo "<div class='alert alert-danger' role='alert'> " .
            "Bitte geben Sie einen Raumnamen ein! " . 
            "</div>";
            $valid = false;
        }
        if (strlen($roomNumber) !== 4) {
            echo "<div class='alert alert-danger' role='alert'> " .
            "Bitte geben Sie beim der Raumnummer genau 4 Zeichen an. " . 
            "</div>";
            $valid = false;
        }

        if ($valid) {
            $roomId = $room['RoomID'];
            $query = "UPDATE rooms SET RoomNo = '$roomNumber', RoomName = '$roomName', RoomNodes='$roomNodes' WHERE RoomID = $roomId";
            $resultUpdate = mysqli_query($dbLink, $query);

            if ($resultUpdate === false) {
                echo "<p>Upps da tratt ein Fehler auf. Versuchen Sie es bitte erneut.</p>";
            } else {
                header("Location: index.php?page=$currentPage");
                exit;
            }
        }
    }
}

if (mysqli_num_rows($result) === 0) : ?>

    <h3 class="text-danger">Der angeforderte Raum wurde leider nicht gefunden.</h3>
    <p>Vielleicht wurde er durch einen anderen Nutzer gelöscht.</p>
    <a class="btn btn-secondary" href="index.php?page=room">Zur Übersicht</a>
<?php
endif;

if (mysqli_num_rows($result) !== 0) :
    ?>

    <h1>Stammdaten - Räume - Raum bearbeiten</h1>

    <div class="container" style="margin-top:30px;">
        <form method="POST">
            <div class="form-group row">
                <label for="input-room-id" class="col-sm-2 col-form-label">Raum-Id</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" id="input-room-id" name="input-room-id" disabled value="<?php echo $room['RoomID']; ?>" />
                </div>
            </div>
            <div class="form-group row">
                <label for="input-room-number" class="col-sm-2 col-form-label">Raumnummer</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" id="input-room-number" value="<?php echo $room['RoomNo']; ?>" name="input-room-number" maxlength="4" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="input-room-name" class="col-sm-2 col-form-label">Raumname</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" id="input-room-name" value="<?php echo $room['RoomName']; ?>" name="input-room-name" maxlength="45" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="input-room-description" class="col-sm-2 col-form-label">Raumbeschreibung</label>
                <div class="col-sm-7">
                    <textarea class="form-control" id="input-room-description" rows="3" name="input-room-description" maxlength="500"><?php echo $room['RoomNodes']; ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-primary" name="submit-edit-room">Speichern</button>
                </div>
                <div class="col-sm-3">
                    <a class="btn btn-secondary" href="index.php?page=room">Abbrechen</a>
                </div>
            </div>
        </form>
    </div>
<?php endif; ?>