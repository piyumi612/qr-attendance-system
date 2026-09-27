<?php
include '../Includes/db.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email'] ?? '');
    
    if (empty($email) || !validateEmail($email)) {
        $error = 'Please enter a valid email address.';
    } else {
        // Check if email exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
        $message = '✅ A password reset link has been sent to your email address. Please check your inbox.  ';
        }
        else {
        $message = 'If this email is registered, a password reset link would be sent. (Demo)';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - QR Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="../index.php"><i class="bi bi-qr-code"></i> QR Attendance</a>
        </div>
    </nav>

    <section class="auth-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card shadow-lg border-0">
                        <div class="card-body p-5">
                            <h2 class="text-center mb-2">
                                <i class="bi bi-key text-primary"></i> Forgot Password
                            </h2>
                            <p class="text-center text-muted mb-4">Enter your email to reset your password</p>

                            <?php if ($error): ?>
                                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                            <?php endif; ?>
                            <?php if ($message): ?>
                                <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
                            <?php endif; ?>

                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label class="form-label">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-2">Send Reset Link</button>
                            </form>

                            <p class="text-center mt-3">
                                <a href="login.php">Back to Login</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container text-center"><p>&copy; 2026 QR Attendance System</p></div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>