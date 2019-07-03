    
<?php 
    /**
     * Anzeige der Benutzer
     * @author Rubeins
     */
    
    $query = "SELECT UserId, UserName, UserFirstName, UserLastName, IF(IsAdmin, 'Ja', 'Nein') AS IsAdmin FROM Users";

    if (isset($_GET['search']) and !empty($_GET['search'])) {
        $query .= " WHERE UserName LIKE '%".$_GET['search']."%' OR UserFirstName LIKE '%".$_GET['search']."%' OR UserLastName LIKE '%".$_GET['search']."%'";
    }

    $result = mysqli_query($dbLink, $query);
    $tableConfig = array(
        'columns' => array(
            'UserId' => '#',
            'UserName' => 'Benutzername',
            'UserFirstName' => 'Vorname',
            'UserLastName' => 'Nachname',
            // 'UserEmail' => 'E-mail',
            'IsAdmin' => 'Systembetreuer'
        ),
        'pageName' => 'user',
        'idColumn' => 'UserId',
        'result' => $result,
        'singularName' => 'Benutzer'
    );
    ?>    

<h1>Stammdaten - Benutzerverwaltung</h1>
  
<div class="card">
    <div class="card-body">            
        <?php include_once('./templates/table.php'); ?> 
    </div>
</div>