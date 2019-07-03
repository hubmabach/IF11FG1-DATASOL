<?php
    /**
     * Diese Datei dient zur Anzeige von Daten in einem Tabellen-Layout.
     * 
     * @param array $tableConfig Konfiguration der Tabelle. Diese Variable sollte vor der Einbindung dieser Datei definiert worden sein.
     * @param array $tableConfig::columns Tabellenspalten die aus den Daten angezeigt werden sollen.
     * @param string $tableConfig::idColumn Name der Spalte die als Identifikator (kurz ID) dient.
     * @param mysqli_result $tableConfig::result Das Ergebnis einer MySQL-Datenbankabfrage.
     * @param string $tableConfig::pageName Der Name der für das PHP-File verwendet wird.
     */

    // $required_keys = array('columns', 'singularName', 'idColumn', 'result');

    // Sollte die Variable $tableConfig nicht existieren, dann gib eine Warnung aus.
    if (!isset($tableConfig)):
        echo ("Variable \$tableConfig ist nicht gesetzt.");
    else:
?>

<div class="clearfix" style="margin-bottom: 20px;">
    <a href="index.php?page=<?php echo $tableConfig['pageName']; ?>&detail=new" class="btn btn-primary float-right"><?php echo $tableConfig['singularName']; ?> erstellen</a>
    <form class="form-inline" method="GET">
        <input type="hidden" name="page" value="<?php echo $_GET['page']; ?>" />
        <div class="input-group">
            <input type="search" name="search" class="form-control" placeholder="Suche..." value="<?php echo @$_GET['search']; ?>" />
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Suchen</button>
            </div>
        </div>
    </form>
</div>
<div class="clearfix">
    <?php if ($tableConfig['result'] and mysqli_num_rows($tableConfig['result']) > 0): ?>
    <table class="table">
        <thead>
            <tr>
                <?php foreach ($tableConfig['columns'] as $label): ?>
                    <th><?php echo $label; ?></th>
                <?php endforeach; ?>
                <th style="width: 1%"></th>
            </tr>
        </thead>
        <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($tableConfig['result']))
            foreach ($tableConfig['result'] as $row):
        ?>
            <tr>
                <?php foreach ($tableConfig['columns'] as $columnName => $label): ?>
                <td><?php echo $row[$columnName]; ?></td>
                <?php endforeach; ?>
                <td style="width: 1%">                
                    <a href="?page=<?php echo $tableConfig['pageName']; ?>&detail=edit&id=<?php echo $row[$tableConfig['idColumn']]; ?>" class="btn btn-sm btn-light">Bearbeiten</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="alert alert-light">Keine Daten vorhanden.</div>
    <?php endif; ?>
</div>
<?php endif; ?>