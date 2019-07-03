/**
 * Unterstützende JavaScript Funktionen für die Erstellung von Kompontenattributen
 * 
 * @author Nikolas Bayerschmidt
 */

(function() {
    $('[name="c_attributes[]"]').on('change', function(e) {
        $(e.target).parents('label').toggleClass('card-selected', e.target.checked);
    });

    $('#add_attribute_btn').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var errorElem = $('#add_attribute_err'),
            inputElem = $('#add_attribute_inpt');
        
        $value = inputElem.val();
        errorElem.hide();

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
                    inputElem.val("");
                },
                error: function(jqXHR) {
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
