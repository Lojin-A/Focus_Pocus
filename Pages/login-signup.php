<?php
session_start();

// إذا مسجل دخول، رجعه للرئيسية
if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

require_once '../Includes/db_connect.php';
$database = new Database();
$conn = $database->connect();

$error_login = '';
$error_signup = '';
$success_signup = '';

// ==========================================
// تسجيل الدخول
// ==========================================
if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            header("Location: ../index.php");
            exit();
        } else {
            $error_login = "Wrong password!";
        }
    } else {
        $error_login = "Username not found!";
    }
}

// ==========================================
// إنشاء حساب
// ==========================================
if (isset($_POST['signup'])) {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // تحقق إذا اسم المستخدم موجود
    $check = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $error_signup = "Username already taken!";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $insert = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $insert->bind_param("sss", $username, $email, $hashed);

        if ($insert->execute()) {
            $success_signup = "Account created! You can now log in.";
        } else {
            $error_signup = "Something went wrong, try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Sign Up</title>
    <link rel="stylesheet" href="../Assets/CSS/login-signup.css">
</head>
<body>
    <a href="../index.php" class="home-button">
        <img src="../Assets/Media/home-icon.png" alt="Home">
    </a>

    <div class="wrapper">

        <!-- Sign Up -->
        <div class="form-wrapper sign-up">
            <form method="POST" action="">
                <h2>Sign Up</h2>

                <?php if ($error_signup): ?>
                    <p class="error-msg"><?php echo $error_signup; ?></p>
                <?php endif; ?>
                <?php if ($success_signup): ?>
                    <p class="success-msg"><?php echo $success_signup; ?></p>
                <?php endif; ?>

                <div class="input-group">
                    <input type="text" name="username" required>
                    <label>Username</label>
                </div>
                <div class="input-group">
                    <input type="email" name="email" required>
                    <label>Email</label>
                </div>
                <div class="input-group">
                    <input type="password" name="password" required>
                    <label>Password</label>
                </div>
                <button type="submit" name="signup" class="btn">Sign Up</button>
                <div class="sign-link">
                    <p>Already have an account? <a href="#" class="signIn-link">Sign In</a></p>
                </div>
            </form>
        </div>

        <!-- Sign In -->
        <div class="form-wrapper sign-in">
            <form method="POST" action="">
                <h2>Login</h2>

                <?php if ($error_login): ?>
                    <p class="error-msg"><?php echo $error_login; ?></p>
                <?php endif; ?>

                <div class="input-group">
                    <input type="text" name="username" required>
                    <label>Username</label>
                </div>
                <div class="input-group">
                    <input type="password" name="password" required>
                    <label>Password</label>
                </div>
                <button type="submit" name="login" class="btn">Login</button>
                <div class="sign-link">
                    <p>Don't have an account? <a href="#" class="signUp-link">Sign Up</a></p>
                </div>
            </form>
        </div>

    </div>

    <script src="../Assets/JavaScript/login-signup.js"></script>
</body>
</html>