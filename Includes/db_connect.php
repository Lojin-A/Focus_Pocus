<?php
$host = 'localhost';
$user = 'root';
$dbname = 'focus_pocus_db'; 

// Our list of passwords to try
$passwords = ["", "lomysql*123"]; 
$conn = null;
$connected = false;
foreach ($passwords as $pass) {
    try {
        $conn = new mysqli($host, $user, $pass, $dbname);
        $connected = true; 
        break; 
        
    } catch (mysqli_sql_exception $e) {
    }
}

// Check if ALL passwords failed
if (!$connected) {
    die("Connection failed for everyone. None of the passwords worked.");
}
// Test message - we will delete this once you confirm it works!
echo "Connection Successful to Focus Pocus DB!";
?>