<?php
  /**
   * Formular zur Erstellung neuer Komponenten.
   *
   * Erstellt eine dynamische Liste von Eingabefeldern je nachdem, welcher Komponententyp ausgewählt wurde.
   *
   * Lädt eine Datei bei Vorhandensein in den Ordner `uploads` hoch.
   *
   * @author Maximilian Bachhuber, Jonas Becker
   */

  if (!isset($_GET['id']) or empty($_GET['id'])) {
    header('Location: ./index.php?page=component');
    die();
  }

  $valid = true;

  // if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['component_save'])) {
  //   $component_type_id = $_POST['component_type'];
  //   $component_name = $_POST['component_name'];
  //   $component_supplier_id = $_POST['component_supplier'];
  //   $component_purchase = $_POST['component_purchase'];
  //   $component_warranty = $_POST['component_warranty'];
  //   $component_vendor_id = $_POST['component_vendor'];
  //   $component_room_id = $_POST['component_room'];
  //   $component_receipt = (empty($_FILES) or !isset($_FILES['component_receipt'])) ? "" : $_FILES['component_receipt'];
  //   $component_notes = $_POST['component_notes'];
  //   $component_attributes = $_POST['component_attributes'];

  //   if ($component_receipt !== "" && file_exists($component_receipt['tmp_name']) && is_uploaded_file($component_receipt['tmp_name'])) {
  //     $upload_dir = __dir__ . "/../uploads/";
  //     $filename = basename( substr(hash("md5", time(), FALSE), 0, 5) ."_". $component_receipt['name']);

  //     if (move_uploaded_file($component_receipt['tmp_name'], $upload_dir . $filename)) {
  //       $component_receipt = $filename;
  //     } else {
  //       // FIXME: Fehler
  //       $valid = false;
  //     }
  //   }
  //   if ($valid) {
  //     $query = "INSERT INTO components (ComponentTypeID, ComponentName, SupplierID, ComponentPurchaseDate, ComponentWarranty, ComponentNotes, ComponentVendorID, ComponentReceipt)
  //     VALUES ($component_type_id, '$component_name', $component_supplier_id, '$component_purchase', '$component_warranty', '$component_notes', $component_vendor_id, '$component_receipt')";
  //     $result = mysqli_query($dbLink, $query);

  //     if ($result) {
  //       $component_id = mysqli_insert_id($dbLink);

  //       $room_query = "INSERT INTO componentsinroom (ComponentID, RoomID) VALUES ($component_id, $component_room_id);";
  //       mysqli_query($dbLink, $room_query);

  //       foreach($component_attributes as $attribute) {
  //           if (empty($attribute['value'])) continue;
  //           $save_query = "INSERT INTO componenthasvalues (ComponentID, AttributeID, AttributeValue) VALUES ($component_id, ".$attribute['id'].", '".$attribute['value']."');";
  //           mysqli_query($dbLink, $save_query);
  //       }

  //       // TODO: Nachricht bei Erfolg mit Link zur Komponente

  //       unset($_POST['component_type']);
  //     } else {
  //       echo mysqli_error($dbLink);
  //     }
  //   }
  // }

  $data_query = "SELECT c.*, cir.RoomID FROM components c LEFT JOIN componentsinroom cir ON c.ComponentID = cir.ComponentID WHERE c.ComponentID = ".$_GET['id'];

  $data_result = mysqli_query($dbLink, $data_query);

  if (mysqli_num_rows($data_result) > 0):

  $data = mysqli_fetch_assoc($data_result);
?>
<h1>Stammdaten - Komponente - <?php echo $data['ComponentName']; ?></h1>
<div class="card">
  <div class="card-body">
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
        <label class="control-label col-sm-2 text-sm-right">Gewährleistungs<wbr />dauer </label>
        <div class="col-sm-8">
          <input type="text" id="componet_warranty" name="component_warranty" value="<?php echo $data['ComponentWarranty']; ?>" class="form-control " placeholder="Text input">
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
        <label class="control-label col-sm-2 text-sm-right">Raum</label>
        <div class="col-sm-8">
          <select class="form-control" id="component_room" name="component_room">
              <option value="" disabled="" selected="">Auswahl</option>
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
          <div class="input-group ">
              <div class="custom-file">
                  <input type="file" class="custom-file-input" id="component_receipt" name="component_receipt" aria-describedby="fileInput">
                  <label class="custom-file-label" for="fileInput">
                    <?php if ($data['ComponentReceipt']): ?>
                    <a href="./uploads/<?php echo $data['ComponentReceipt']; ?>" target="_blank" ><?php echo $data['ComponentReceipt']; ?></a>
                    <?php else: ?>Datei auswählen...<?php endif; ?>
                  </label>
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
        $query = "SELECT DISTINCT a.AttributeID, a.AttributeName, chv.AttributeValue FROM componentattributes a LEFT JOIN componenttypehasattributes cta ON cta.AttributeID = a.AttributeID LEFT JOIN componenthasvalues chv ON chv.AttributeID = a.AttributeID WHERE chv.ComponentID = ".$data['ComponentID'];
        $result = mysqli_query($dbLink, $query);

        $i = 0;
        while ($attribute = mysqli_fetch_assoc($result)): ?>
      <div class="form-group row">
        <label class="control-label col-sm-2 text-sm-right"><?php echo $attribute['AttributeName']; ?></label>
        <div class="col-sm-8">
          <input type="hidden" name="component_attributes[<?php echo $i; ?>][id]" value="<?php echo $attribute['AttributeID']; ?>" />
          <input type="text" name="component_attributes[<?php echo $i++; ?>][value]" placeholder="<?php echo $attribute['AttributeName']; ?>" value="<?php echo $attribute['AttributeValue']; ?>" class="form-control" />
        </div>
      </div>
      <?php endwhile; ?>
      <input type="submit" class="btn btn-success" name="component_save" value="Speichern" />
      <input type="submit" class="btn btn-warning" name="component_store" value="Ausmustern" />
      <input type="submit" class="btn btn-danger" name="component_delete" value="Löschen" />
    </form>
  </div>
</div>
<?php else: ?>
<h3 class="text-danger">Die angeforderte Komponente wurde leider nicht gefunden.</h3>
<p>Vielleicht wurde sie durch einen anderen Nutzer gelöscht.</p>
<a class="btn btn-secondary" href="index.php?page=component">Zur Übersicht</a>
<?php endif; ?>