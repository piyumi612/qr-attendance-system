<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Attendance System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php"><i class="bi bi-qr-code"></i> QR Attendance</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="auth/logout.php">Logout</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="auth/login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="auth/register.php">Register</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold"><i class="bi bi-qr-code"></i> QR Attendance System</h1>
                    <p class="lead">Modernize your attendance tracking with QR code technology.</p>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <a href="auth/register.php" class="btn btn-primary btn-lg">Get Started</a>
                        <a href="auth/login.php" class="btn btn-secondary btn-lg ms-2">Login</a>
                    <?php else: ?>
                        <a href="dashboard.php" class="btn btn-primary btn-lg">Go to Dashboard</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Key Features</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 text-center shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-person-plus display-1 text-primary"></i>
                            <h5>Easy Registration</h5>
                            <p>Students can register quickly with their email and password.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 text-center shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-qr-code display-1 text-primary"></i>
                            <h5>Smart QR Code</h5>
                            <p>Generate unique QR codes for each class session.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 text-center shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-clock-history display-1 text-primary"></i>
                            <h5>Track History</h5>
                            <p>View attendance history with timestamps and status.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container text-center">
            <p>&copy; 2026 QR Attendance System. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>