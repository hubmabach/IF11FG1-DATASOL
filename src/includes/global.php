<?php 
    /**
     * TODO: Dokumentation
     */

    session_start(); 

    $dbLink = @mysqli_connect("localhost", "root", "", "projekt");

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
?>