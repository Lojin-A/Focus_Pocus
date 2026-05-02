<?php

class MemoryStats {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }

    public function getStats($user_id) {
        $stmt = $this->conn->prepare("SELECT total_played, total_wins, total_losses, fewest_flips, best_time_seconds FROM score_memory WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Default stats if they haven't played yet
        $stats = [
            'played' => 0,
            'wins' => 0,
            'losses' => 0,
            'fewest_flips' => 0,
            'best_time' => 0
        ];

        if ($row = $result->fetch_assoc()) {
            $stats['played'] = $row['total_played'];
            $stats['wins'] = $row['total_wins'];
            $stats['losses'] = $row['total_losses'];
            $stats['fewest_flips'] = $row['fewest_flips'];
            $stats['best_time'] = $row['best_time_seconds'];
        }

        return $stats;
    }
}
