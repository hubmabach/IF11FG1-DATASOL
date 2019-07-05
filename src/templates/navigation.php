<?php
    /**
     * Template für die Hauptnavigation des Weboberfläche.
     * 
     * Die Navigationspunkte werden erst angezeigt, sobald der Benutzer angemeldet ist.
     * Solange der Benutzer kein Systembetreuer/Admin ist, wird diesem in der Navigation nur der Punkt "Reporting" angezeigt.
     * 
     * @author Nikolas Bayerschmidt
     */
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
    <a class="navbar-brand" href="index.php">
        <img src="./assets/logo.png" height="30" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <?php if ($isLoggedIn): ?>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item" id="navbar-reporting">
                <a class="nav-link" href="index.php?page=reporting">Reporting</a>
            </li>
            <?php if ($isAdmin): ?>
            <li class="nav-item dropdown" id="navbar-stammdaten">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Stammdaten
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="index.php?page=supplier">Lieferanten</a>
                <a class="dropdown-item" href="index.php?page=vendor">Hersteller</a>
                <a class="dropdown-item" href="index.php?page=room">Räume</a>
                <a class="dropdown-item" href="index.php?page=users">Benutzer</a>
                <a class="dropdown-item" href="index.php?page=component">Komponenten</a>
                <a class="dropdown-item" href="index.php?page=componenttypes">Komponentenarten</a>
            </div>
            </li>
            <li class="nav-item" id="navbar-new-component">
                <a class="nav-link" href="index.php?page=component&detail=new">Neubeschaffung</a>
            </li>
            <?php endif; ?>
        </ul>
        <form class="form-inline">
            <a class="btn btn-outline-danger my-2 my-sm-0" href="index.php?page=logout">Abmelden</a>
        </form>
    <?php endif; ?>
    </div>
</nav>