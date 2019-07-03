<?php 
    /**
     * Stellt alle Lieferanten in der Datenbank dar und biettet die Möglichkeit, diese zu bearbeiten,
     * bzw. neue Lieferanten anzulegen.
     * 
     * @author Benedikt/Matthias
     */

    $query = "SELECT * FROM supplier INNER JOIN address on supplier.AddressId = address.AddressId";

    if (isset($_GET['search']) and !empty($_GET['search'])) {
        $query .= " WHERE SupplierCompanyName LIKE '%".$_GET['search']."%' OR TelNo LIKE '%".$_GET['search']."%'".
                    " OR MailAddress LIKE '%".$_GET['search']."%'";
    }

    $result = mysqli_query($dbLink, $query);

    $tableConfig = array(
        'columns' => array(
            'SupplierID' => '#',
            'SupplierCompanyName' => 'Lieferantenname',
            'TelNo' => 'Telefonnummber',
            'MailAddress' => 'E-mailadresse'
        ),
        'singularName' => 'Lieferant',
        'idColumn' => 'SupplierID',
        'pageName' => 'supplier',
        'result' => $result
    );
?>

<h1>Stammdaten - Lieferanten</h1>
<div class="card">
    <div class="card-body">
        <?php include_once('./templates/table.php'); ?>
    </div>
</div>