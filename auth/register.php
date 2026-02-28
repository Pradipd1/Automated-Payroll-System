<?php
session_start();
include("../config/db.php");

// Only admin can access
if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: login.php");
    exit();
}

if(isset($_POST['register'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = "employee"; // Force role as employee
    $salary = $_POST['salary'];

    // Check if email already exists
    $check = $conn->query("SELECT * FROM users WHERE email='$email'");

    if($check->num_rows > 0){
        $msg = "<div class='alert alert-warning'>Email already exists!</div>";
    } else {

        $sql = "INSERT INTO users (name,email,password,role,salary_per_hour)
                VALUES ('$name','$email','$password','$role','$salary')";

        if($conn->query($sql) === TRUE){
            $msg = "<div class='alert alert-success'>Employee Registered Successfully!</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Error: ".$conn->error."</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Employee - Payroll System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow" style="width: 450px;">
        <div class="card-body">

            <h4 class="text-center mb-4">Add New Employee</h4>

            <?php
            if(isset($msg)){
                echo $msg;
            }
            ?>

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Employee Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Employee Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Salary Per Hour</label>
                    <input type="number" name="salary" class="form-control" required>
                </div>

                <button type="submit" name="register" class="btn btn-success w-100">
                    Add Employee
                </button>

                <div class="text-center mt-3">
                    <a href="../admin/dashboard.php">Back to Dashboard</a>
                </div>

            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>