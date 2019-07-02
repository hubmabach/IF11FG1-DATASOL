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
                // Status-Code 400 `BAD REQUEST`
                http_response_code(400);
            }
        } else {
            // Status-Code 400 `BAD REQUEST`
            http_response_code(400);
        }
    } else {
        // Status-Code 400 `BAD REQUEST`
        http_response_code(400);
    }
?>