<?php
/**
 * Anzeige aller Komponenten
 *
 * Erstellt eine dynamische Liste von Eingabefeldern je nachdem, welcher Komponententyp ausgewählt wurde.
 *
 * Lädt eine Datei bei Vorhandensein in den Ordner `uploads` hoch.
 *
 * @author Maximilian Bachhuber, Jonas Becker
 * Beginn : 03.07.2019 9.00 : 15:00
 *
 */
    $query = "SELECT c.ComponentID, c.ComponentName, s.SupplierCompanyName, c.ComponentPurchaseDate, ct.ComponentTypeName, r.RoomName, IF(c.IsInMaintenance, 'Ja', 'Nein') AS IsInMaintenance FROM components c LEFT JOIN supplier s ON c.SupplierID = s.SupplierID LEFT JOIN componenttypes ct ON c.ComponentTypeID = ct.ComponentTypeID LEFT JOIN componentsinroom cir ON c.ComponentID = cir.ComponentID LEFT JOIN rooms r ON cir.RoomID = r.RoomID";

    if (isset($_GET['search']) and !empty($_GET['search'])) {
        $query .= " WHERE ComponentName LIKE '%".$_GET['search']."%'";
    }

    $result = mysqli_query($dbLink,$query);

    $tableConfig = array(
        'columns' => array(
            'ComponentID' => '#',
            'ComponentName' => 'Bezeichnung',
            'SupplierCompanyName' => 'Lieferant',
            'ComponentPurchaseDate' => 'Kaufdatum',
            'ComponentTypeName' => 'Art',
            'RoomName' => 'Raum',
            'IsInMaintenance' => "Ausgemustert"
        ),
        'singularName' => 'Komponenten',
        'idColumn' => 'ComponentID',
        'pageName' => 'component',
        'result' => $result
    );
?>

<h1>Stammdaten - Komponenten</h1>
<div class="card">
    <div class="card-body">
        <?php include_once('./templates/table.php'); ?>
    </div>
</div>
