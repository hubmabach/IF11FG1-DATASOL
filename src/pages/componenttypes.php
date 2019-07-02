<?php
    /**
     * Liste aller Komponentenarten
     * 
     * @author Nikolas Bayerschmidt
     */

    $query = "SELECT ComponentTypeID, ComponentTypeName, (SELECT COUNT(AttributeID) FROM componenttypehasattributes WHERE ComponentTypeID = ct.ComponentTypeID) AS ComponentTypeAttrCount FROM componenttypes ct;";

    $result = mysqli_query($dbLink, $query);

    $tableConfig = array(
        'columns' => array(
            'ComponentTypeID' => '#',
            'ComponentTypeName' => 'Bezeichnung',
            'ComponentTypeAttrCount' => 'Anzahl der Attribute',
        ),
        'singularName' => 'Komponentenart',
        'idColumn' => 'ComponentTypeID',
        'pageName' => 'componenttypes',
        'result' => $result
    );
?>

<h1>Stammdaten - Komponentenarten</h1>

<div class="card">
    <div class="card-body">
        <?php include_once('./templates/table.php'); ?>
    </div>
</div>