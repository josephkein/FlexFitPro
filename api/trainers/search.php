<?php
    session_start();
    if (!isset($_SESSION['role'])) {
        echo json_encode([]);
        exit;
    }

    require __DIR__ . '/../../database/database.php';
    $config = require __DIR__ . '/../../config/config.php';

    $db = new Database($config);
    $conn = $db->getConnection();

    $query = $_GET['q'] ?? '';

    if (empty($query)) {
        echo json_encode([]);
        exit;
    }

    $q = "SELECT trainer_id AS id, CONCAT(first_name, ' ', last_name) AS name FROM trainers WHERE CONCAT(first_name, ' ', last_name) LIKE ? LIMIT 5";
    $stmt = $conn->prepare($q);
    $search = "%$query%";
    $stmt->bind_param('s', $search);
    $stmt->execute();

    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    echo json_encode($result);
?>