<?php
    /**
     * Anzeige der verschiedenen Komponenten, abhängig vom ausgewähltem Raum
     */

     $rooms = mysqli_query($dbLink, "SELECT RoomId, RoomNo FROM Rooms");

     function getComponentsForRoom($roomId) {

        global $dbLink;

        $sqlStatement =
        "SELECT 
        C.ComponentId AS ComponentId,
        C.ComponentName,
        CT.ComponentTypeName AS Kategorie,
        R.RoomNo AS Raum
        FROM Components AS C
        INNER JOIN ComponentTypes AS CT ON C.ComponentTypeId = CT.ComponentTypeId
        INNER JOIN ComponentsInRoom AS CR ON C.ComponentId = CR.ComponentId
        INNER JOIN Rooms AS R ON R.RoomId = CR.RoomId
       WHERE R.RoomId = " .$roomId. ";";
        $result = mysqli_query($dbLink, $sqlStatement);
        return $result;
     }

     
?>



<h1>Reporting</h1>
<div class="card">
    <div class="card-body">
        <form method="POST">
        <select name="selection" class="custom-select custom-select-lg" style="width: 10%" >
            <option selected disabled>------</option>
            <?php 
                foreach($rooms as $option) {
                    echo "<option value='", $option["RoomId"],"' > ", $option["RoomNo"], " </option>";
                }        
            ?>
        </select>
        <button name="search" type="submit" class="btn btn-primary"> Suchen </button>
        </form>
        
        <?php

            if(isset($_POST["search"])) {
                if(!isset($_POST['selection'])) {                    
                    return;
                }
            $result = getComponentsForRoom($_POST["selection"]);
            $tableConfig = array(
                'columns' => array(
                    'Raum' => 'Raum',
                    'ComponentName' => 'Name',
                    'Kategorie' => 'Kategorie',
                ),
                'pageName' => 'reporting',
                'idColumn' => 'ComponentId',
                'result' => $result,
            );     
        }        
    ?>
    <?php if(isset($tableConfig) && mysqli_num_rows($result) > 0): ?>
    <div class="clearfix">
    <table class="table">
        <thead>
            <tr>
                <?php foreach ($tableConfig['columns'] as $label): ?>
                    <th><?php echo $label; ?></th>
                <?php endforeach; ?>
                <th style="width: 1%"></th>
            </tr>
        </thead>
        <tbody>
        <?php
        // TODO: Zur Datenbankabfrage wechseln
        //while ($row = mysqli_fetch_assoc($tableConfig['result'])):
            foreach ($tableConfig['result'] as $row):
        ?>
            <tr>
                <?php foreach ($tableConfig['columns'] as $columnName => $label): ?>
                <td><?php echo $row[$columnName]; ?></td>
                <?php endforeach; ?>
                <td style="width: 1%">
                    <a href="?page=komponentenart&id=<?php echo $row[$tableConfig['idColumn']]; ?>" class="btn btn-sm btn-light">Bearbeiten</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
            <?php else: ?>  
                <p style='margin-top:20px'>In diesem Raum sind keine Komponenten</p>
            <?php endif; ?>
    </div>
</div>