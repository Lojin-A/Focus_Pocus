<?php

class GuessStats {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getStats($user_id) {
        $stmt = $this->conn->prepare("SELECT total_played, fewest_attempts FROM score_guess WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $stats = [
            'played' => 0,
            'fewest' => 0
        ];

        if ($row = $result->fetch_assoc()) {
            $stats['played'] = $row['total_played'];
            $stats['fewest'] = $row['fewest_attempts'];
        }

        return $stats;
    }
}