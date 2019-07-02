<?php 
    /**
     * TODO: Dokumentation
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

    function setIsAdmin($value){
        $_SESSION["Admin"] = $value; // Setzt ob der Nutzer Admin ist oder nicht in die Session
    }

    function setIsLoggedIn($value){
        $_SESSION["Loggedin"] = $value; // Setzt ob der Nutzer eingeloggt ist oder nicht in die Session
    }

    function setUser($value){
        $_SESSION["User"] = $value; // Setzt den aktuell eingeloggten User
    }

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
?>