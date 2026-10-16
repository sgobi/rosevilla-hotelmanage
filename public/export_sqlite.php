<?php
// Place this file at: public/export_sqlite.php

$sqlitePath = __DIR__ . '/../database/database.sqlite';

if (!file_exists($sqlitePath)) {
    die("SQLite database file not found at: " . $sqlitePath);
}

try {
    $pdo = new PDO("sqlite:" . $sqlitePath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// ONLY the 3 tables needed for Gallery, Testimonials, and Landmarks
$tables = [
    'gallery_images', // Gallery / Glimpses of Rose Villa
    'reviews',        // Testimonials / Guest Stories
    'landmarks'       // Explore / Nearest Places
];

header('Content-Type: text/plain; charset=utf-8');
header('Content-Disposition: attachment; filename="sections_only_export.sql"');

echo "-- Targeted Export: Gallery, Reviews, and Landmarks ONLY\n";
echo "SET FOREIGN_KEY_CHECKS = 0;\n\n";

foreach ($tables as $table) {
    try {
        $stmt = $pdo->query("SELECT * FROM `{$table}`");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($rows)) {
            echo "-- Table `{$table}` has no records. Skipping...\n\n";
            continue;
        }

        echo "-- Exporting data for table `{$table}` (" . count($rows) . " rows)\n";

        foreach ($rows as $row) {
            $columns = array_map(fn($col) => "`{$col}`", array_keys($row));
            $values = array_map(function ($val) use ($pdo) {
                if ($val === null)
                    return 'NULL';
                return $pdo->quote($val);
            }, array_values($row));

            // REPLACE INTO updates existing IDs or inserts new ones safely
            echo "REPLACE INTO `{$table}` (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $values) . ");\n";
        }
        echo "\n";
    } catch (Exception $e) {
        echo "-- Failed to export `{$table}`: " . $e->getMessage() . "\n\n";
    }
}

echo "SET FOREIGN_KEY_CHECKS = 1;\n";
exit;
?>