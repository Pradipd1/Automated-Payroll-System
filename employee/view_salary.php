<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != "employee"){
    header("Location: ../auth/login.php");
    exit();
}

include("../includes/header.php");

$user_id = $_SESSION['user_id'];

$result = $conn->query("SELECT * FROM payroll 
                        WHERE user_id='$user_id'
                        ORDER BY id DESC");
?>

<div class="card shadow">
    <div class="card-body">

        <h3 class="mb-4">My Salary Records</h3>

        <?php if($result->num_rows > 0){ ?>

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Month</th>
                        <th>Total Hours</th>
                        <th>Total Salary</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()){ ?>
                        <tr>
                            <td><?php echo $row['month']; ?></td>
                            <td><?php echo $row['total_hours']; ?></td>
                            <td>₹ <?php echo $row['total_salary']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        <?php } else { ?>

            <div class="alert alert-info">
                No salary records available yet.
            </div>

        <?php } ?>

        <a href="dashboard.php" class="btn btn-primary mt-3">
            Back to Dashboard
        </a>

    </div>
</div>

<?php include("../includes/footer.php"); ?>