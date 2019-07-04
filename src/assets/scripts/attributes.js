/**
 * Unterstützende JavaScript Funktionen für die Erstellung von Kompontenattributen
 * 
 * @author Nikolas Bayerschmidt
 */

(function() {
    $('.container form').on('change', "input[name='c_attributes[]']", function(e) {
        $(e.target).parents('label').toggleClass('card-selected', e.target.checked);
    });

    // Führe folgende Funktion jedes mal aus, wenn der "Attribute hinzufügen" Button gedrückt wurde.
    $('#add_attribute_btn').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var errorElem = $('#add_attribute_err'),
            inputElem = $('#add_attribute_inpt');
        
        $value = inputElem.val();
        errorElem.hide();

        // Sollte eine Text eingegeben worden sein, dann setze die Funktion fort.
        if ($value) {
            // FormData gleicht dem Objekt welches erstellt wird, wenn ein normales Formular abgesendet wird.
            var fd = new FormData();

            // Füge den eingegebenen Text zur FormData hinzu.
            fd.append('attribute_name', $value);

            // Sende eine HTTP-Anfrage über JavaScript an die angegebene URL mit FormData
            $.ajax({
                url: "./ajax_component_attributes.php",
                data: fd,
                method: "POST",
                contentType: false,
                processData: false,
                success: function(data) {
                    // Sollte der Server einen Erfolg (HTTP-Status-Code 201) zurückgeben

                    // Erstelle das Auswahlelement und setze alle benötigten Attribute und Werte
                    var item =$('<div class="col-sm-4">\
                            <label class="card ">\
                                <div class="card-body">\
                                    <input type="checkbox" name="c_attributes[]" id="" value="">\
                                    <span></span>\
                                </div>\
                            </label>\
                        </div>');
                    item.find('input').val(data.id);
                    item.find('input').attr('id', 'c_attributes_' + data.id)
                    item.find('span').text(data.name);

                    // Füge das Auswahlelement zum Dokument hinzu.
                    $('label.card').parents('.row').append(item);

                    // Setze das Textfeld zurück
                    inputElem.val("");
                },
                error: function(jqXHR) {
                    // Sollte der Server einen Fehler melden (HTTP-Status-Code 400 oder 500)
                    if (jqXHR.responseText) {
                        var errorText = jQuery.parseJSON(jqXHR.responseText).error;
                        var errorElem = $('#add_attribute_err');
                        errorElem.text(errorText);
                        errorElem.show();
                    }

                    inputElem.val("");
                },
                dataType: "json"
            });
        }
    });
})();
