<?php
    /**
     * Anzeige der verschiedenen Komponenten, abhängig vom ausgewähltem Raum
     */

    function getComponentByTypeId($typeId) {
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
        WHERE CT.ComponentTypeId =" .$typeId. ";";

        $result = mysqli_query($dbLink, $sqlStatement);
        return $result;
    }


   

     /**
      * Gibt das Ergebnis der Datenbankabfrage - abhaengig von der RaumId - zurueck
      * @param number $roomId - Id des ausgewaehlten Raumes
      * @return mysqli_result $result - Ergebnis der Datenbankabfrage
      */
     function getComponentsForRoom($roomId) {
        // Datenbanklink
        global $dbLink;

        // Datenbankabfrage mit variabler RaumId
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
       
       // Ergebnis der Datenbankabfrage
        $result = mysqli_query($dbLink, $sqlStatement);
        return $result;
     }
    /**
    * Gibt alle Arten von Softwares zurueck
    */
    function getSoftwareTypes() {
        global $dbLink;
        $sqlStatement =
        "SELECT ComponentTypeID, ComponentTypeName
        FROM ComponentTypes
        WHERE IsSoftware = 1";

        $result = mysqli_query($dbLink, $sqlStatement);
        return $result;
    }

    /**
     * Gibt alle Arten von Hardwares zurueck
    */
    function getHardwareTypes() {
        global $dbLink;
        $sqlStatement =
        "SELECT ComponentTypeID, ComponentTypeName
        FROM ComponentTypes
        WHERE IsSoftware = 0";

        $result = mysqli_query($dbLink, $sqlStatement);
        return $result;
    }


    $rooms = mysqli_query($dbLink, "SELECT RoomId, RoomNo FROM Rooms");
    $hardware = getHardwareTypes();
    $software = getSoftwareTypes();
     
?>



<h1>Reporting</h1>
<div class="card">
    <div class="card-body">
        <form method="POST">
        <select name="room" placeholder="Raum" class="custom-select custom-select-lg" style="width: 10%" >
            <option selected disabled>------</option>
            <?php 
                foreach($rooms as $option) {
                    echo "<option value='", $option["RoomId"],"' > ", $option["RoomNo"], " </option>";
                }        
            ?>
        </select>
        <select name="hardware" placeholer="Hardware" class="custom-select custom-select-lg" style="width: 10%" >
            <option selected disabled>------</option>
            <?php 
                foreach($hardware as $option) {
                    echo "<option value='", $option["ComponentTypeID"],"' > ", $option["ComponentTypeName"], " </option>";
                }        
            ?>
        </select>
        <select name="software" placeholder="Software" class="custom-select custom-select-lg" style="width: 10%" >
            <option selected disabled>------</option>
            <?php 
                foreach($software as $option) {
                    echo "<option value='", $option["ComponentTypeID"],"' > ", $option["ComponentTypeName"], " </option>";
                }        
            ?>
        </select>
        <button name="search" type="submit" class="btn btn-primary"> Suchen </button>
        </form>
        
        <?php

            if(isset($_POST["search"])) {
            if(isset($_POST["room"])) {
                $result = getComponentsForRoom($_POST["room"]);
            }
            if(isset($_POST["hardware"])) {
                $result = getComponentByTypeId($_POST["hardware"]);
            } 
            if(isset($_POST["software"])) {
                $result = getComponentByTypeId($_POST["software"]);
            }
            if(isset($_POST["room"]) || isset($_POST["hardware"]) || isset($_POST["software"])) {

                
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
        while ($row = mysqli_fetch_assoc($tableConfig['result'])):
        ?>
            <tr>
                <?php foreach ($tableConfig['columns'] as $columnName => $label): ?>
                <td><?php echo $row[$columnName]; ?></td>
                <?php endforeach; ?>
                <td style="width: 1%">
                    <a href="?page=komponentenart&id=<?php echo $row[$tableConfig['idColumn']]; ?>" class="btn btn-sm btn-light">Bearbeiten</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    </div>
            <?php else: ?>  
                <p style='margin-top:20px'>In diesem Raum sind keine Komponenten</p>
            <?php endif; ?>
    </div>
</div>