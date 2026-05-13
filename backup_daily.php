<?php
// ============================================================
//  GYM MANAGEMENT SYSTEM - Daily Backup Script
//  Saves to: backups/backup_daily.sql (overwrites every day)
//  Run manually: php backup_daily.php
//  Or schedule with Windows Task Scheduler
// ============================================================

$db_host     = 'localhost';
$db_user     = 'root';      
$db_pass     = '';           
$db_name     = 'flexfitpro';      

$mysqldump   = '"C:\\xampp\\mysql\\bin\\mysqldump.exe"';

$backup_dir  = __DIR__ . '\\backups\\';

$backup_file = $backup_dir . 'backup_daily.sql';

if (!is_dir($backup_dir)) {
    mkdir($backup_dir, 0777, true);
    echo "Created backups folder.\n";
}

if ($db_pass === '') {
    // No password (default XAMPP setup)
    $command = "$mysqldump -u $db_user $db_name > \"$backup_file\" 2>&1";
} else {
    // With a password
    $command = "$mysqldump -u $db_user -p$db_pass $db_name > \"$backup_file\" 2>&1";
}

echo "Starting daily backup...\n";
echo "Database  : $db_name\n";
echo "Save to   : $backup_file\n";
echo "Time      : " . date('Y-m-d H:i:s') . "\n";
echo "-------------------------------------------\n";

$output = shell_exec($command);

if (file_exists($backup_file) && filesize($backup_file) > 0) {
    $size_kb = round(filesize($backup_file) / 1024, 2);
    echo "SUCCESS! Backup created.\n";
    echo "File size : {$size_kb} KB\n";
} else {
    echo "ERROR: Backup failed!\n";
    echo "Command output: $output\n";
}

echo "Done.\n";
