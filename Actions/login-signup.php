<?php

require_once __DIR__ . '/../Includes/Session.php';
Session::start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === "admin" && $password === "1234") {
        Session::set('isLoggedIn', true);
        Session::set('username', $username);
        
        header('Location: ../index.php');
        exit();
    } else {
        $error = "Username or password is incorrect!";
    }
}
?>