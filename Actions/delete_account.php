<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Pages/login-signup.php");
    exit();
}

require_once '../Includes/db_connect.php';

$db = new Database();
$conn = $db->connect();

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    session_unset();
    session_destroy();

    header("Location: ../index.php");
    exit();
} else {
    echo "Error deleting account.";
}
?>