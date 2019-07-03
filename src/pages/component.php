<?php
#Hole alle Einträge aus der Tabelle Components

$query = "SELECT * FROM components";

$result = mysqli_query($dbLink,$query);

# Zähle alle Einträge

?>

<h1>Stammdaten - Komponenten</h1>
<div class="card">
    <div class="card-body">
        <?php
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
                'IDColumn' => 'ComonentID',
                'pageName' => 'component',
                'result' => $result
            );

            include_once('./templates/table.php');
        ?>
    </div>
</div>
