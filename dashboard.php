 <?php
// DASHBOARD.PHP - User Dashboard


include 'includes/db.php';

if (!isLoggedIn()) {
    redirect('auth/login.php');
}

$user_id = getUserId();
$username = getUsername();
$role = getUserRole();

$stmt = $conn->prepare("SELECT * FROM attendance WHERE student_id = ? ORDER BY scan_time DESC LIMIT 10");
$stmt->execute([$user_id]);
$attendance_records = $stmt->fetchAll();

$qr_code = '';
if ($role === 'lecturer' && isset($_POST['generate_qr'])) {
    $qr_code = 'SESSION-' . date('Ymd') . '-' . rand(10000, 99999);
    $session_date = date('Y-m-d');
    $start_time = date('H:i:s');
    $end_time = date('H:i:s', strtotime('+1 hour'));
    $stmt = $conn->prepare("INSERT INTO sessions (lecturer_id, qr_code, session_date, start_time, end_time) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $qr_code, $session_date, $start_time, $end_time]);
}

$scan_message = '';
if ($role === 'student' && isset($_POST['scan_qr'])) {
    $scanned_code = $_POST['qr_code'] ?? '';
    if (!empty($scanned_code)) {
        $stmt = $conn->prepare("SELECT id FROM sessions WHERE qr_code = ? AND session_date = CURDATE()");
        $stmt->execute([$scanned_code]);
        if ($stmt->rowCount() > 0) {
            $stmt = $conn->prepare("SELECT id FROM attendance WHERE student_id = ? AND qr_code_data = ?");
            $stmt->execute([$user_id, $scanned_code]);
            if ($stmt->rowCount() === 0) {
                $stmt = $conn->prepare("INSERT INTO attendance (student_id, qr_code_data, status) VALUES (?, ?, 'Present')");
                $stmt->execute([$user_id, $scanned_code]);
                $scan_message = '✅ Attendance marked successfully!';
                header("Refresh:1");
            } else {
                $scan_message = '⚠️ Attendance already marked for this session!';
            }
        } else {
            $scan_message = '❌ Invalid or expired QR code!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - QR Attendance</title>
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
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><span class="nav-link text-light"><i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($username); ?> <span class="badge bg-secondary"><?php echo $role; ?></span></span></li>
                    <li class="nav-item"><a class="nav-link" href="auth/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="dashboard py-4">
        <div class="container">
            <div class="row">

                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-person-circle display-4 text-primary"></i>
                            <h5><?php echo htmlspecialchars($username); ?></h5>
                            <p class="text-muted small"><?php echo ucfirst($role); ?></p>
                            <hr>
                            <div class="row">
                                <div class="col-6"><h6>85%</h6><small>Attendance</small></div>
                                <div class="col-6"><h6>12</h6><small>Sessions</small></div>
                            </div>
                            <hr>
                            <h6>Quick Links</h6>
                            <ul class="list-unstyled text-start">
                                <li class="py-1"><i class="bi bi-qr-code text-primary"></i> <a href="#">Scan QR</a></li>
                                <li class="py-1"><i class="bi bi-clock-history text-primary"></i> <a href="#">History</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">

                    <?php if ($role === 'student'): ?>
                    <div class="card shadow-sm mb-4">
                        <div class="card-body text-center py-5">
                            <h3><i class="bi bi-qr-code text-primary"></i> Scan Attendance</h3>
                            <?php if ($scan_message): ?>
                                <div class="alert <?php echo strpos($scan_message, '✅') !== false ? 'alert-success' : 'alert-danger'; ?>"><?php echo $scan_message; ?></div>
                            <?php endif; ?>
                            <form method="POST" action="">
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input type="text" name="qr_code" class="form-control" placeholder="Enter QR Code" required>
                                            <button type="submit" name="scan_qr" class="btn btn-success"><i class="bi bi-camera"></i> Scan</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ($role === 'lecturer'): ?>
                    <div class="card shadow-sm mb-4">
                        <div class="card-body text-center">
                            <h5><i class="bi bi-plus-circle text-primary"></i> Generate QR Code</h5>
                            <form method="POST" action="">
                                <button type="submit" name="generate_qr" class="btn btn-primary"><i class="bi bi-qr-code"></i> Generate New QR</button>
                            </form>
                            <?php if ($qr_code): ?>
                            <div class="mt-3">
                                <div class="border p-3 bg-light"><code><?php echo $qr_code; ?></code><br><small>Valid for today's session</small></div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5><i class="bi bi-clock-history text-primary"></i> Recent Attendance</h5>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr><th>Date</th><th>Time</th><th>Status</th></tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($attendance_records) > 0): ?>
                                            <?php foreach ($attendance_records as $record): ?>
                                            <tr>
                                                <td><?php echo date('d M Y', strtotime($record['scan_time'])); ?></td>
                                                <td><?php echo date('h:i A', strtotime($record['scan_time'])); ?></td>
                                                <td><span class="badge bg-<?php echo $record['status'] === 'Present' ? 'success' : 'danger'; ?>"><?php echo $record['status']; ?></span></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr><td colspan="3" class="text-center text-muted">No attendance records found</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <button class="btn btn-danger btn-sm mt-2"><i class="bi bi-file-earmark-pdf"></i> Download PDF</button>
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