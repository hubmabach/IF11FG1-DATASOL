<?php

/**
 * Authentification-Page
 * 
 * - Zum Login werden Benutzername und Passwort benötigt
 * - Über "input-username" und "input-password" werden die Daten beim Drücken des "Anmelden"-Buttons mit den Einträgen in der Datenbank verglichen 
 * - Das Passwort wird über einen One-Direction-Hash ("md5") gesichert, hier wird das Passwort im Plain Text eingegeben, gehasht und mit dem gehashten Passwort auf der Datenbank verglichen
 * 
 * - Zeit: Beni: 09:00 - 13:27
 * - Zeit: Matze S: 09:00 - 12:45
 */

if (isset($_POST["submit-login"])) {
  $username = $_POST["input-username"];
  $password = hashString($_POST["input-password"]);

  $query = "SELECT * FROM users WHERE UserName = '$username';";  //Query zum Abfragen des Usernames
  $result = mysqli_query($dbLink, $query); //Ist das Ergebnis der Suche aus der SQL - Query (filtert Usernames)
  $count = mysqli_num_rows($result); //Zählt die Anzahl der gefundenen Results

  if ($count === 0) //User ist in der Datenbank nicht vorhanden
  {
    echo "<p>Der Nutzername und/oder Passwort ist nicht korrekt </p>";
  } else {
    $userFromDb = mysqli_fetch_assoc($result); // Holt den aktuellen User aus dem Ergebnisdaten raus

    if ($userFromDb["UserPassword"] == $password) // Prüft ob das eingegebene Passwort das gleiche ist, wie in der Datenbank gespeichert.
    {
      setIsAdmin($userFromDb["IsAdmin"]); // Setzt ob der aktuelle User ein Admin ist oder nicht
      setIsLoggedIn(true); // Setzt den Flag, dass der User eingeloggt ist
      setUser($userFromDb); // Setzt den aktuellen User um später auf z.B. den Namen zuzugreifen
      header("Location: index.php");
      exit;
    } else // Das eingegebene Passwort ist falsch.
    {
      ?>
      <div class="container">
        <div class="row">
          <div class="col-lg-7 offset-2">
            <div class="alert alert-danger">Der Nutzername und/oder Passwort ist nicht korrekt.</div>
          </div>
        </div>
      </div>
    <?php
    }
  }
}
?>

<div class="container">
  <div class="row">
    <div class="col-lg-7 offset-2">
      <h1>Login</h1>
      <div class="card">
        <div class="card-body" style="background-color:#f8f9fa;">
          <form method="POST" action="">
            <div class="form-group">
              <label for="input-username">Benutzername</label>
              <input type="text" class="form-control" id="input-username" aria-describedby="emailHelp" placeholder="Bitte geben Sie den Benutzer ein..." name="input-username">
            </div>
            <div class="form-group">
              <label for="input-password">Passwort</label>
              <input type="password" class="form-control" id="input-password" placeholder="Passwort" name="input-password">
            </div>
            <button type="submit" name="submit-login" class="btn btn-success">Anmelden</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php



?>