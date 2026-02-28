<?php
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != "employee"){
    header("Location: ../auth/login.php");
    exit();
}

include("../includes/header.php");
?>

<div class="card shadow">
    <div class="card-body">

        <h3 class="mb-4">Employee Dashboard</h3>

        <!-- Success / Warning Messages -->
        <?php
        if(isset($_GET['msg'])){

            if($_GET['msg'] == "checkin_success"){
                echo "<div class='alert alert-success'>
                        ✅ Check-In Successful!
                      </div>";
            }

            if($_GET['msg'] == "checkout_success"){
                echo "<div class='alert alert-success'>
                        ✅ Check-Out Successful!
                      </div>";
            }

            if($_GET['msg'] == "already_checkedin"){
                echo "<div class='alert alert-warning'>
                        ⚠ You are already checked in!
                      </div>";
            }
        }
        ?>

        <div class="row g-3">

            <div class="col-md-6">
                <div class="card border-success">
                    <div class="card-body text-center">
                        <h5 class="card-title">Check In</h5>
                        <p class="card-text">Record your attendance with GPS & Face Capture.</p>
                        <a href="checkin.php" class="btn btn-success w-100">
                            Check In
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-warning">
                    <div class="card-body text-center">
                        <h5 class="card-title">Check Out</h5>
                        <p class="card-text">Complete your working session with Face Capture.</p>
                        <a href="checkout.php" class="btn btn-warning w-100">
                            Check Out
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-info">
                    <div class="card-body text-center">
                        <h5 class="card-title">View Salary</h5>
                        <p class="card-text">Check your monthly payroll records.</p>
                        <a href="view_salary.php" class="btn btn-info w-100">
                            View My Salary
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-danger">
                    <div class="card-body text-center">
                        <h5 class="card-title">Logout</h5>
                        <p class="card-text">Securely exit your account.</p>
                        <a href="../auth/logout.php" class="btn btn-danger w-100">
                            Logout
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<?php include("../includes/footer.php"); ?>