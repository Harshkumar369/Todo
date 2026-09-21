<?php
include 'config.php';

// Already logged in? go straight to app
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($name) || empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        // Check if email already registered
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "This email is already registered. Please login instead.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $insert = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $insert->bind_param("sss", $name, $email, $hashedPassword);

            if ($insert->execute()) {
                $_SESSION['user_id'] = $insert->insert_id;
                $_SESSION['user_name'] = $name;
                $insert->close();
                $conn->close();
                header("Location: index.php");
                exit;
            } else {
                $error = "Something went wrong. Please try again.";
            }
            $insert->close();
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
<title>Sign Up - My Diary</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="desk">
    <div class="auth-card">
        <h1 class="auth-title">📔 Create Account</h1>
        <p class="auth-subtitle">Start your own private to-do diary</p>

        <?php if ($error): ?>
            <p class="auth-error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST" class="auth-form">
            <input type="text" name="name" placeholder="Your name" required
                   value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
            <input type="email" name="email" placeholder="Email address" required
                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            <input type="password" name="password" placeholder="Password (min 6 characters)" required>
            <button type="submit" class="auth-btn">Sign Up</button>
        </form>

        <p class="auth-link">Already have an account? <a href="login.php">Login here</a></p>
    </div>
</div>

</body>
</html>
