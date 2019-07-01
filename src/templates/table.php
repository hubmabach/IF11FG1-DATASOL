<?php
    /**
     * Diese Datei dient zur Anzeige von Daten in einem Tabellen-Layout.
     * 
     * @param tableConfig Konfiguration der Tabelle. Diese Variable sollte vor der Einbindung dieser Datei definiert worden sein.
     * @param tableConfig::columns Tabellenspalten die aus den Daten angezeigt werden sollen.
     * @param tableConfig::idColumn Name der Spalte die als Identifikator (kurz ID) dient.
     * @param tableConfig::result Das Ergebnis einer MySQL-Datenbankabfrage.
     */

    // $required_keys = array('columns', 'singularName', 'idColumn', 'data', 'result');

    // Sollte die Variable $tableConfig nicht existieren, dann gib eine Warnung aus.
    if (!isset($tableConfig)):
        echo ("Variable \$tableConfig ist nicht gesetzt.");
    else:
?>

<div class="clearfix" style="margin-bottom: 20px;">
    <a href="#" class="btn btn-primary float-right"><?php echo $tableConfig['singularName']; ?> erstellen</a>
    <form class="form-inline">
        <div class="input-group">
            <input type="search" name="search" class="form-control" placeholder="Suche..." />
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="button-addon2">Suchen</button>
            </div>
        </div>
    </form>
</div>
<div class="clearfix">
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
        <?php //while ($row = mysqli_fetch_assoc($tableConfig['result'])):
            foreach ($tableConfig['data'] as $row):
        ?>
            <tr>
                <?php foreach ($tableConfig['columns'] as $columnName => $label): ?>
                <td><?php echo $row[$columnName]; ?></td>
                <?php endforeach; ?>
                <td style="width: 1%">
                    <a href="?page=komponentenart&id=<?php echo $row[$tableConfig['idColumn']]; ?>" class="btn btn-sm btn-light">Bearbeiten</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <!-- <div class="btn-group">
        <a class="btn btn-default btn-outline-light">Vorherige Seite</a>
        <a class="btn btn-default btn-outline-light">1</a>
        <a class="btn btn-default btn-outline-light">2</a>
        <a class="btn btn-default btn-outline-light">3</a>
        <a class="btn btn-default btn-outline-light">Nächste Seite</a>
    </div> -->
</div>
<?php endif; ?>