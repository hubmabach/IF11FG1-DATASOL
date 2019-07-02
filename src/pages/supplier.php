<h1>Stammdaten - Lieferanten</h1>
<div class="card">
    <div class="card-body">
        <?php 
            $tableConfig = array(
                'columns' => array(
                    'SupplierId' => '#',
                    'SupplierName' => 'Lieferantenname',
                    'SupplierContactInformation' => 'Kontaktinformationen'
                ),
                'singularName' => 'Lieferant',
                'idColumn' => 'SupplierId',
                'pageName' => 'supplier',
                'data' => array(
                    array(
                        'SupplierId' => 1,
                        'SupplierName' => 'R001',
                        'SupplierContactInformation' => 'Tel: 01234/56789 E-Mail: test@test.de'
                    ),
                    array(
                        'SupplierId' => 2,
                        'SupplierName' => 'R002',
                        'SupplierContactInformation' => 'Tel: 01234/56789 E-Mail: test@test.de'
                    ),
                    array(
                        'SupplierId' => 3,
                        'SupplierName' => 'R003',
                        'SupplierContactInformation' => 'Tel: 01234/56789 E-Mail: test@test.de'
                    )
                )
            );

            include_once('./templates/table.php');
        ?>
    </div>
</div>