<?php

require_once __DIR__ . '/../Includes/Session.php';
Session::start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
}
?>
