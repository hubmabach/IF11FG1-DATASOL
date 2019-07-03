<h1>Stammdaten - Lieferanten</h1>
<div class="card">
    <div class="card-body">
        <?php 

            /**
             * Stellt alle Lieferanten in der Datenbank dar und biettet die Möglichkeit, diese zu bearbeiten,
             * bzw. neue Lieferanten anzulegen.
             */

            $query = "SELECT * FROM supplier INNER JOIN address on supplier.AddressId = address.AddressId";
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

            include_once('./templates/table.php');
        ?>
    </div>
</div>