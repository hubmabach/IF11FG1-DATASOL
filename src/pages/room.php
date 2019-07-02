<h1>Stammdaten - Räume</h1>

<?php 

$query = "SELECT * FROM rooms;";
$result = mysqli_query($dbLink, $query);

?>

<div class="card">
    <div class="card-body">
        <?php 
            $tableConfig = array(
                'columns' => array(
                    'RoomId' => '#',
                    'RoomNo' => 'Raumnummer',
                    'RoomName' => 'Raumname',
                    'RoomNodes' => 'Beschreibung'
                ),
                'singularName' => 'Raum',
                'idColumn' => 'RoomId',
                'pageName' => 'room',
                'data' => $result
            );

            include_once('./templates/table.php');
        ?>
    </div>
</div>