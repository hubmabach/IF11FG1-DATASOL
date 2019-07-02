    
<?php 
    /**
     * Anzeige und Verwaltung der Account für die Software
     * Hinzufügen und Anpassen der Anwender-Daten
     */
    
    ?>    

<h1>Accountverwaltung</h1>
  
    <div class="card">
        <div class="card-body">
            
        <?php
    $tableConfig = array(
        'columns' => array(
            'UserId' => '#',
            'UserName' => 'Benutzername',
            'UserFirstname' => 'Vorname',
            'UserLastname' => 'Nachname',
            'UserEmail' => 'E-mail',
            'isAdmin' => 'Systembetreuer'
        ),
        'pageName' => 'users',
        'idColumn' => 'UserId',
        'result' => array(
            array(
            'UserId' => '1',
            'UserName' => 'Hänno',
            'UserFirstname' => 'Max',
            'UserLastname' => 'Whoknows',
            'UserEmail' => 'test@mail.de',
            // todo: need checkbox to display true false value
            'isAdmin' => 'true',
            ),
            array(
            'UserId' => '2',
           'UserName' => 'Zimbel',
           'UserFirstname' => 'Zedrik',
           'UserLastname' => 'Ombey',
           'UserEmail' => '',
           'isAdmin' => 'false',
           ),
           
        ),
        'singularName' => 'Anwender',

    );

    include_once('./templates/table.php');
?> 


    </div>
</div>



