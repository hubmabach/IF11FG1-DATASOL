<?php
    /**
     * Formular zum Hinzufügen eines neuen Nutzers.
     */

    $userData = array(
        'UserEmail' => "",
        'UserName' => "",
        'UserFirstname' => "",
        'UserLastname' => "",
        'IsAdmin' => "0"
    );
    
    if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['user_save'])) {
        $userData = array(
            'UserEmail' => $_POST['user_email'],
            'UserName' => $_POST['user_name'],
            'UserFirstname' => $_POST['user_firstname'],
            'UserLastname' => $_POST['user_lastname'],
            'IsAdmin' => isset($_POST['user_admin']) ? "1" : "0"
        );
        
        // Hashe die Passwörter und vergleiche den Hashstring von beiden miteinander.
        $password = hashString($_POST['user_password']);
        $passwordRepeat = hashString($_POST['user_password_repeat']);

        if ($password === $passwordRepeat) {
            $query = "INSERT INTO users (UserEmail, UserName, UserFirstname, UserLastname, IsAdmin, UserPassword) VALUES (
                '".$userData['UserEmail']."', 
                '".$userData['UserName']."', 
                '".$userData['UserFirstname']."', 
                '".$userData['UserLastname']."', 
                ".$userData['IsAdmin'].", 
                '".$password."'
            )";

            $result = mysqli_query($dbLink, $query);

            if ($result === false) {

            } else {
                $id = mysqli_insert_id($dbLink);
                echo "<div class='alert alert-success'>Benutzer erfolgreich angelegt. <a href='index.php?page=user&detail=edit&id=$id'></a></div>";
            }
        } else {
            echo '<div class="alert alert-danger">Passwörter stimmen nicht überein.</div><';
        }
    }
?>
<h1>Stammdaten - Benutzer - <?php echo "Max Mustermann"; ?></h1>
<div class="card">
    <div class="card-body">
        <form method="post">
            <div class="form-group row">
                <label class="control-label col-sm-2 text-sm-right">Benutzername</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" required value="<?php echo $userData['UserName']; ?>" name="user_name" />
                </div>
            </div>
            <div class="form-group row">
                <label class="control-label col-sm-2 text-sm-right">E-Mail</label>
                <div class="col-sm-8">
                    <input type="email" class="form-control" required value="<?php echo $userData['UserEmail']; ?>" name="user_email" />
                </div>
            </div>
            <div class="form-group row">
                <label class="control-label col-sm-2 text-sm-right">Vorname</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" required value="<?php echo $userData['UserFirstname']; ?>" name="user_firstname" />
                </div>
            </div>
            <div class="form-group row">
                <label class="control-label col-sm-2 text-sm-right">Nachname</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" required value="<?php echo $userData['UserLastname']; ?>" name="user_lastname" />
                </div>
            </div>
            <hr />
            <div class="form-group row">
                <label class="control-label col-sm-2 text-sm-right">Passwort</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" required value="" name="user_password" />
                </div>
            </div>
            <div class="form-group row">
                <label class="control-label col-sm-2 text-sm-right">Passwort wiederholen</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" required value="" name="user_password_repeat" />
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-8 offset-sm-2">
                    <div class="form-check">
                        <input class="form-check-input" <?php if (boolval($userData['IsAdmin'])): ?>checked<?php endif; ?> type="checkbox" value="1" id="user_admin" name="user_admin">
                        <label class="form-check-label" for="user_admin">
                            Benutzer ist Systembetreuer
                        </label>
                    </div>
                </div>
            </div>
            <input type="submit" name="user_save" value="Speichern" class="btn btn-success" />
            <?php if (isset($_GET['id'])): ?>
            <input type="submit" name="user_delete" value="Löschen" class="btn btn-danger" />
            <?php endif; ?>
        </form>
    </div>
</div>