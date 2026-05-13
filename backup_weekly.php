<?php

$db_host     = 'localhost';
$db_user     = 'root';    
$db_pass     = '';           
$db_name     = 'flexfitpro';     

// --- XAMPP PATHS ---
$mysqldump   = '"C:\\xampp\\mysql\\bin\\mysqldump.exe"';

// --- BACKUP FOLDER ---
$backup_dir  = __DIR__ . '\\backups\\';

// --- BACKUP FILE NAME ---
// Includes today's date so a new file is created each week
// Example: backup_weekly_2025-06-01.sql
$today       = date('Y-m-d');
$backup_file = $backup_dir . "backup_weekly_{$today}.sql";

if (!is_dir($backup_dir)) {
    mkdir($backup_dir, 0777, true);
    echo "Created backups folder.\n";
}

if ($db_pass === '') {
    $command = "$mysqldump -u $db_user $db_name > \"$backup_file\" 2>&1";
} else {
    $command = "$mysqldump -u $db_user -p$db_pass $db_name > \"$backup_file\" 2>&1";
}

echo "Starting weekly backup...\n";
echo "Database  : $db_name\n";
echo "Save to   : $backup_file\n";
echo "Time      : " . date('Y-m-d H:i:s') . "\n";
echo "-------------------------------------------\n";

$output = shell_exec($command);

if (file_exists($backup_file) && filesize($backup_file) > 0) {
    $size_kb = round(filesize($backup_file) / 1024, 2);
    echo "SUCCESS! Weekly backup created.\n";
    echo "File size : {$size_kb} KB\n";

    // Optional: List all weekly backups so far
    echo "\nAll weekly backups in folder:\n";
    $files = glob($backup_dir . 'backup_weekly_*.sql');
    if ($files) {
        foreach ($files as $file) {
            $name    = basename($file);
            $size    = round(filesize($file) / 1024, 2);
            $created = date('Y-m-d H:i', filemtime($file));
            echo "  - $name ({$size} KB, saved $created)\n";
        }
    }
} else {
    echo "ERROR: Backup failed!\n";
    echo "Command output: $output\n";
}

echo "Done.\n";
