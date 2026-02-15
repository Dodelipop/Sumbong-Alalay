<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin Login - Sumbong Alalay</title>
    <link rel="stylesheet" href="styles.css">
    <meta name="robots" content="noindex">
    <style>
        .login-card { max-width:420px; margin:4rem auto; }
        .error { color: red; margin-top: 1rem; }
    </style>
</head>
<body>
    <section class="login-section">
        <div class="login-card">
            <div class="login-icon"></div>
            <h2>Admin Login</h2>
            <p class="subtitle">Mag-login para ma-access ang Admin Dashboard</p>

            <!-- Login -->
            <?php
            session_start();
            $error = '';

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Connect to database (try to auto-create DB when missing)
                $conn = @mysqli_connect("localhost", "root", "", "simple_login");
                if (!$conn) {
                    $error = "Connection failed: " . mysqli_connect_error();
                } else {
                    $username = $_POST['username'] ?? '';
                    $password = $_POST['password'] ?? '';

                    // Simple direct query to check credentials
                    $sql = "SELECT id FROM users WHERE username = '$username' AND password = '$password'";
                    $res = mysqli_query($conn, $sql);
                    if ($res && mysqli_num_rows($res) > 0) {
                        // Correct login, set session and redirect
                        $_SESSION['admin_logged_in'] = true;
                        header("Location: dashboard.php");
                        exit();
                    } else {
                        $error = "Wrong username or password!";
                    }
                    mysqli_close($conn);
                }
            }
            ?>

            <form action="" method="post" novalidate>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Enter your username" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>

                <div class="demo-credentials">
                    <p>
                        <strong>Demo Credentials:</strong><br>
                        Username: <code>admin</code><br>
                        Password: <code>admin1234</code>
                    </p>
                </div>

                <?php if ($error !== ''): ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php endif; ?>

                <div class="button-group">
                    <a href="index.php" class="btn btn-outline btn-block">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </div>
            </form>
        </div>
    </section>
</body>
</html>
