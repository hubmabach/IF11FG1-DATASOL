<?php
    /**
     * Anzeige der verschiedenen Komponenten, abhängig von der Filterauswahl
     * @author Rubein
     */


    /**
     * Gibt alle Komponenten mit dieser TypeId zurueck
     * @param int $typeId Id des gesuchten Komponententyps
     */
    
    function getComponentsByTypeId($typeId) {
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
        WHERE CT.ComponentTypeId =" .$typeId. "
        ORDER BY R.RoomNo ASC;";
        return getResult($sqlStatement);
    }

    /**
     * Gibt alle Komponenten zurueck, die die gesuchten Zeichen im Namen haben
     * @param string $searchTerm ganzer Name oder nur Teil des Namens eines Geraetes
     */
    function getComponentsByName($searchTerm) {
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
        WHERE C.ComponentName LIKE '%" .$searchTerm. "%'
        ORDER BY R.RoomNo ASC;";
        return getResult($sqlStatement);
    }
   

     /**
      * Gibt alle Komponenten zurueck, die sich im ausgewaehltem Raum befinden
      * @param int $roomId - Id des ausgewaehlten Raumes
      */
     function getComponentsForRoom($roomId) {
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
       return getResult($sqlStatement);

     }
    /**
    * Gibt alle Komponenten vom Typ Software zurueck
    */
    function getAllSoftwareTypes() {
        $sqlStatement =
        "SELECT ComponentTypeID, ComponentTypeName
        FROM ComponentTypes
        WHERE IsSoftware = 1;";

        return getResult($sqlStatement);
    }

    /**
     * Gibt alle Komponenten vom Typ Hardwares zurueck
    */
    function getAllHardwareTypes() {
        $sqlStatement =
        "SELECT ComponentTypeID, ComponentTypeName
        FROM ComponentTypes
        WHERE IsSoftware = 0;";

        return getResult($sqlStatement);
    }

    function getComponentsByAllFilterValues($roomId, $hardwareId, $softwareId, $searchTerm) {
        printf("here");
        $sqlStatement = 
        "SELECT C.ComponentId AS ComponentId,
        C.ComponentName,
        CT.ComponentTypeName AS Kategorie,
        R.RoomNo AS Raum
        FROM Components AS C
        INNER JOIN ComponentTypes AS CT ON C.ComponentTypeId = CT.ComponentTypeId
        INNER JOIN ComponentsInRoom AS CR ON C.ComponentId = CR.ComponentId
        INNER JOIN Rooms AS R ON R.RoomId = CR.RoomId 
        WHERE R.RoomId = " .$roomId. " AND  
        (CT.ComponentTypeId =" .$hardwareId. " OR 
        CT.ComponentTypeId =" .$softwareId. ") AND 
        C.ComponentName LIKE '%" .$searchTerm. "%'
        ORDER BY R.RoomNo ASC;";
        return getResult($sqlStatement);
    }

    /**
     * Gibt alle Raeume zurueck
     */
    function getAllRooms() {
        $sqlStatement = 
        "SELECT RoomId, RoomNo 
        FROM Rooms;";
        return getResult($sqlStatement);
    }

    /**
     * Gibt das Ergebnis der SQL-Abfrage zurueck
     * @param string $sqlStatement Beinhaltet die Datenbankabfrage
     * @return mysqli_result Ergebnis der Datenbankabfrage
     */
    function getResult($sqlStatement) {
        global $dbLink;
        return mysqli_query($dbLink, $sqlStatement);
    }

    $rooms = getAllRooms();
    $hardware = getAllHardwareTypes();
    $software = getAllSoftwareTypes();
     
?>



