<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../auth/login.php");
    exit();
}

include("../includes/header.php");

// Filters
$nameFilter = $_GET['name'] ?? '';
$dateFilter = $_GET['date'] ?? '';
$monthFilter = $_GET['month'] ?? '';

$query = "SELECT users.name, attendance.* 
          FROM attendance 
          JOIN users ON attendance.user_id = users.id
          WHERE 1=1";

if(!empty($nameFilter)){
    $query .= " AND users.name LIKE '%$nameFilter%'";
}

if(!empty($dateFilter)){
    $query .= " AND DATE(attendance.check_in) = '$dateFilter'";
}

if(!empty($monthFilter)){
    $query .= " AND DATE_FORMAT(attendance.check_in, '%Y-%m') = '$monthFilter'";
}

$query .= " ORDER BY attendance.id DESC";

$result = $conn->query($query);
?>

<div class="card shadow">
    <div class="card-body">

        <h3 class="mb-4">Employee Attendance Records</h3>

        <!-- Filter Section -->
        <form method="GET" class="row g-3 mb-4">

            <div class="col-md-4">
                <input type="text" name="name" class="form-control"
                       placeholder="Search by employee name"
                       value="<?php echo htmlspecialchars($nameFilter); ?>">
            </div>

            <div class="col-md-3">
                <input type="date" name="date" class="form-control"
                       value="<?php echo htmlspecialchars($dateFilter); ?>">
            </div>

            <div class="col-md-3">
                <input type="month" name="month" class="form-control"
                       value="<?php echo htmlspecialchars($monthFilter); ?>">
            </div>

            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-primary">
                    Filter
                </button>
            </div>

        </form>

        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Worked Time</th>
                    <th>Total Hours</th>
                    <th>Check-In Photo</th>
                    <th>Check-Out Photo</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                </tr>
            </thead>
            <tbody>

                <?php while($row = $result->fetch_assoc()){ 

                    if(!empty($row['total_hours'])){
                        $seconds = $row['total_hours'] * 3600;
                        $formatted_time = gmdate("H:i:s", (int)$seconds);
                    } else {
                        $formatted_time = "-";
                    }
                ?>

                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['check_in']; ?></td>
                        <td><?php echo $row['check_out'] ?? "-"; ?></td>
                        <td><strong><?php echo $formatted_time; ?></strong></td>
                        <td><?php echo $row['total_hours'] ?? "-"; ?></td>

                        <td>
                            <?php if(!empty($row['image_path'])){ ?>
                                <img src="../uploads/<?php echo $row['image_path']; ?>" 
                                     width="60"
                                     class="rounded border preview-img"
                                     style="cursor:pointer;">
                            <?php } else { echo "-"; } ?>
                        </td>

                        <td>
                            <?php if(!empty($row['checkout_image'])){ ?>
                                <img src="../uploads/<?php echo $row['checkout_image']; ?>" 
                                     width="60"
                                     class="rounded border preview-img"
                                     style="cursor:pointer;">
                            <?php } else { echo "-"; } ?>
                        </td>

                        <td><?php echo $row['latitude']; ?></td>
                        <td><?php echo $row['longitude']; ?></td>
                    </tr>

                <?php } ?>

            </tbody>
        </table>

        <a href="dashboard.php" class="btn btn-secondary">
            Back to Dashboard
        </a>

    </div>
</div>

<!-- Image Preview Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-body text-center">
        <img id="modalImage" src="" class="img-fluid rounded">
      </div>
    </div>
  </div>
</div>

<script>
document.querySelectorAll('.preview-img').forEach(img => {
    img.addEventListener('click', function(){
        document.getElementById('modalImage').src = this.src;
        var modal = new bootstrap.Modal(document.getElementById('imageModal'));
        modal.show();
    });
});
</script>

<?php include("../includes/footer.php"); ?>