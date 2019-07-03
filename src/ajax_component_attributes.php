<?php
    /**
     * Erstellt ein neues Komponentenattribut basierend auf einer Bezeichnung durch eine asynchrone JavaScript-Anfrage.
     * 
     * @author Nikolas Bayerschmidt
     */

    require('./includes/global.php');

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['attribute_name']) and !empty($_POST['attribute_name'])) {
            $attribute_name = $_POST['attribute_name'];

            // Überprüfe ob Attribut mit dieser Bezeichnung bereits existiert.
            $check_query = "SELECT AttributeID FROM componentattributes WHERE AttributeName = '$attribute_name';";
            $check_result = mysqli_query($dbLink, $check_query);

            if (mysqli_num_rows($check_result) == 0) {
                $query = "INSERT INTO componentattributes (AttributeName) VALUES ('$attribute_name');";
                $result = mysqli_query($dbLink, $query);

                if ($result) {
                    // Status-Code 201 `CREATED`
                    http_response_code(201);
                    // Rückgabe der erstellten Werte als JavaScript-Object-Notation (JSON)
                    echo json_encode(array(
                        'id' => mysqli_insert_id($dbLink),
                        'name' => $attribute_name
                    ));
                } else {
                    // Status-Code 500 `INTERNAL SERVER ERROR`
                    http_response_code(500);
                    // Rückgabe einer lesbaren Fehlernachricht
                    echo json_encode(array( 'error' => "Es ist ein Fehler beim Erstellen des Attributs aufgetreten." ));
                }
            } else {
                // Status-Code 400 `BAD REQUEST`
                http_response_code(400);
                // Rückgabe einer lesbaren Fehlernachricht
                echo json_encode(array( 'error' => "Attribut mit dieser Bezeichnung existiert bereits." ));
            }
        } else {
            // Status-Code 400 `BAD REQUEST`
            http_response_code(400);
            // Rückgabe einer lesbaren Fehlernachricht
            echo json_encode(array( 'error' => "Es wird eine Bezeichnung zum Erstellen eines Attributs benötigt." ));
        }
    } else {
        // Status-Code 400 `BAD REQUEST`
        http_response_code(405);
    }
?>