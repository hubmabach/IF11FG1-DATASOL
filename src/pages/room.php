<?php 
    /**
     * Auf dieser Seite werden alle Räume angzeigt, die in der Datenbank gespeichert sind.
     */
    
    $query = "SELECT * FROM rooms";

    if (isset($_GET['search']) and !empty($_GET['search'])) {
        $query .= " WHERE RoomName LIKE '%".$_GET['search']."%' OR RoomNo LIKE '%".$_GET['search']."%'";
    }

    $result = mysqli_query($dbLink, $query);

    $tableConfig = array(
        'columns' => array(
            'RoomID' => '#',
            'RoomNo' => 'Raumnummer',
            'RoomName' => 'Raumname',
            'RoomNodes' => 'Beschreibung'
        ),
        'singularName' => 'Raum',
        'idColumn' => 'RoomID',
        'pageName' => 'room',
        'result' => $result
    );
?>
<h1>Stammdaten - Räume</h1>
<div class="card">
    <div class="card-body">
        <?php include_once('./templates/table.php'); ?>
    </div>
</div>