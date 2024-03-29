<?php 
    /**
     * Dient dazu bei jedem Request festzustellen ob der Nutzer eingeloggt ist oder nicht. Des Weiteren
     * wird geprüft welche Rechte der Nutzer hat um entsprechend die Navigationsleiste zu erstellen.
     * Ist der Nutzer eingeloggt wird auch gleich der Nutzer in einer Variable abgespeichert, damit jeder
     * auf die Daten des Nutzes zugreifen kann. Ebenso wird auch gleich eine Verbindung mit der Datenbank hergestellt.
     * 
     * Weiterhin werden hier funktionen und Variablen definiert, welche für alle Dateien verfügbar sind.
     * 
     * @author Reindl/Schmiedkunz
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
     * @author Reindl/Schmiedkunz
     */
    function setIsAdmin($value){
        $_SESSION["Admin"] = $value; // Setzt ob der Nutzer Admin ist oder nicht in die Session
    }

    /**
     * Setzt ob ein Nutzer aktuell eingeloggt ist oder nicht
     * @param value ist ein boolscher Wert.
     * @author Reindl/Schmiedkunz
     */
    function setIsLoggedIn($value){
        $_SESSION["Loggedin"] = $value; // Setzt ob der Nutzer eingeloggt ist oder nicht in die Session
    }

    /**
     * Setzt den aktuellen User
     * @param value assoziatives Array mit den Userdaten.
     * @author Reindl/Schmiedkunz
     */
    function setUser($value){
        $_SESSION["User"] = $value; // Setzt den aktuell eingeloggten User
    }

    /**
     * Hasht einen String mit unseren Hash-Algorithmus.
     * @param string der String der gehasht werden soll.
     * @author Reindl/Schmiedkunz
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
     * Funktion um ein assoziatives Array in eine MySQL-UPDATE-Wertefolge zu formatieren.
     * 
     * @author Nikolas Bayerschmidt
     * @param array $valueArray Assoziatives Array mit Werten
     * @return string $updateStr Zeichenfolge die der Wertevergabe bei einer UPDATE-Datenbankabfrage gleicht. (`COLUMN = VALUE`)
     */
    function sqlUpdateString($valueArray) {
        $updateStr = "";
        $arrayKeys = array_keys($valueArray);
        $lastArrayKey = array_pop($arrayKeys);
        foreach ($valueArray as $key => $value) {

            // Wenn der Wert ein String ist, müssen extra Anführungszeichen hinzugefügt werden.
            if (is_string($value)) $value = "\"$value\"";

            $updateStr .= $key." = ".$value;

            // Sollte der Iterator nicht bei dem letzten Wert sein, dann füge ein Komma zur Zeichenfolge hinzu.
            if ($key !== $lastArrayKey) $updateStr .= ", ";
        }

        return $updateStr;
    }
?>