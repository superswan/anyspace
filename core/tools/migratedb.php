<?php
// mostly devtool for when db structure changes

$devHost = '';
$devDbName = '';
$devUsername = '';
$devPassword = '';

$prodHost = '';
$prodDbName = '';
$prodUsername = '';
$prodPassword = '';

try {
    $devDsn = "mysql:host=$devHost;dbname=$devDbName;charset=utf8";
    $prodDsn = "mysql:host=$prodHost;dbname=$prodDbName;charset=utf8";
    $devDb = new PDO($devDsn, $devUsername, $devPassword);
    $prodDb = new PDO($prodDsn, $prodUsername, $prodPassword);

    $devDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $prodDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}


function getDatabaseStructure(PDO $db) {
    $structure = array();
    foreach ($db->query("SHOW TABLES") as $row) {
        $tableName = $row[0];
        $structure[$tableName] = array();
        foreach ($db->query("SHOW COLUMNS FROM `$tableName`") as $column) {
            $structure[$tableName][] = $column['Field'];
        }
    }
    return $structure;
}

function updateProductionStructure(PDO $devDb, PDO $prodDb) {
    $devStructure = getDatabaseStructure($devDb);
    $prodStructure = getDatabaseStructure($prodDb);

    foreach ($devStructure as $tableName => $columns) {
        if (!array_key_exists($tableName, $prodStructure)) {
            $stmt = $devDb->query("SHOW CREATE TABLE `$tableName`");
            $createTableSql = $stmt->fetch(PDO::FETCH_ASSOC);
            $prodDb->exec($createTableSql['Create Table']);
            echo "Table $tableName created in production database.\n";
        } else {
            foreach ($columns as $columnName) {
                if (!in_array($columnName, $prodStructure[$tableName])) {
                    $stmt = $devDb->query("SHOW COLUMNS FROM `$tableName` LIKE '$columnName'");
                    $columnDef = $stmt->fetch(PDO::FETCH_ASSOC);
                    $alterTableSql = "ALTER TABLE `$tableName` ADD COLUMN `$columnName` {$columnDef['Type']}" .
                                     (!is_null($columnDef['Default']) ? " DEFAULT '{$columnDef['Default']}'" : "") .
                                     ($columnDef['Null'] === "NO" ? " NOT NULL" : "") .
                                     (!empty($columnDef['Extra']) ? " {$columnDef['Extra']}" : "");
                    $prodDb->exec($alterTableSql);
                    echo "Column $columnName added to table $tableName in production database.\n";
                }
            }
        }
    }
}

updateProductionStructure($devDb, $prodDb);
