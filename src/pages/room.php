<h1>Stammdaten - Räume</h1>
<div class="card">
    <div class="card-body">
        <?php 
            $tableConfig = array(
                'columns' => array(
                    'RoomId' => '#',
                    'RoomNumber' => 'Raumnummer',
                    'RoomDescription' => 'Beschreibung'
                ),
                'singularName' => 'Raum',
                'idColumn' => 'RoomId',
                'pageName' => 'room',
                'data' => array(
                    array(
                        'RoomId' => 1,
                        'RoomNumber' => 'R001',
                        'RoomDescription' => 'Dieser Raum ist total schön.'
                    ),
                    array(
                        'RoomId' => 2,
                        'RoomNumber' => 'R002',
                        'RoomDescription' => 'Dieser Raum ist sogar noch viel schöner.'
                    ),
                    array(
                        'RoomId' => 3,
                        'RoomNumber' => 'R003',
                        'RoomDescription' => 'Dieser Raum ist einfach der tollste Raum denn ich je gesehen habe.'
                    )
                )
            );

            include_once('./templates/table.php');
        ?>
    </div>
</div>