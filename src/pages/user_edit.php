<?php
    /**
     * Bearbeiten eines bereits bestehenden Nutzers.
     * 
     * Holt sich die Daten des Nutzers ausgehend von dem Paramter `id` in der URL.
     * 
     * @author Nikolas Bayerschmidt
     */

    $userId = (isset($_GET['id']) and !empty($_GET['id'])) ? intval($_GET['id']) : false;

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['user_save'])) {
            $error = "";

            $userData = array(
                'UserEmail' => $_POST['user_email'],
                'UserName' => $_POST['user_name'],
                'UserFirstname' => $_POST['user_firstname'],
                'UserLastname' => $_POST['user_lastname'],
                'IsAdmin' => isset($_POST['user_admin']) ? "1" : "0"
            );
            
            if (!empty($_POST['user_password'])) {
                // Hashe die Passwörter und vergleiche die Hashstrings miteinander. Sollten diese Übereinstimmen, dann füge den Wert zum $userData Array hinzu.
                $password = hashString($_POST['user_password']);
                $passwordRepeat = hashString($_POST['user_password_repeat']);
                if ($password === $passwordRepeat) {
                    $userData['UserPassword'] = $password;
                } else {
                    $error = "Passwörter stimmen nicht überein.";
                }
            }

            if (empty($error)) {
                $query = "UPDATE users SET ".sqlUpdateString($userData)." WHERE UserID = $userId";
                $result = mysqli_query($dbLink, $query);

                if($result){
                    echo "<div class='alert alert-success'>Änderungen erfolgreich gespeichert.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Bei der Bearbeitung Ihrer Anfrage tat ein Fehler auf.</div>";
                }
            } else {
                ?><div class="alert alert-danger"><?php echo $error; ?></div><?php
            }
        } else if (isset($_POST['user_delete'])) {
            $query = "DELETE FROM users WHERE UserID = $userId";

            $result = mysqli_query($dbLink, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                header("Location: ./index.php?page=users");
                die();
            }
        }
    }
    
    $query = "SELECT UserEmail, UserName, UserFirstname, UserLastname, IsAdmin FROM users WHERE UserID = $userId;";

    $result = mysqli_query($dbLink, $query);

    if (mysqli_num_rows($result) === 0) : ?>

    <h3 class="text-danger">Der angeforderte Benutzer wurde leider nicht gefunden.</h3>
    <p>Vielleicht wurde er durch einen anderen Nutzer gelöscht.</p>
    <a class="btn btn-secondary" href="index.php?page=users">Zur Übersicht</a>
<?php
endif;

    if (mysqli_num_rows($result) > 0):
        $userData = mysqli_fetch_assoc($result);
?>

    <h1>Stammdaten - Benutzer - <?php echo $userData["UserName"]; ?></h1>
    <div class="card">
        <div class="card-body" style="background-color:#f8f9fa;">   
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
                        <input type="password" class="form-control" value="" name="user_password" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-sm-2 text-sm-right">Passwort wiederholen</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" value="" name="user_password_repeat" />
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
</div>
<?php endif; ?>