<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../auth/login.php");
    exit();
}

include("../includes/header.php");

if(isset($_POST['generate'])){

    $user_id = $_POST['user_id'];
    $month = $_POST['month'];

    // Check if payroll already generated
    $check = $conn->query("SELECT * FROM payroll 
                           WHERE user_id='$user_id' 
                           AND month='$month'");

    if($check->num_rows > 0){
        $msg = "<div class='alert alert-warning'>Payroll already generated for this month!</div>";
    } else {

        // Get total hours for selected month
        $result = $conn->query("SELECT SUM(total_hours) AS total_hours 
                                FROM attendance 
                                WHERE user_id='$user_id' 
                                AND DATE_FORMAT(check_in, '%Y-%m') = '$month'");

        $row = $result->fetch_assoc();
        $total_hours = $row['total_hours'] ?? 0;

        // Get salary per hour
        $salary_data = $conn->query("SELECT salary_per_hour FROM users WHERE id='$user_id'");
        $salary_row = $salary_data->fetch_assoc();
        $salary_per_hour = $salary_row['salary_per_hour'];

        $total_salary = round($total_hours * $salary_per_hour, 2);

        // Insert into payroll table
        $conn->query("INSERT INTO payroll (user_id, month, total_hours, total_salary)
                      VALUES ('$user_id', '$month', '$total_hours', '$total_salary')");

        $msg = "<div class='alert alert-success'>Payroll Generated Successfully!</div>";
    }
}

// Get all employees
$employees = $conn->query("SELECT id, name FROM users WHERE role='employee'");
?>

<div class="card shadow">
    <div class="card-body">

        <h3 class="mb-4">Generate Monthly Payroll</h3>

        <?php
        if(isset($msg)){
            echo $msg;
        }
        ?>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Select Employee</label>
                <select name="user_id" class="form-select" required>
                    <?php while($emp = $employees->fetch_assoc()){ ?>
                        <option value="<?php echo $emp['id']; ?>">
                            <?php echo $emp['name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Select Month</label>
                <input type="month" name="month" class="form-control" required>
            </div>

            <button type="submit" name="generate" class="btn btn-success">
                Generate Payroll
            </button>

            <a href="dashboard.php" class="btn btn-primary ms-2">
                Back to Dashboard
            </a>

        </form>

    </div>
</div>

<?php include("../includes/footer.php"); ?>