<?php

class WhackStats {
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
    }

    public function getStats($user_id) {
        $stmt = $this->conn->prepare("SELECT total_played, total_wins, total_losses, high_score FROM score_whack WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $stats = [
            'played' => 0,
            'wins' => 0,
            'losses' => 0,
            'high' => 0
        ];

        if ($row = $result->fetch_assoc()) {
            $stats['played'] = $row['total_played'];
            $stats['wins'] = $row['total_wins'];
            $stats['losses'] = $row['total_losses'];
            $stats['high'] = $row['high_score'];
        }

        return $stats;
    }
}
