/**
 * Hilfsfunktionen für den Datei-Upload.
 *  
 * @author Nikolas Bayerschmidt
 */

(function(){
    // Führe folgende Funktion jedes mal aus, wenn sich ein Datei-Input verändert.
    $('input[type=file].custom-file-input').on('change', function(e){
        var files = e.target.files,
            displayText = "";
        
        // Sollten keine Dateien ausgewählt worden sein, dann zeige den normalen Text an.
        if (files.length === 0) {
            $(this).parent().find('label.custom-file-label').text("Datei auswählen...");
            return;
        }

        // Hole alle namen der ausgewählten Dateien und packe diese in einen String.
        for (var i = 0; i < files.length; i++) {
            displayText += files[i].name;

            if (i < files.length - 1) displayText += ", ";
        }

        // Gebe den String mit den Dateinamen aus.
        $(this).parent().find('label.custom-file-label').text(displayText);
    });
})();