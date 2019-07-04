<?php
    /**
     * Anzeige der verschiedenen Komponenten, abhängig von der Filterauswahl
     * @author Rubein
     */


     /**
     * Gibt das Ergebnis der SQL-Abfrage zurueck
     * @param string $sqlStatement Beinhaltet die Datenbankabfrage
     * @return mysqli_result Ergebnis der Datenbankabfrage
     */
    function getResult($sqlStatement) {
        global $dbLink;
        return mysqli_query($dbLink, $sqlStatement);
    }

    /**
     * ueberprueft ob das asoziative globale $_POST Array an der Stelle $arrPos valide ist
     * @param string $arrPos Wert der zu ueberpruefenden Stelle
     * @return boolean gibt true bei einem gesetztem und nicht leeren Wert zurueck
     */
    function isValidInput($arrPos) {
        if(isset($_POST[$arrPos]) && !empty($_POST[$arrPos])) return true;
        else return false;
    }


    /**
     * Suchefunktion, die alle moeglichen Filtereinstellungen beruecksichtigt 
     * und demensprechend die Datenbankabfrage generiert und das Ergebnis zurueck gibt
     */
    function getComponentsByFilterValues() {
        // Grundabfrage - beinhaltet alle Tabellen-JOINS
        $sqlStatement = 
        "SELECT C.ComponentId AS ComponentId,
        C.ComponentName,
        CT.ComponentTypeName AS Kategorie,
        R.RoomNo AS Raum,
        C.IsInMaintenance AS Ausgemustert
        FROM Components AS C
        INNER JOIN ComponentTypes AS CT ON C.ComponentTypeId = CT.ComponentTypeId
        INNER JOIN ComponentsInRoom AS CR ON C.ComponentId = CR.ComponentId
        INNER JOIN Rooms AS R ON R.RoomId = CR.RoomId WHERE ";

        // Sofern nach einem Raum gefiltert wird, wird dieser der DB-Abfrage hinzugefuegt
        if(isValidInput("room")) {
            if ($_POST["room"] == "IsInMaintenance") {
                // Wenn nach den Ausgemusterten Komponenten gesucht wird, landet man hier
                $sqlStatement .= " C.IsInMaintenance = 1 ";
            } else {
                // Filterkriterium der gesuchten RaumId zur DB-Abfrage hinzufuegen
                $sqlStatement .= "R.RoomId = " .$_POST["room"]. " AND C.IsInMaintenance = 0 ";                
            }          
        }
        // Sofern nach einer bestimmten Hardware gesucht wird, wird diese der DB-Abfrage hinzugefuegt
        if (isValidInput("hardware")) {
            // vorher wird aber ggf. noch das richtige Verbindungs-Keyword ergaenzt
            if(isValidInput("room")) {
                $sqlStatement .= " AND ";
            }
            if (isValidInput("software")) {
                $sqlStatement .= "(";
            }
            // Filterkriterium der Hardware-TypeId zur DB-Abfrage hinzufuegen
            $sqlStatement .= "CT.ComponentTypeId = " .$_POST["hardware"]. " ";
        }
        // Sofern nach einer bestimmen Software gesucht wird, wird diese der DB-Abfrage hinzugefuegt
        if(isValidInput("software")) {
            // vorher wird aber ggf. noch das richtige Verbindungs-Keyword ergaenzt
            if(isValidInput("room") && !isValidInput("hardware")) {
                $sqlStatement .= " AND ";
            }
            if(isValidInput("hardware")) {
                $sqlStatement .= " OR ";
            }
            // Filterkriterium der Software-TypeId zur DB-Abfrage hinzufuegen
            $sqlStatement .= "CT.ComponentTypeId =" .$_POST["software"]. " ";

            if(isValidInput("hardware")) {
                $sqlStatement .= ") ";
            }
        }

        // Sofern nach einer bestimmten Komponente namentlich gesucht wird, wird diese zur DB-Abfrage hinzugefuegt
        if (isValidInput("searchfilter")) {

            // vorher wird aber ggf. noch das richtige Verbindungs-Keyword ergaenzt
            if (isValidInput("room") || isValidInput("hardware") || isValidInput("software")) {
                $sqlStatement .= " AND ";
            }

            // Filterkriterium des (Teil-)Geraetenamens zur DB-Abfrage hinzufuegen
            $sqlStatement .= "C.ComponentName LIKE '%" .$_POST["searchfilter"]. "%' ";
        }
        // Sortierung aufsteigen nach der Raumnummer
        $sqlStatement .= "ORDER BY R.RoomNo ASC;";

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

    /**
     * Gibt alle Raeume zurueck
     */
    function getAllRooms() {
        $sqlStatement = 
        "SELECT RoomId, RoomNo, RoomName
        FROM Rooms;";
        return getResult($sqlStatement);
    }



    $rooms = getAllRooms();
    $hardware = getAllHardwareTypes();
    $software = getAllSoftwareTypes();
     
?>



<h1>Reporting</h1>
<div class="card">
    <div class="card-body">
        <form method="POST" style="margin-top:20px; margin-bottom:20px;">
        <div class="form-group d-flex flex-row justify-content-around align-items-center">
            <div class="d-flex flex-column ">
                <label>Raum</label>
                <select id="room" name="room" placeholder="Raum" class="custom-select custom-select-lg" >
                    <option value="" selected>-----</option>
                    <?php 
                        foreach($rooms as $option) {
                            echo "<option value='", $option["RoomId"],"' ".((isset($_POST['room']) and $_POST['room'] == $option['RoomId']) ? "selected" : ""). "> ", $option["RoomNo"], " (", $option["RoomName"], ") </option>";
                        }        
                    ?>
                    <option value="IsInMaintenance">Ausgemustert</option>
                </select>
            </div>        
        <div class="d-flex flex-column ">
        <label>Hardware</label>
            <select id="hardware" name="hardware" placeholer="Hardware" class="custom-select custom-select-lg" >
                <option value="" selected>-----</option>
                <?php 
                    foreach($hardware as $option) {
                        echo "<option value='", $option["ComponentTypeID"],"' ".((isset($_POST['hardware']) and $_POST['hardware'] == $option['ComponentTypeID']) ? "selected" : "")."> ", $option["ComponentTypeName"], " </option>";
                    }      
                ?>
            </select>
        </div>

        <div class="d-flex flex-column ">
            <label>Software</label>
            <select id="software" name="software" placeholder="Software" class="custom-select custom-select-lg" >
                <option value="" selected>-----</option>
                <?php 
                    foreach($software as $option) {
                        echo "<option value='", $option["ComponentTypeID"],"' ".((isset($_POST['software']) and $_POST['software'] == $option['ComponentTypeID']) ? "selected" : "")." > ", $option["ComponentTypeName"], " </option>";
                    }        
                ?>
            </select>
        </div>
        <input id="searchfilter" type="text" name="searchfilter" <?php echo "value='", (isset($_POST['searchfilter']) ? $_POST['searchfilter'] : ""), "'" ?>  class="form-control" style="width:20% !important; display:inline; margin-top:25px" placeholder="Gerätename"/>
        <button name="searchbtn" type="submit" class="btn btn-primary" style="margin-top:25px">Suchen</button>
        <button name="reset" type="submit" class="btn btn-secondary" style="margin-top:25px"> Zurücksetzen </button>
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

                $result = getComponentsByFilterValues();

                if( isValidInput("room") ||
                    isValidInput("hardware") ||
                    isValidInput("software") ||
                    isValidInput("searchfilter")
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
                    <a href="?page=component&detail=edit&id=<?php echo $row[$tableConfig['idColumn']]; ?>" class="btn btn-sm btn-light">Bearbeiten</a>
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