<?php
  /**
   * Formular zur Erstellung neuer Komponenten.
   *
   * Erstellt eine dynamische Liste von Eingabefeldern je nachdem, welcher Komponententyp ausgewählt wurde.
   *
   * Lädt eine Datei bei Vorhandensein in den Ordner `uploads` hoch.
   *
   * @author Maximilian Bachhuber, Jonas Becker
   * Beginn : 03.07.2019 09.00 : 15:00
   * Ende : 04.07.2019 9.30 : 12.15 
   */
# ErrorHandling
   $valid = true;

# Überprüfung ob die Eingabemethode Post und die Komponentenart gesetzt wurde
   if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['component_save'])) {
     $component_type_id = $_POST['component_type'];
     $component_name = $_POST['component_name'];
     $component_supplier_id = $_POST['component_supplier'];
     $component_purchase = $_POST['component_purchase'];
     $component_warranty = $_POST['component_warranty'];
     $component_vendor_id = $_POST['component_vendor'];
     $component_room_id = $_POST['component_room'];
     $component_receipt = "";
     $component_notes = $_POST['component_notes'];
     $component_attributes = isset($_POST['component_attributes']) ? $_POST['component_attributes'] : array();

# Überprüfungob eine Datei hochgeladen
     if (!empty($_FILES) && isset($_FILES['component_receipt']) && file_exists($_FILES['component_receipt']['tmp_name']) && is_uploaded_file($_FILES['component_receipt']['tmp_name'])) {
# Uploaddiractory
       $upload_dir = __dir__ . "/../uploads/";
# Upload mit eindeutigem Filename versehen
       $filename = basename( substr(hash("md5", time(), FALSE), 0, 5) ."_". $_FILES['component_receipt']['name']);
# Upload in Temporäres Dateiverzeichnis aufnehmen
       if (move_uploaded_file($_FILES['component_receipt']['tmp_name'], $upload_dir . $filename)) {
        $component_receipt = $filename;
       } else {
        echo '<div class="alert alert-danger">Leider tratt bei der Verarbeitung ein Fehler auf, bitte versuchen Sie es später erneut.</div>';
        $valid = false;
       }
     }
# Wenn alles geklappt hat -> Kaufbeleg an Datenbank senden
     if ($valid) {
# Datenbankinsert für die Komponenten
       $query = "INSERT INTO components (ComponentTypeID, ComponentName, SupplierID, ComponentPurchaseDate, ComponentWarranty, ComponentNotes, ComponentVendorID, ComponentReceipt)
        VALUES ($component_type_id, '$component_name', $component_supplier_id, '$component_purchase', '$component_warranty', '$component_notes', $component_vendor_id, '$component_receipt')";
        $result = mysqli_query($dbLink, $query);

        if ($result) {
          $component_id = mysqli_insert_id($dbLink);
# Datenbank insert query für die Räume
          $room_query = "INSERT INTO componentsinroom (ComponentID, RoomID) VALUES ($component_id, $component_room_id);";
          mysqli_query($dbLink, $room_query);
# Erstellen einer Speicher-variable die an die Datenbank via Insert übergeben wird
          foreach($component_attributes as $attribute) {
              if (empty($attribute['value'])) continue;
              $save_query = "INSERT INTO componenthasvalues (ComponentID, AttributeID, AttributeValue) VALUES ($component_id, ".$attribute['id'].", '".$attribute['value']."');";
              mysqli_query($dbLink, $save_query);
          }

# Gebe einen Link für den neu erstellten Komponenten aus via HTML / Komponenten-Detailansicht
          echo "<div class='alert alert-success'>Komponente erfolgreich angelegt. <a href='index.php?page=component&detail=edit&id=$component_id'>Zur Detailansicht</a></div>";

          unset($_POST['component_type']);
        } else {
          echo '<div class="alert alert-danger">Leider tratt bei der Verarbeitung ein Fehler auf, bitte versuchen Sie es später erneut.</div>';
        }
     }
   }
?>

<!-- Gebe Überschrift in HTML aus  -->
<h1>Stammdaten - Komponent neu anlegen</h1>
<!-- Gebe Layout aus -->
<div class="card">
  <div class="card-body">
<!-- Setze Formular -->
    <form method="post" enctype="multipart/form-data">
<!-- Falls der Komponententyp nicht gesetzt wird -->
      <?php if (!isset($_POST["component_type"])): ?>
      <div class="form-group row">
        <label class="control-label col-sm-2 text-sm-right" for="component_type">Komponentenart</label>
        <div class="col-sm-8">
          <select class="browser-default form-control"  id="component_type" name="component_type">
              <option value="" disabled="" selected="" style="display: none;">Wähle die Komponentenart</option>
              <?php
// Hole alle Einträge aus der Tabelle Componenttypes
                $query = "SELECT ComponentTypeName, ComponentTypeID FROM componenttypes";
                $result = mysqli_query($dbLink, $query);
                while ($row = mysqli_fetch_assoc($result)):
              ?>
<!-- Gebe das Ergebnis in einem DropDown-Options-Menü aus -->
              <option value="<?php echo $row['ComponentTypeID'] ?>"><?php echo $row['ComponentTypeName']; ?></option>
              <?php endwhile; ?>
          </select>
        </div>
      </div>
      <input type="submit" class="btn btn-success" name="component_type_choose" value="Auswählen" />
      <a class="btn btn-secondary" href="index.php?page=component">Abbrechen</a>
      <?php else: ?>

