<?php

/**
 * Setzt alle nötigen Werten um ein Nutzer als ausgeloggt zu markieren.
 * @author Benedikt
 * Benedikt 15:45 - 15:50
 */

    setIsAdmin(false); 
    setIsLoggedIn(false); 
    setUser(null);
    header("Location: index.php");
    exit;

?>