<h1>Reporting</h1>
<div class="card">
    <div class="card-body">
        <form method="POST" style="margin-top:20px; margin-bottom:20px;">
        <div class="form-group">
        <select id="room" name="room" placeholder="Raum" class="custom-select custom-select-lg" style="width: 10%" >
            <option value="" selected>-----</option>
            <?php 
                foreach($rooms as $option) {
                    echo "<option value='", $option["RoomId"],"' > ", $option["RoomNo"], " </option>";
                }        
            ?>
        </select>
        <script type="text/javascript">
            document.getElementById('room').value = "<?php echo $_POST['room'];?>";
        </script>
        <select id="hardware" name="hardware" placeholer="Hardware" class="custom-select custom-select-lg" style="width: 13%" >
            <option value="" selected>-----</option>
            <?php 
                foreach($hardware as $option) {
                    echo "<option value='", $option["ComponentTypeID"],"' > ", $option["ComponentTypeName"], " </option>";
                }      
            ?>
        </select>
        <script type="text/javascript">
            document.getElementById('hardware').value = "<?php echo $_POST['hardware'];?>";
        </script>
        <select id="software" name="software" placeholder="Software" class="custom-select custom-select-lg" style="width: 12%" >
            <option value="" selected>-----</option>
            <?php 
                foreach($software as $option) {
                    echo "<option value='", $option["ComponentTypeID"],"' > ", $option["ComponentTypeName"], " </option>";
                }        
            ?>
        </select>
        <script type="text/javascript">
            document.getElementById('software').value = "<?php echo $_POST['software'];?>";
        </script>
        <input id="searchfilter" type="text" name="searchfilter" class="form-control" style="width:20% !important; display:inline;" placeholder="Gerätename"/>
        <script type="text/javascript">
            document.getElementById('searchfilter').value = "<?php echo $_POST['searchfilter'];?>";
        </script>
        <button name="searchbtn" type="submit" class="btn btn-primary">Suchen</button>
        <button name="reset" type="submit" class="btn btn-secondary"> Zurücksetzen </button>
        <?php if(isset($_POST["reset"])): ?>
        <script type="text/javascript">
                document.getElementById('room').value = "";
                document.getElementById('hardware').value = "";
                document.getElementById('software').value = "";
                document.getElementById('searchfilter').value = "";
        </script>
        <?php endif; ?>
        </div>
        </form>
        
        <?php
            if(isset($_POST["searchbtn"])) {
                if(isset($_POST["room"]) && !empty($_POST["room"])
                && isset($_POST["hardware"]) && !empty($_POST["hardware"])
                && isset($_POST["software"]) && !empty($_POST["software"])
                && isset($_POST["searchfilter"]) && !empty($_POST["searchfilter"])) {
                } else {
                    if(isset($_POST["room"]) && !empty($_POST["room"])) {
                        $result = getComponentsForRoom($_POST["room"]);
                    }
                    if(isset($_POST["hardware"]) && !empty($_POST["hardware"])) {
                        $result = getComponentsByTypeId($_POST["hardware"]);
                    } 
                    if(isset($_POST["software"]) && !empty($_POST["software"])) {
                        $result = getComponentsByTypeId($_POST["software"]);
                    }
                    if(isset($_POST["searchfilter"]) && !empty($_POST["searchfilter"])) {
                        $result = getComponentsByName($_POST["searchfilter"]);
                    }
                }
                if((isset($_POST["room"]) && !empty($_POST["room"])) 
                || (isset($_POST["hardware"]) && !empty($_POST["hardware"])) 
                || (isset($_POST["software"]) && !empty($_POST["software"])) 
                || (isset($_POST["searchfilter"]) && !empty($_POST["searchfilter"]))
                ) {
                        
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
                <?php if($isAdmin):?>
                <td style="width: 1%">
                    <a href="?page=component&id=<?php echo $row[$tableConfig['idColumn']]; ?>" class="btn btn-sm btn-light">Bearbeiten</a>
                </td>
                <?php endif; ?>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    </div>
            <?php else: ?>  
                <p style='margin-top:20px'>Keine Komponenten vorhanden</p>
            <?php endif; ?>
    </div>
</div>