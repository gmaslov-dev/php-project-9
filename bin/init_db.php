#!/usr/bin/env php
<?php

declare(strict_types=1);

use Hexlet\Code\Database\Connection;

require __DIR__ . '/../vendor/autoload.php';

$pdo = Connection::get()->connect();

$sqlFile = __DIR__ . '/../src/Database/database.sql';
$sql = file_get_contents($sqlFile);

if ($sql === false) {
    throw new RuntimeException('Cannot read SQL dump file');
}

try {
    $pdo->exec($sql);
    echo "✅ Database initialized successfully!\n";
} catch (PDOException $e) {
    echo "❌ Error initializing database: " . $e->getMessage() . "\n";
    exit(1);
}