<!-- Sollte der Komponententyp jedoch feststehen gebe alle Inputfelder aus -->
      <div class="form-group row">
        <label class="control-label col-sm-2 text-sm-right">Komponentenart</label>
        <div class="col-sm-8">
          <input type="hidden" name="component_type" value="<?php echo $_POST['component_type']; ?>" />
          <?php
            $result = mysqli_query($dbLink, "SELECT ComponentTypeName FROM componenttypes WHERE ComponentTypeID = ".$_POST['component_type']);
            $ct_name = mysqli_fetch_assoc($result)['ComponentTypeName'];
          ?>
          <div class="form-control"><?php echo $ct_name; ?></div>
        </div>
      </div>
      <hr />
      <div class="form-group row">
        <label class="control-label col-sm-2 text-sm-right">Bezeichnung</label>
        <div class="col-sm-8">
          <input placeholder="Bezeichnung" required type="text" value="" id="component_name" name="component_name" class="form-control " >
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-sm-2 text-sm-right">Lieferant</label>
        <div class="col-sm-8">
         <select class="form-control" required id="component_supplier" name="component_supplier">
                <option value="" disabled="" selected="">Auswahl</option>
<!-- Optionen für den Lieferanten aus Datenbank holen und ausgeben -->
                <?php
                $query = "SELECT SupplierID, SupplierCompanyName FROM supplier";
                $result = mysqli_query($dbLink,$query);
                while ($row = mysqli_fetch_assoc($result)): ?>
                <option value="<?php echo $row['SupplierID'] ?>"><?php echo $row['SupplierCompanyName']; ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>
      </div>
<!-- Kaufdatum einstellen -->
      <div class="form-group row">
        <label class="control-label col-sm-2 text-sm-right">Kaufdatum</label>
        <div class="col-sm-8">
        <input type="date" id="component_purchase" name="component_purchase" required class="form-control " placeholder="">
        </div>
      </div>
<!-- Gewährleistung einstellen -->
      <div class="form-group row">
        <label class="control-label col-sm-2 text-sm-right">Gewährleistung bis</label>
        <div class="col-sm-8">
          <input type="date" id="componet_warranty" name="component_warranty" class="form-control " placeholder="Text input">
        </div>
      </div>
      <div class="form-group row">
<!-- Hersteller wählen -->
        <label class="control-label col-sm-2 text-sm-right">Hersteller</label>
        <div class="col-sm-8">
          <select class="form-control" required id="component_vendor" name="component_vendor">
              <option value="" disabled="" selected="">Auswahl</option>
              <?php
              $query = "SELECT VendorID, VendorName FROM vendor";
              $result = mysqli_query($dbLink,$query);
              while ($row = mysqli_fetch_assoc($result)): ?>
              <option value="<?php echo $row['VendorID'] ?>"><?php echo $row['VendorName']; ?>
              </option>
              <?php endwhile; ?>
          </select>
        </div>
      </div>
<!-- Raum wählen -->
      <div class="form-group row">
        <label class="control-label col-sm-2 text-sm-right">Raum</label>
        <div class="col-sm-8">
          <select class="form-control" id="component_room" name="component_room">
              <option value="" disabled="" selected="">Auswahl</option>
              <?php
// Suche alle verfügbaren Räume und gebe sie in einem Optionsfeld aus
              $query = "SELECT RoomID, RoomName FROM rooms";
              $result = mysqli_query($dbLink,$query);
              while ($row = mysqli_fetch_assoc($result)): ?>
              <option value="<?php echo $row['RoomID'] ?>"><?php echo $row['RoomName']; ?>
              </option>
              <?php endwhile; ?>
          </select>
        </div>
      </div>
<!-- Uploadfunktion mit Layout und Labelvergabe  -->
      <style>.custom-file-label:after { content: "Durchsuchen"; }</style>
      <div class="form-group row">
        <label class="control-label col-sm-2 text-sm-right">Kaufbeleg</label>
        <div class="col-sm-8">
          <div class="input-group ">
              <div class="custom-file">
                  <input type="file" class="custom-file-input" id="component_receipt" name="component_receipt" aria-describedby="fileInput">
                  <label class="custom-file-label" for="fileInput">Datei auswählen...</label>
              </div>
          </div>
        </div>
      </div>
<!-- Layout für Notizen die es eventuell zu hinterlegen gilt -->
      <div class="form-group row">
        <label class="control-label col-sm-2 text-sm-right">Notiz</label>
        <div class="col-sm-8">
          <textarea id="textarea" class="form-control" style="min-height: 150px;" placeholder="Textarea" name="component_notes" id="component_notes"></textarea>
        </div>
      </div>
      <hr />
      <?php
// Ausgabe der Attribute und Eigenschaften
        $query = "SELECT a.AttributeID, a.AttributeName FROM componentattributes a LEFT JOIN componenttypehasattributes cta ON cta.AttributeID = a.AttributeID WHERE cta.ComponentTypeID = ".$_POST['component_type'];
        $result = mysqli_query($dbLink, $query);

        $i = 0;
        while ($attribute = mysqli_fetch_assoc($result)): ?>
      <div class="form-group row">
        <label class="control-label col-sm-2 text-sm-right"><?php echo $attribute['AttributeName']; ?></label>
        <div class="col-sm-8">
          <input type="hidden" name="component_attributes[<?php echo $i; ?>][id]" value="<?php echo $attribute['AttributeID']; ?>" />
          <input type="text" name="component_attributes[<?php echo $i++; ?>][value]" placeholder="<?php echo $attribute['AttributeName']; ?>" value="" class="form-control" />
        </div>
      </div>
      <?php endwhile; ?>
<!-- Daten speichern und per Post an den Server übergeben -->
      <input type="submit" class="btn btn-success" name="component_save" value="Speichern" />
      <a class="btn btn-secondary" href="index.php?page=component">Abbrechen</a>
      <?php endif; ?>
    </form>
  </div>
</div>
