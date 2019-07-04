<?php

/**
 * Formular zum Erstellen einer neuen Komponentenart.
 * 
 * Das Besondere an diesem Formular ist die Zuweisung von Komponentenattributen.
 * 
 * @author Nikolas Bayerschmidt
 * Beginn: 03.07.2019 11:45
 * Ende: 03.07.2019 13:26
 */

if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['componenttype_save'])) {

    $queryCheck = "SELECT * FROM componenttypes WHERE ComponentTypeName = '" . $_POST['componenttype_name'] . "';";
    $resultCheck = mysqli_query($dbLink, $queryCheck);

    if (mysqli_num_rows($resultCheck) !== 0) {
        $id = mysqli_fetch_assoc($resultCheck)["ComponentTypeID"];
        echo "<div class='alert alert-danger'>Komponentenattart existiert bereits. <a href='index.php?page=componenttypes&detail=edit&id=$id'>Zur Detailansicht</a></div>";
    } else {
        $query = "INSERT INTO componenttypes (ComponentTypeName, IsSoftware) VALUES ('" . $_POST['componenttype_name'] . "', " . intval(isset($_POST['componenttype_software'])) . ");";
        $result = mysqli_query($dbLink, $query);

        if ($result) {
            $id = mysqli_insert_id($dbLink);
            $attributes = isset($_POST['c_attributes']) ? $_POST['c_attributes'] : array();

            foreach ($attributes as $attributeId) {
                mysqli_query($dbLink, "INSERT INTO componenttypehasattributes (ComponentTypeID, AttributeID) VALUES ($id, $attributeId);");
            }

            echo "<div class='alert alert-success'>Komponentenattart erfolgreich angelegt. <a href='index.php?page=componenttypes&detail=edit&id=$id'>Zur Detailansicht</a></div>";
        }
    }
}
?>

<h1>Stammdaten - Komponentenart - Neuanlage</h1>

<div class="card">
    <div class="card-body" style="background-color:#f8f9fa;">
        <form method="post">
            <div class="form-group row">
                <label class="control-label col-sm-2 text-sm-right">Bezeichnung</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" required value="" name="componenttype_name" />
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-8 offset-sm-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="componenttype_software" name="componenttype_software">
                        <label class="form-check-label" for="componenttype_software">
                            Komponentenart ist eine Software
                        </label>
                    </div>
                </div>
            </div>
            <hr />
            <h4>Komponentenattribute</h4>
            <?php
            $query = "SELECT * FROM componentattributes;";
            $attr_result = mysqli_query($dbLink, $query);
            ?>
            <style>
                label.card.card-selected {
                    background: var(--primary);
                    color: white;
                }
            </style>
            <div class="row">
                <?php while ($attr = mysqli_fetch_assoc($attr_result)) : ?>
                    <div class="col-sm-4">
                        <label class="card">
                            <div class="card-body">
                                <input type="checkbox" name="c_attributes[]" id="c_attributes_<?php echo $attr['AttributeID']; ?>" value="<?php echo $attr['AttributeID']; ?>" />
                                <span><?php echo $attr['AttributeName']; ?></span>
                            </div>
                        </label>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="row">
                <div class="col-sm-5">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Attributbezeichnung" id="add_attribute_inpt">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="add_attribute_btn">Attribut hinzufügen</button>
                        </div>
                        <small id="add_attribute_err" class="form-text text-danger" style="display: none;"></small>
                    </div>
                </div>
            </div>
            <input type="submit" name="componenttype_save" value="Speichern" class="btn btn-success" />
            <a class="btn btn-secondary" href="index.php?page=componenttypes">Abbrechen</a>
        </form>
    </div>
</div>