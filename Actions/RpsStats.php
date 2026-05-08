<?php

class RpsStats {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getStats($user_id) {
        $stmt = $this->conn->prepare("SELECT total_played, total_wins, total_losses FROM score_rps WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $stats = [
            'played' => 0,
            'wins' => 0,
            'losses' => 0
        ];

        if ($row = $result->fetch_assoc()) {
            $stats['played'] = $row['total_played'];
            $stats['wins'] = $row['total_wins'];
            $stats['losses'] = $row['total_losses'];
        }

        return $stats;
    }
}