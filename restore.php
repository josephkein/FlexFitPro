<?php

$db_host  = 'localhost';
$db_user  = 'root';       
$db_pass  = '';         
$db_name  = 'flexfitpro';   

// Path to mysql.exe (NOT mysqldump — this one IMPORTS data)
$mysql    = '"C:\\xampp\\mysql\\bin\\mysql.exe"';

// --- BACKUP FOLDER ---
$backup_dir = __DIR__ . '\\backups\\';

echo "============================================\n";
echo "  GYM DB RESTORE TOOL\n";
echo "============================================\n\n";

// glob() finds all files matching a pattern
$sql_files = glob($backup_dir . '*.sql');

if (empty($sql_files)) {
    echo "ERROR: No .sql backup files found in: $backup_dir\n";
    echo "Make sure you have run backup_daily.php or backup_weekly.php first.\n";
    exit; // Stop the script
}

echo "Available backup files:\n";
echo "-------------------------------------------\n";

foreach ($sql_files as $index => $file) {
    $number   = $index + 1;            // Start counting from 1
    $name     = basename($file);       // Just the filename, not the full path
    $size_kb  = round(filesize($file) / 1024, 2);
    $modified = date('Y-m-d H:i', filemtime($file));  // Last modified date

    echo "  [$number] $name\n";
    echo "       Size: {$size_kb} KB | Saved: $modified\n\n";
}

echo "-------------------------------------------\n";

// readline() waits for the user to type something and press Enter
echo "Type the NUMBER of the file you want to restore: ";
$choice = trim(readline());

// Validate the input
if (!is_numeric($choice) || $choice < 1 || $choice > count($sql_files)) {
    echo "ERROR: Invalid choice. Please enter a number between 1 and " . count($sql_files) . ".\n";
    exit;
}

// Get the chosen file path (arrays start at 0, so subtract 1)
$chosen_file = $sql_files[$choice - 1];
$chosen_name = basename($chosen_file);

echo "\n*** WARNING ***\n";
echo "You are about to restore from: $chosen_name\n";
echo "This will OVERWRITE all current data in database: $db_name\n";
echo "\nAre you sure? Type YES to continue: ";
$confirm = trim(readline());

if (strtoupper($confirm) !== 'YES') {
    echo "\nRestore cancelled. No changes were made.\n";
    exit;
}

if ($db_pass === '') {
    $command = "$mysql -u $db_user $db_name < \"$chosen_file\" 2>&1";
} else {
    $command = "$mysql -u $db_user -p$db_pass $db_name < \"$chosen_file\" 2>&1";
}

echo "\nRestoring database...\n";
echo "File      : $chosen_name\n";
echo "Database  : $db_name\n";
echo "Time      : " . date('Y-m-d H:i:s') . "\n";
echo "-------------------------------------------\n";

$output = shell_exec($command);

if (empty(trim($output))) {
    echo "SUCCESS! Database restored from: $chosen_name\n";
} else {
    echo "There may be an issue. Command output:\n";
}
echo "Done.\n";
