<?php
  /**
   * Formular zur Bearbeitung bestehender Komponenten.
   *
   * Die Eingabefelder für die Attribute werden abhängig von der in der Datenbank gespeicherten Komponentenart generiert und mit bestehenden Werten ausgefüllt.
   *
   * Lädt eine Datei bei Vorhandensein in den Ordner `uploads` hoch und ersetzt die in der Datenbank eingetragene Datei.
   *
   * Des Weiteren kann hier eine Kompente ausgemustert werden. Sollte sie ausgemustert worden sein, kann sie wieder eingeführt werden.
   * Die Kompente kann nur gelöscht werden, wenn sie ausgemustert wurde.
   * 
   * @author Nikolas Bayerschmidt
   */

  // Ist keine ID gesetzt, dann leite auf die Übersichtsseite weiter
  if (!isset($_GET['id']) or empty($_GET['id'])) {
    header('Location: ./index.php?page=component');
    die();
  }

  $valid = true;

  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['component_save'])) {
      // Hole alle Werte die aus dem Formular gesendet wurden.
      $component_type_id = $_POST['component_type'];
      $component_room_id = $_POST['component_room'];
      $component_attributes = isset($_POST['component_attributes']) ? $_POST['component_attributes'] : array();

      $saveData = array(
        'ComponentName' => $_POST['component_name'],
        'SupplierID' => $_POST['component_supplier'],
        'ComponentPurchaseDate' => $_POST['component_purchase'],
        'ComponentWarranty' => $_POST['component_warranty'],
        'ComponentNotes' => $_POST['component_notes'],
        'ComponentVendorID' => $_POST['component_vendor'],
        'ComponentReceipt' => $_POST['component_receipt_current']
      );

      // Überprüfe ob eine Datei hochgeladen wurde.
      if (!empty($_FILES) && isset($_FILES['component_receipt']) && file_exists($_FILES['component_receipt']['tmp_name']) && is_uploaded_file($_FILES['component_receipt']['tmp_name'])) {
        $upload_dir = __dir__ . "/../uploads/"; // Ordner zum Speichern der Dateien.

        // Erstelle einen 5 Zeichen langen Hash und füge an diesen den Namen der Datei an.
        $filename = basename( substr(hash("md5", time(), FALSE), 0, 5) ."_". $_FILES['component_receipt']['name']);

        if (move_uploaded_file($_FILES['component_receipt']['tmp_name'], $upload_dir . $filename)) {
          // Wenn eine neue Datei hochgeladen wurde und eine Alte vorhanden ist, dann lösche die alte Datei
          if ($saveData['ComponentReceipt'] !== "") unlink($upload_dir . $saveData['ComponentReceipt']);
          $saveData['ComponentReceipt'] = $filename;
        } else {
          echo '<div class="alert alert-danger">Leider tratt bei der Verarbeitung ein Fehler auf, bitte versuchen Sie es später erneut.</div>';
          $valid = false;
        }
      }
      if ($valid) {
        $query = "UPDATE components SET ".sqlUpdateString($saveData)." WHERE ComponentID = ".$_GET['id'];
        $result = mysqli_query($dbLink, $query);

        if ($result) {
          // Erstelle eine neue Zeile in der Datenbank sollte diese nicht existieren, ansonsten aktualisiere die bereits vorhandene Zeile.
          $room_query = "INSERT INTO componentsinroom (ComponentID, RoomID) VALUES (".$_GET['id'].", $component_room_id) ON DUPLICATE KEY UPDATE RoomID = $component_room_id;";
          mysqli_query($dbLink, $room_query);

          foreach($component_attributes as $attribute) {
            // Erstelle eine neue Zeile in der Datenbank sollte diese nicht existieren, ansonsten aktualisiere die bereits vorhandene Zeile.
            $save_query = "INSERT INTO componenthasvalues (ComponentID, AttributeID, AttributeValue) VALUES (".$_GET['id'].", ".$attribute['id'].", '".$attribute['value']."') ON DUPLICATE KEY UPDATE AttributeValue = '".$attribute['value']."';";
            mysqli_query($dbLink, $save_query);
          }

          echo "<div class='alert alert-success'>Änderungen erfolgreich gespeichert.</div>";
        } else {
          echo '<div class="alert alert-danger">Leider tratt bei der Verarbeitung ein Fehler auf, bitte versuchen Sie es später erneut.</div>';
        }
      }
    } else if (isset($_POST['component_store'])) {
      // Überprüfe ob die Komponente "ausmusterbar" ist.
      $check_query = "SELECT IsInMaintenance FROM components WHERE IsInMaintenance = 0 AND ComponentID = ".$_GET['id'];
      $result = mysqli_query($dbLink, $check_query);

      if (mysqli_num_rows($result) > 0) {
        $change_query = "UPDATE components SET IsInMaintenance = 1 WHERE ComponentID = ".$_GET['id'];
        $result = mysqli_query($dbLink, $change_query);

        if ($result) {
          echo "<div class='alert alert-success'>Komponente wurde erfolgreich ausgemustert.</div>";
        } else {
          echo '<div class="alert alert-danger">Leider tratt bei der Verarbeitung ein Fehler auf, bitte versuchen Sie es später erneut.</div>';
        }
      }
    } else if (isset($_POST['component_delete'])) {
      // Überprüfe ob die Komponente gelöscht werden kann.
      $check_query = "SELECT IsInMaintenance FROM components WHERE IsInMaintenance = 1 AND ComponentID = ".$_GET['id'];
      $result = mysqli_query($dbLink, $check_query);

      if (mysqli_num_rows($result) > 0) {
        $delete_query = "DELETE FROM components WHERE ComponentID = ".$_GET['id'];
        $delete_attributes_query = "DELETE FROM componenthasvalues WHERE ComponentID = ".$_GET['id'];
        $delete_room_query = "DELETE FROM componentsinroom WHERE ComponentID = ".$_GET['id'];

        // Benutze eine MySQL Transaction um bei einem Fehler beim Löschen die Datenbank wieder zurück zu setzen
        mysqli_begin_transaction($dbLink, MYSQLI_TRANS_START_READ_WRITE, "component_delete");
        mysqli_query($dbLink, $delete_attributes_query);
        mysqli_query($dbLink, $delete_room_query);
        mysqli_query($dbLink, $delete_query);
        $result = mysqli_commit($dbLink, 0, "component_delete");

        if ($result) {
          // Leite auf die die Übersichtseite weiter wenn die Komponente erfolgreich gelöscht wurde.
          header("Location: ./index.php?page=component");
          die();
        } else {
          mysqli_rollback($dbLink, 0, "component_delete");
          echo "<div class='alert alert-danger'>Komponente konnte nicht gelöscht werden.</div>";
        }
      }
    } else if (isset($_POST['component_de_store'])) {
      // Überprüfe ob die Komponente wieder eingeführt werden kann.
      $check_query = "SELECT IsInMaintenance FROM components WHERE IsInMaintenance = 1 AND ComponentID = ".$_GET['id'];
      $result = mysqli_query($dbLink, $check_query);

      if (mysqli_num_rows($result) > 0) {
        $change_query = "UPDATE components SET IsInMaintenance = 0 WHERE ComponentID = ".$_GET['id'];
        $result = mysqli_query($dbLink, $change_query);

        if ($result) {
          echo "<div class='alert alert-success'>Komponente wurde erfolgreich wieder eingeführt.</div>";
        } else {
          echo '<div class="alert alert-danger">Leider tratt bei der Verarbeitung ein Fehler auf, bitte versuchen Sie es später erneut.</div>';
        }
      }
    }
  }

  $data_query = "SELECT c.*, cir.RoomID FROM components c LEFT JOIN componentsinroom cir ON c.ComponentID = cir.ComponentID WHERE c.ComponentID = ".$_GET['id'];
  $data_result = mysqli_query($dbLink, $data_query);

  if (mysqli_num_rows($data_result) > 0):

  $data = mysqli_fetch_assoc($data_result);
