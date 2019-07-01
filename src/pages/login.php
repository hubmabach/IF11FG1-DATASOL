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
?>



<form method="POST" action="">
    <div class="form-group">
        <label for="input-username">Benutzername</label>
        <input type="text" class="form-control" id="input-username" aria-describedby="emailHelp" placeholder="Bitte geben Sie den Benutzer ein..." name="input-username">
    </div>
    <div class="form-group">
        <label for="input-password">Passwort</label>
        <input type="password" class="form-control" id="input-password" placeholder="Passwort" name="input-password">
    </div>
    <button type="submit" name="submit-login" class="btn btn-primary">Anmelden</button>
</form>

<?php 

if(isset($_POST["submit-login"]))    
{
  $username = $_POST["input-username"];
  $password = hashString($_POST["input-password"]); 

  $query = "SELECT * FROM user WHERE Username = '$username';";  //Query zum Abfragen des Usernames
  $result = mysqli_query($dbLink, $query); //Ist das Ergebnis der Suche aus der SQL - Query (filtert Usernames)
  $count = mysqli_num_rows($result); //Zählt die Anzahl der gefundenen Results

  if($count === 0) //User ist in der Datenbank nicht vorhanden
  {
    echo "<p>Der Nutzername und/oder Passwort ist nicht korrekt </p>";
  }
 else {
  $userFromDb = mysqli_fetch_assoc($result); // Holt den aktuellen User aus dem Ergebnisdaten raus

  if($userFromDb["Passwort"]==$password) // Prüft ob das eingegebene Passwort das gleiche ist, wie in der Datenbank gespeichert.
  {
    setIsAdmin($user["IsAdmin"]); // Setzt ob der aktuelle User ein Admin ist oder nicht
    setIsLoggedIn(true); // Setzt den Flag, dass der User eingeloggt ist
    setUser($userFromDb); // Setzt den aktuellen User um später auf z.B. den Namen zuzugreifen
    header("Location: index.php");
    exit;
  } else // Das eingegebene Passwort ist falsch.
  {
    echo "<p>>Der Nutzername und/oder Passwort ist nicht korrekt </p>";
  }
    
}
  
}

?>