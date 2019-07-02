<?php 

/**
 * Dient als Routing für unsere Applikation. Alle Seiten werden über die index.php ausgeliefert. 
 * 
 * Sollte der Nutzer nicht eingeloggt sein, wird er auf die Login-Seite weitergeleitet. 
 * 
 * Ist der Nutzer eingeloggt und hat keine spezielle Seite ausgewählt, wird die Reportingseite als Standardseite zurückgegeben.
 * 
 * Ist der Nutzer eingeloggt und ruft eine spezielle Seite auf, wird die Listenansicht zurück gegeben.
 * Ansonsten wird ein zusätzlicher Paramter übergeben, der auf eine Unterseite verweißt.
 */

$errorPage = realpath( __DIR__ . "/../pages/errorpage.php");

if($isLoggedIn)
{
    if(!isset($_GET["page"]))
    {
        include_once(realpath( __DIR__ . "/../pages/reporting.php"));
    }
    else 
    {
        $path = $_GET["page"];

        if(isset($_GET["detail"]))
        {
            $detail = $_GET["detail"];
            $filePath = realpath(__DIR__ . "/../pages/$path" . "_" . "$detail.php");

            if(file_exists($filePath))
                include_once($filePath);
            else
                include_once($errorPage);
        }
        else
        {
            $filePath = realpath( __DIR__ . "/../pages/$path.php");

            if(file_exists($filePath))
                include_once($filePath);
            else
                include_once($errorPage);
        }
    }
}
else 
{
    include_once(realpath( __DIR__ . '/../pages/login.php'));
}

?>