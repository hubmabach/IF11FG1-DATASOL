<h1>Stammdaten - Räume - Neuen Raum anlegen</h1>

<div class="container" style="margin-top:30px;">
    <form method="POST">
        <div class="form-group row">
            <label for="input-room-number" class="col-sm-2 col-form-label">Raumnummer</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="input-room-number" placeholder="Raumnummer z.B. R001" name="input-room-number" maxlength="20">
            </div>
        </div>
        <div class="form-group row">
            <label for="input-room-name" class="col-sm-2 col-form-label">Raumname</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="input-room-name" placeholder="Raumname z.B. Computer-Lab" name="input-room-name" maxlength="45">
            </div>
        </div>
        <div class="form-group row">
            <label for="input-room-description" class="col-sm-2 col-form-label">Raumbeschreibung</label>
            <div class="col-sm-7">
                <textarea class="form-control" id="input-room-description" rows="3" placeholder="Fügen Sie hier die Beschreibung für den Raum ein..." name="input-room-description" maxlength="500"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-1">
                <button type="submit" class="btn btn-primary" name="submit-new-room">Anlegen</button>
            </div>
            <div class="col-sm-6">
                <button type="reset" class="btn btn-secondary">Zurücksetzen</button>
            </div>
        </div>
    </form>
</div>

<?php
if (isset($_POST["submit-new-room"])) {
    $roomnumber = $_POST["input-room-number"];
    $roomname = $_POST["input-room-name"];
    $roomdescription = $_POST["input-room-description"];
    $valid = true;

    if (ctype_space($roomnumber)) {
        echo "<p>Bitte geben Sie eine Raumnummer ein!</p>";
        $valid = false;
    }
    if (ctype_space($roomname)) {
        echo "<p>Bitte geben Sie einen Raumnamen ein!</p>";
        $valid = false;
    }
    if (ctype_space($roomdescription)) {
        echo "<p>Bitte geben Sie eine Raumbeschreibung ein! </p>";
        $valid = false;
    }

    if ($valid) { 
        $query = "INSERT INTO Rooms (RoomNo, RoomName, RoomNotes) VALUES ('$roomnumber', '$roomname', '$roomdescription');";
        $result = mysqli_query($dbLink, $query);

        if(!$result) {
            echo "<p>Leider tratt bei der Verarbeitung ein Fehler auf, bitte versuchen Sie es später erneut!</p>";
        }
    }
}
?>