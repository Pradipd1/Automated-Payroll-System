<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Automated Payroll System</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background-color: #f4f6f9;
        }

        .sidebar {
            height: 100vh;
            background: #1e293b;
            color: white;
            position: fixed;
            width: 230px;
            padding-top: 20px;
        }

        .sidebar h4 {
            color: white;
        }

        .sidebar a {
            color: #cbd5e1;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background: #334155;
            color: white;
        }

        .content {
            margin-left: 230px;
            padding: 20px;
        }
    </style>
</head>
<body>

<?php if(isset($_SESSION['role']) && $_SESSION['role'] == "admin"){ ?>

    <div class="sidebar">
        <h4 class="text-center mb-4">Admin Panel</h4>

        <a href="dashboard.php">Dashboard</a>
        <a href="view_attendance.php">View Attendance</a>
        <a href="generate_payroll.php">Generate Payroll</a>
        <a href="view_payroll.php">View Payroll</a>
        <a href="../auth/register.php">Add Employee</a>
        <a href="../auth/logout.php">Logout</a>
    </div>

    <div class="content">

<?php } ?>