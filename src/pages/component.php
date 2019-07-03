<?php
    /**
     * Liste aller Kompontenen
     * 
     * @author Maximilan Bachhuber, Jonas Becker
     */

    $query = "SELECT * FROM components";

    if (isset($_GET['search']) and !empty($_GET['search'])) {
        $query .= " WHERE ComponentName LIKE '%".$_GET['search']."%'";
    }

    $result = mysqli_query($dbLink,$query);

    $tableConfig = array(
        'columns' => array(
            'ComponentID' => '#',
            'ComponentName' => 'Komponentenname',
            'SupplierID' => 'LieferantenID',
            'ComponentPurchaseDate' => 'Kaufdatum',
            'ComponentWarranty' => 'Garantie',
            'ComponentNotes' => 'Bemerkung',
            'ComponentVendorID' => 'VerkäuferID',
            'ComponentTypeID' => 'KomponentenartID'
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
