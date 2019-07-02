<?php
    /**
     * Formular zum Erstellen einer neuen Komponentenart.
     * 
     * Das Besondere an diesem Formular ist die Zuweisung von Komponentenattributen.
     * 
     * @author Nikolas Bayerschmidt
     */

    if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['componenttype_save'])) {
        $query = "INSERT INTO componenttypes (ComponentTypeName, IsSoftware) VALUES ('".$_POST['componenttype_name']."', ".intval(isset($_POST['componenttype_software'])).");";
        $result = mysqli_query($dbLink, $query);

        if ($result) {
            $id = mysqli_insert_id($dbLink);
            $attributes = isset($_POST['c_attributes']) ? $_POST['c_attributes'] : array();

            foreach ($attributes as $attributeId) {
                mysqli_query($dbLink, "INSERT INTO componenttypehasattributes (ComponentTypeID, AttributeID) VALUES ($id, $attributeId);");
            }

            header("Location: ./index.php?page=componenttypes&detail=edit&id=$id");
            die();
        }
    }
?>

<h1>Stammdaten - Komponentenart</h1>

<div class="card">
    <div class="card-body">
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
                <?php while ($attr = mysqli_fetch_assoc($attr_result)): ?>
                <div class="col-sm-4">
                    <label class="card">
                        <div class="card-body">
                            <input type="checkbox" name="c_attributes[]" id="c_attributes_<?php echo $attr['AttributeId']; ?>" value="<?php echo $attr['AttributeId']; ?>" />
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
                    </div>
                </div>
            </div>
            <input type="submit" name="componenttype_save" value="Speichern" class="btn btn-success" />
        </form>
    </div>
</div>
<script>
    window.addEventListener('jQueryLoaded', function(){
        // TODO: Auslagerung in eigene JavaScript Datei
        $('[name="c_attributes[]"]').on('change', function(e) {
            $(e.target).parents('label').toggleClass('card-selected', e.target.checked);
        });

        $('#add_attribute_btn').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            $value = $('#add_attribute_inpt').val();

            if ($value) {
                var fd = new FormData();

                fd.append('attribute_name', $value);

                $.ajax({
                    url: "./ajax_component_attributes.php",
                    data: fd,
                    method: "POST",
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        var item = $('label.card').last().parent().clone();
                        item.find('input').val(data.id);
                        item.find('span').text(data.name);

                        $('label.card').parents('.row').append(item);
                        $('#add_attribute_inpt').val("");
                    },
                    dataType: "json"
                });
            }
        });
    });
</script>