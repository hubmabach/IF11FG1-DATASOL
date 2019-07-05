<?php 
    /**
     * Stellt alle Lieferanten in der Datenbank dar und biettet die Möglichkeit, diese zu bearbeiten,
     * bzw. neue Lieferanten anzulegen.
     * 
     * @author Reindl/Schmiedkunz
     */

    $query = "SELECT * FROM vendor";

    if (isset($_GET['search']) and !empty($_GET['search'])) {
        $query .= " WHERE VendorName LIKE '%".$_GET['search']."%'";
    }

    $result = mysqli_query($dbLink, $query);

    $tableConfig = array(
        'columns' => array(
            'VendorID' => '#',
            'VendorName' => 'Herstellername',
        ),
        'singularName' => 'Hersteller',
        'idColumn' => 'VendorID',
        'pageName' => 'vendor',
        'result' => $result
    );
?>

<h1>Stammdaten - Hersteller</h1>
<div class="card">
    <div class="card-body">
        <?php include_once('./templates/table.php'); ?>
    </div>
</div>