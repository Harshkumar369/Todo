<?php
include 'config.php';

// Already logged in? go straight to app
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $stmt->close();
                $conn->close();
                header("Location: index.php");
                exit;
            } else {
                $error = "Incorrect email or password.";
            }
        } else {
            $error = "Incorrect email or password.";
        }
        $stmt->close();
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login - My Diary</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="desk">
    <div class="auth-card">
        <h1 class="auth-title">📔 Welcome Back</h1>
        <p class="auth-subtitle">Login to see your private to-do diary</p>

        <?php if ($error): ?>
            <p class="auth-error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST" class="auth-form">
            <input type="email" name="email" placeholder="Email address" required
                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="auth-btn">Login</button>
        </form>

        <p class="auth-link">Don't have an account? <a href="register.php">Sign up here</a></p>
    </div>
</div>

</body>
</html>
