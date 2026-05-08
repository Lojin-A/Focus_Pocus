<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if ($username === "admin" && $password === "1234") {
        $_SESSION['isLoggedIn'] = true;
        $_SESSION['username'] = $username;
        header('Location: ../index.php');
        exit();
    } else {
        $error = "Username or password is incorrect!";
    }
}
?>

