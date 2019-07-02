<?php 

setIsAdmin(false); // Setzt ob der aktuelle User ein Admin ist oder nicht
setIsLoggedIn(false); // Setzt den Flag, dass der User eingeloggt ist
setUser(null); // Setzt den aktuellen User um später auf z.B. den Namen zuzugreifen
header("Location: index.php");
exit;

?>