?>
<h1>Stammdaten - Komponente - <?php echo $data['ComponentName']; ?></h1>
<div class="card">
  <div class="card-body">
    <?php if (boolval($data['IsInMaintenance'])): ?>
    <div class="alert alert-warning">Diese Komponente wurde ausgemustert.</div>
    <?php endif;?>
    <form method="post" enctype="multipart/form-data">
      <div class="form-group row">
        <label class="control-label col-sm-2 text-sm-right">Komponentenart</label>
        <div class="col-sm-8">
          <input type="hidden" name="component_type" value="<?php echo $data['ComponentTypeID']; ?>" />
          <?php
            $result = mysqli_query($dbLink, "SELECT ComponentTypeName FROM componenttypes WHERE ComponentTypeID = ".$data['ComponentTypeID']);
            $ct_name = mysqli_fetch_assoc($result)['ComponentTypeName'];
          ?>
          <div class="form-control"><?php echo $ct_name; ?></div>
        </div>
      </div>
      <hr />
      <div class="form-group row">
        <label class="control-label col-sm-2 text-sm-right">Bezeichnung</label>
        <div class="col-sm-8">
          <input placeholder="Bezeichnung" required type="text" value="<?php echo $data['ComponentName']; ?>" id="component_name" name="component_name" class="form-control " >
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-sm-2 text-sm-right">Lieferant</label>
        <div class="col-sm-8">
         <select class="form-control" required id="component_supplier" name="component_supplier">
                <option value="" disabled="" selected="">Auswahl</option>
                <?php
                $query = "SELECT SupplierID, SupplierCompanyName FROM supplier";
                $result = mysqli_query($dbLink,$query);
                while ($row = mysqli_fetch_assoc($result)): ?>
                <option value="<?php echo $row['SupplierID'] ?>" <?php if ($data['SupplierID'] === $row['SupplierID']) echo "selected"; ?>><?php echo $row['SupplierCompanyName']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-sm-2 text-sm-right">Kaufdatum</label>
        <div class="col-sm-8">
        <input type="date" id="component_purchase" name="component_purchase" value="<?php echo $data['ComponentPurchaseDate']; ?>" required class="form-control " placeholder="">
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-sm-2 text-sm-right">Gewährleistung bis</label>
        <div class="col-sm-8">
          <input type="date" id="componet_warranty" name="component_warranty" value="<?php echo $data['ComponentWarranty']; ?>" class="form-control">
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-sm-2 text-sm-right">Hersteller</label>
        <div class="col-sm-8">
          <select class="form-control" required id="component_vendor" name="component_vendor">
              <option value="" disabled="" selected="">Auswahl</option>
              <?php
              $query = "SELECT VendorID, VendorName FROM vendor";
              $result = mysqli_query($dbLink,$query);
              while ($row = mysqli_fetch_assoc($result)): ?>
              <option value="<?php echo $row['VendorID'] ?>" <?php if ($data['ComponentVendorID'] === $row['VendorID']) echo "selected"; ?>><?php echo $row['VendorName']; ?></option>
              <?php endwhile; ?>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-sm-2 text-sm-right">Raum <?php if ($data['IsInMaintenance']): ?> vor der Ausmusterung<?php endif; ?></label>
        <div class="col-sm-8">
          <select class="form-control" id="component_room" name="component_room" <?php if ($data['IsInMaintenance']) echo "disabled"; ?>>
              <option value="" disabled="" selected="">Kein Raum ausgewählt</option>
              <?php
              $query = "SELECT RoomID, RoomName FROM rooms";
              $result = mysqli_query($dbLink,$query);
              while ($row = mysqli_fetch_assoc($result)): ?>
              <option value="<?php echo $row['RoomID'] ?>" <?php if ($data['RoomID'] === $row['RoomID']) echo "selected"; ?>><?php echo $row['RoomName']; ?></option>
              <?php endwhile; ?>
          </select>
        </div>
      </div>
      <style>.custom-file-label:after { content: "Durchsuchen"; }</style>
      <div class="form-group row">
        <label class="control-label col-sm-2 text-sm-right">Kaufbeleg</label>
        <div class="col-sm-8">
          <?php if ($data['ComponentReceipt']): ?><a class="btn btn-light mb-2" href="./uploads/<?php echo $data['ComponentReceipt']; ?>" target="_blank" ><?php echo $data['ComponentReceipt']; ?></a><?php endif; ?>
          <div class="input-group">
              <div class="custom-file">
                  <input type="hidden" name="component_receipt_current" value="<?php echo $data['ComponentReceipt']; ?>" />
                  <input type="file" class="custom-file-input" id="component_receipt" name="component_receipt" aria-describedby="fileInput">
                  <label class="custom-file-label" for="fileInput">Datei auswählen...</label>
              </div>
          </div>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-sm-2 text-sm-right">Notiz</label>
        <div class="col-sm-8">
          <textarea id="textarea" class="form-control" style="min-height: 150px;" placeholder="Textarea" name="component_notes" id="component_notes"><?php echo $data['ComponentNotes']; ?></textarea>
        </div>
      </div>
      <hr />
      <?php
        // Hole alle zugewiesenen Attribute der Komponentenart und vorhanden Werte der Komponente
        $query = "SELECT a.AttributeID, a.AttributeName, (SELECT chv.AttributeValue FROM componenthasvalues chv WHERE chv.AttributeID = a.AttributeID AND chv.ComponentID = ".$_GET['id'].") AS AttributeValue
        FROM componentattributes a
        LEFT JOIN componenttypehasattributes cta ON cta.AttributeID = a.AttributeID
        WHERE cta.ComponentTypeID = ".$data['ComponentTypeID'].";";
        $result = mysqli_query($dbLink, $query);

        $i = 0;
        while ($attribute = mysqli_fetch_assoc($result)): ?>
      <div class="form-group row">
        <label class="control-label col-sm-2 text-sm-right"><?php echo $attribute['AttributeName']; ?></label>
        <div class="col-sm-8">
          <input type="hidden" name="component_attributes[<?php echo $i; ?>][id]" value="<?php echo $attribute['AttributeID']; ?>" />
          <input type="text" name="component_attributes[<?php echo $i++; ?>][value]" value="<?php echo $attribute['AttributeValue']; ?>" class="form-control" />
        </div>
      </div>
      <?php endwhile; ?>
      <input type="submit" class="btn btn-success" name="component_save" value="Speichern" />
      <?php if (!boolval($data['IsInMaintenance'])): ?><input type="submit" class="btn btn-warning" name="component_store" value="Ausmustern" /><?php endif; ?>
      <?php if (boolval($data['IsInMaintenance'])): ?><input type="submit" class="btn btn-warning" name="component_de_store" value="Wieder Einführen" /><?php endif; ?>
      <?php if (boolval($data['IsInMaintenance'])): ?><input type="submit" class="btn btn-danger" name="component_delete" value="Löschen" /><?php endif; ?>
      <a class="btn btn-secondary" href="index.php?page=component">Abbrechen</a>
    </form>
  </div>
</div>
<?php else: // Sollte die gesuchte Komponente nicht existieren ?>
<h3 class="text-danger">Die angeforderte Komponente wurde leider nicht gefunden.</h3>
<p>Vielleicht wurde sie durch einen anderen Nutzer gelöscht.</p>
<a class="btn btn-secondary" href="index.php?page=component">Zur Übersicht</a>
<?php endif; ?>