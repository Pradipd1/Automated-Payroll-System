<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../auth/login.php");
    exit();
}

include("../includes/header.php");

// Get monthly attendance count
$monthlyData = $conn->query("
    SELECT DATE_FORMAT(check_in, '%Y-%m') AS month,
           COUNT(*) AS total_attendance
    FROM attendance
    GROUP BY month
    ORDER BY month ASC
");

$months = [];
$attendanceCounts = [];

while($row = $monthlyData->fetch_assoc()){
    $months[] = $row['month'];
    $attendanceCounts[] = $row['total_attendance'];
}
?>

<div class="card shadow mb-4">
    <div class="card-body">
        <h3 class="mb-4">Admin Dashboard</h3>

        <div class="row g-3">

            <div class="col-md-4">
                <a href="view_attendance.php" class="btn btn-primary w-100">
                    View Attendance
                </a>
            </div>

            <div class="col-md-4">
                <a href="generate_payroll.php" class="btn btn-success w-100">
                    Generate Payroll
                </a>
            </div>

            <div class="col-md-4">
                <a href="view_payroll.php" class="btn btn-info w-100">
                    View Payroll
                </a>
            </div>

        </div>
    </div>
</div>

<!-- Attendance Chart -->
<div class="card shadow">
    <div class="card-body">
        <h5 class="mb-4">Monthly Attendance Overview</h5>
        <canvas id="attendanceChart"></canvas>
    </div>
</div>

<script>
var ctx = document.getElementById('attendanceChart').getContext('2d');

var attendanceChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($months); ?>,
        datasets: [{
            label: 'Total Attendance',
            data: <?php echo json_encode($attendanceCounts); ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.7)'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<?php include("../includes/footer.php"); ?>