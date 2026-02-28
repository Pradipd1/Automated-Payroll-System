<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../auth/login.php");
    exit();
}

include("../includes/header.php");

$result = $conn->query("SELECT users.name, payroll.* 
                        FROM payroll 
                        JOIN users ON payroll.user_id = users.id
                        ORDER BY payroll.id DESC");
?>

<div class="card shadow">
    <div class="card-body">

        <h3 class="mb-4">Payroll Records</h3>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Employee Name</th>
                    <th>Month</th>
                    <th>Total Hours</th>
                    <th>Total Salary</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()){ ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['month']; ?></td>
                        <td><?php echo $row['total_hours']; ?></td>
                        <td><?php echo $row['total_salary']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <a href="dashboard.php" class="btn btn-primary">Back to Dashboard</a>

    </div>
</div>

<?php include("../includes/footer.php"); ?>