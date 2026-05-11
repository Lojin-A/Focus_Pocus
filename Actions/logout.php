<?php
require_once __DIR__ . '/../Includes/Session.php';

Session::start();
Session::destroy();

header('Location: ../index.php');
exit();
?>
