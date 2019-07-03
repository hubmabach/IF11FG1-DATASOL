<?php 
    /**
     * Dient dazu bei jedem Request festzustellen ob der Nutzer eingeloggt ist oder nicht. Des Weiteren
     * wird geprüft welche Rechte der Nutzer hat um entsprechend die Navigationsleiste zu erstellen.
     * Ist der Nutzer eingeloggt wird auch gleich der Nutzer in einer Variable abgespeichert, damit jeder
     * auf die Daten des Nutzes zugreifen kann. Ebenso wird auch gleich eine Verbindung mit der Datenbank hergestellt.
     * 
     * @author Benedikt/Matthias
     * 
     * Benedikt: 11:00 - 12:00
     * Matthias: 11:00 - 12:00
     */

    session_start(); 

    $dbLink = @mysqli_connect("localhost", "root", "", "gruppe1db");

    if($dbLink === false)
    {
        die("<p>Es ist ein Fehler bei der Verbindung zum Remote-Server aufgetreten</p>");
    }

    $isLoggedIn = isset($_SESSION["Loggedin"]) && $_SESSION["Loggedin"];
    $isAdmin = isset($_SESSION["Admin"]) && ($_SESSION["Admin"]);
    $user = isset($_SESSION["User"]) ? $_SESSION["User"] : null;

    /**
     * Setzt den Wert ob ein Nutzer Admin ist oder nicht.
     * @param value ist ein booolscher Wert.
     * @author Benedikt/Matthias
     */
    function setIsAdmin($value){
        $_SESSION["Admin"] = $value; // Setzt ob der Nutzer Admin ist oder nicht in die Session
    }

    /**
     * Setzt ob ein Nutzer aktuell eingeloggt ist oder nicht
     * @param value ist ein boolscher Wert.
     * @author Benedikt/Matthias
     */
    function setIsLoggedIn($value){
        $_SESSION["Loggedin"] = $value; // Setzt ob der Nutzer eingeloggt ist oder nicht in die Session
    }

    /**
     * Setzt den aktuellen User
     * @param value assoziatives Array mit den Userdaten.
     * @author Benedikt/Matthias
     */
    function setUser($value){
        $_SESSION["User"] = $value; // Setzt den aktuell eingeloggten User
    }

    /**
     * Hasht einen String mit unseren Hash-Algorithmus.
     * @param string der String der gehasht werden soll.
     * @author Benedikt/Matthias
     */
    function hashString($string){
        return hash ( "md5", $string, FALSE); // md5 Hash (One-Direction)
    }


    /**
     * Verwandelt das Ergebnis einer MySQL-Datenbankabfrage in ein Ein-Dimensionales-Array anhand eines angegebenen Feldes.
     * 
     * @author Nikolas Bayerschmidt
     * @param mysqli_result $result Das Ergebnis einer MySQL-Datenbankabfrage (mysqli_query)
     * @param string $columnName Der Name des Feldes aus dem der Wert gezogen wird.
     * @return array $od_array Ein-Dimensionales-Array
     */
    function mysqli_od_array($result, $columnName) {
        $od_array = array();

        while ($row = mysqli_fetch_array($result)) {
            if ($row[$columnName]) array_push($od_array, $row[$columnName]);
        }

        return $od_array;
    }

    /**
     * Erstellt eine absolute URL zum angegebenen Pfad.
     * 
     * @author Nikolas Bayerschmidt
     * @param string $urlPart Pfad der an die Domain angehängt werden sollen.
     * @return string $absUrl Die absolute URL.
     */
    function abs_url($urlPart) {
        // Überprüfe, ob der Pfad mit einem Strich ("/") anfängt. Wenn nicht, dann füge einen hinzu.
        if (substr( $urlPart, 0, 1 ) !== "/") $urlPart = "/" . $urlPart;

        // Browser erkennen die Nutzung von "//" und benutzen automatisch "http"/"https" je nachdem womit die Seite aufgerufen wurde.
        return "//" . $_SERVER['SERVER_NAME'] . $urlPart;
    }
?>