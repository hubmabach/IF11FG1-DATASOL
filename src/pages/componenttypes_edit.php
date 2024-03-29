<?php

/**
 * Formular zum Bearbeiten der Komponentenarten.
 * 
 * Das Besondere an diesem Formular ist die Zuweisung von Komponentenattributen.
 * 
 * @author Nikolas Bayerschmidt
 * Beginn: 03.07.2019 11:45
 * Ende: 03.07.2019 13:26
 */


if (!isset($_GET['id']) or empty($_GET['id'])) {
    header("Location: ./index.php?page=componenttypes");
    die();
}

$valid = true;
$id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['componenttype_save'])) {

        if ($valid) {
            $query = "UPDATE componenttypes SET ComponentTypeName = '" . $_POST['componenttype_name'] . "', IsSoftware = " . intval(isset($_POST['componenttype_software'])) . " WHERE ComponentTypeID = $id";
            $result = mysqli_query($dbLink, $query);

            if ($result === false) { } else {
                // Hole die bereits ausgewählten Komponentenattribute aus der Datenbank.
                $selected_query = "SELECT AttributeID FROM componenttypehasattributes WHERE ComponentTypeID = $id";
                $selected_result = mysqli_query($dbLink, $selected_query);
                $selected_ids = mysqli_od_array($selected_result, 'AttributeID');

                $attributes = isset($_POST['c_attributes']) ? $_POST['c_attributes'] : array();

                // Überprüfe welche IDs neu hinzugefügt wurden.
                $attributes_to_add = array_diff($attributes, $selected_ids);

                // Überprüfe welche IDs abgewählt wurden und deren Beziehung gelöscht gehört.
                $attributes_to_delete = array_diff($selected_ids, $attributes);

                foreach ($attributes_to_delete as $attributeId) {
                    mysqli_query($dbLink, "DELETE FROM componenttypehasattributes WHERE AttributeID = $attributeId AND ComponentTypeID = $id;");
                }

                foreach ($attributes_to_add as $attributeId) {
                    mysqli_query($dbLink, "INSERT INTO componenttypehasattributes (ComponentTypeID, AttributeID) VALUES ($id, $attributeId);");
                }

                echo "<div class='alert alert-success'>Änderungen erfolgreich gespeichert.</div>";
            }
        }
    } else if (isset($_POST['componenttype_delete'])) {
        $delete_attributes_query = "DELETE FROM componenttypehasattributes WHERE ComponentTypeID = $id;";
        $delete_query = "DELETE FROM componenttypes WHERE ComponentTypeID = $id;";

        // Lösche zuerst alle Beziehungen zu Attributen die der Komponentenart zugewiesen wurden.
        $attributes_result = mysqli_query($dbLink, $delete_attributes_query);
        if ($attributes_result) {
            // Lösche die Komponentenart
            $result = mysqli_query($dbLink, $delete_query);

            if ($result) {
                header('Location: ./index.php?page=componenttypes');
                die();
            }
        }
    }
}

$query = "SELECT * FROM componenttypes WHERE ComponentTypeID = $id;";

$result = mysqli_query($dbLink, $query);

$data = mysqli_fetch_assoc($result);

if (mysqli_num_rows($result) === 0) : ?>

    <h3 class="text-danger">Die angeforderte Komponentenart wurde leider nicht gefunden.</h3>
    <p>Vielleicht wurde sie durch einen anderen Nutzer gelöscht.</p>
    <a class="btn btn-secondary" href="index.php?page=componenttypes">Zur Übersicht</a>

<?php
endif;
if (mysqli_num_rows($result) !== 0) :
    ?>

    <h1>Stammdaten - Komponentenart - <?php echo $data['ComponentTypeName']; ?></h1>

    <div class="card">
        <div class="card-body" style="background-color:#f8f9fa;">
            <form method="post">
                <div class="form-group row">
                    <label class="control-label col-sm-2 text-sm-right">Bezeichnung</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" required value="<?php echo $data['ComponentTypeName']; ?>" name="componenttype_name" />
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-8 offset-sm-2">
                        <div class="form-check">
                            <input class="form-check-input" <?php if (boolval($data['IsSoftware'])) : ?>checked<?php endif; ?> type="checkbox" value="1" id="componenttype_software" name="componenttype_software">
                            <label class="form-check-label" for="componenttype_software">
                                Komponentenart ist eine Software
                            </label>
                        </div>
                    </div>
                </div>
                <hr />
                <h4>Komponentenattribute</h4>
                <?php
                $selected_query = "SELECT AttributeID FROM componenttypehasattributes WHERE ComponentTypeID = $id";
                $selected_result = mysqli_query($dbLink, $selected_query);
                $selected_ids = mysqli_od_array($selected_result, 'AttributeID');

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
                            <label class="card <?php if (in_array($attr['AttributeID'], $selected_ids)) echo "card-selected"; ?>">
                                <div class="card-body">
                                    <input type="checkbox" name="c_attributes[]" id="c_attributes_<?php echo $attr['AttributeID']; ?>" <?php if (in_array($attr['AttributeID'], $selected_ids)) echo "checked"; ?> value="<?php echo $attr['AttributeID']; ?>" />
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
                <?php if (isset($_GET['id'])) : ?>
                    <input type="submit" name="componenttype_delete" value="Löschen" class="btn btn-danger" />
                <?php endif; ?>
                <a class="btn btn-secondary" href="index.php?page=componenttypes">Abbrechen</a>
            </form>
        </div>
    </div>
<?php endif; ?>