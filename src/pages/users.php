    
<?php 
    /**
     * Anzeige der Benutzer
     */
    
     $result = mysqli_query($dbLink,
     "SELECT UserId, UserName, UserFirstName, UserLastName, IF(IsAdmin, 'Ja', 'Nein') AS IsAdmin FROM Users");
     $tableConfig = array(
        'columns' => array(
            'UserId' => '#',
            'UserName' => 'Benutzername',
            'UserFirstName' => 'Vorname',
            'UserLastName' => 'Nachname',
            // 'UserEmail' => 'E-mail',
            'IsAdmin' => 'Systembetreuer'
        ),
        'pageName' => 'users',
        'idColumn' => 'UserId',
        'result' => $result,
        'singularName' => 'Benutzer'
    );
    ?>    

<h1>Stammdaten - Benutzerverwaltung</h1>
  
<div class="card">
    <div class="card-body">            
        <?php
            include_once('./templates/table.php');
        ?> 
    </div>
</div>



