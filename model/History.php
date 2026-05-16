<?php

class History {
    private mysqli $db;

    public function __construct(mysqli $db) {
        $this->db = $db;
    }

    // ✅ Only insert what happened NOW
    public function insert(
        int $customerId,
        string $changeType,
        $oldValue,
        $newValue,
        int $refId
    ): int|false {
        $stmt = $this->db->prepare("
            INSERT INTO customer_history
                (customer_id, change_type, old_value, new_value, changed_at, ref_id)
            VALUES (?, ?, ?, ?, NOW(), ?)
        ");
        $stmt->bind_param('isssi', $customerId, $changeType, $oldValue, $newValue, $refId);
        $stmt->execute();
        $id = $this->db->insert_id;
        $stmt->close();
        return $id ?: false;
    }

    // ✅ Get all history of a customer
    public function getByCustomer(int $customerId): array {
        $stmt = $this->db->prepare("
            SELECT *
            FROM customer_history
            WHERE customer_id = ?
            ORDER BY history_id DESC
        ");
        $stmt->bind_param('i', $customerId);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rows;
    }

    // ✅ Get current and previous of a type (plan, trainer, visit)
    public function getLastTwo(int $customerId, string $changeType): array {
        $stmt = $this->db->prepare("
            SELECT old_value, new_value, changed_at
            FROM customer_history
            WHERE customer_id = ?
              AND change_type = ?
            ORDER BY history_id DESC
            LIMIT 2
        ");
        $stmt->bind_param('is', $customerId, $changeType);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rows;
    }
}
?>