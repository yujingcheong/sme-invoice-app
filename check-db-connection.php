<?php
// Simple script to test PDO directly to avoid Laravel bootstrap issues
// and check if the database drivers are installed correctly.

$host = getenv('DB_HOST');
$port = getenv('DB_PORT') ?: '5432';
$database = getenv('DB_DATABASE');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');

echo "Attempting to connect to $database on $host:$port as $username...\n";

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$database";
    $pdo = new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    echo "✅ Connected successfully to PostgreSQL!\n";
    
    $result = $pdo->query("SELECT version()")->fetch();
    echo "Server version: " . $result[0] . "\n";
} catch (\PDOException $e) {
    echo "❌ PostgreSQL Connection failed: " . $e->getMessage() . "\n";
}

try {
    $dsn = "sqlite::memory:";
    $pdo = new PDO($dsn);
    echo "✅ Connected successfully to SQLite (memory)!\n";
} catch (\PDOException $e) {
    echo "❌ SQLite Connection failed: " . $e->getMessage() . "\n";
}

echo "\nInstalled PDO drivers:\n";
print_r(PDO::getAvailableDrivers());
