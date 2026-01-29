<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tables = DB::connection('sqlite')->select("SELECT name, sql FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");

$output = "SET FOREIGN_KEY_CHECKS=0;\n";

foreach ($tables as $table) {
    $tableName = $table->name;
    if ($tableName === 'migrations') continue;

    $output .= "\n-- Structure for table `$tableName` --\n";
    $output .= "DROP TABLE IF EXISTS `$tableName`;\n";
    
    // Simple conversion of SQLite CREATE TABLE to MySQL
    $sql = $table->sql;
    $sql = str_replace('"', '`', $sql);
    $sql = str_replace('autoincrement', 'AUTO_INCREMENT', $sql);
    $sql = str_replace('integer primary key', 'int(11) NOT NULL PRIMARY KEY', $sql);
    $sql = str_replace('datetime', 'timestamp NULL DEFAULT NULL', $sql);
    $sql = str_replace('varchar', 'varchar(255)', $sql);
    $sql = str_replace('text', 'longtext', $sql);
    $sql = str_replace('numeric', 'decimal(15,2)', $sql);
    $sql = str_replace('tinyint(1)', 'tinyint(1)', $sql);
    
    // Fix for multiple spaces or varied naming
    $sql = preg_replace('/PRIMARY KEY AUTO_INCREMENT/i', 'AUTO_INCREMENT PRIMARY KEY', $sql);
    
    $output .= $sql . ";\n";

    $rows = DB::connection('sqlite')->table($tableName)->get();

    if ($rows->count() > 0) {
        $output .= "\n-- Data for table `$tableName` --\n";
        
        foreach ($rows as $row) {
            $vars = get_object_vars($row);
            $keys = array_keys($vars);
            $values = array_values($vars);

            $escapedValues = array_map(function($value) {
                if ($value === null) return 'NULL';
                return "'" . addslashes($value) . "'";
            }, $values);

            $output .= "INSERT INTO `$tableName` (`" . implode('`, `', $keys) . "`) VALUES (" . implode(', ', $escapedValues) . ");\n";
        }
    }
}

$output .= "\nSET FOREIGN_KEY_CHECKS=1;\n";

file_put_contents(__DIR__ . '/mysql_dump.sql', $output);

echo "Export completed with schema: " . __DIR__ . '/mysql_dump.sql';

