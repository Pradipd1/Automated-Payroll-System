<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != "employee"){
    header("Location: ../auth/login.php");
    exit();
}

include("../includes/header.php");

// Show messages
if(isset($_GET['msg'])){
    if($_GET['msg'] == "checkin_success"){
        echo "<div class='alert alert-success'>
                ✅ Check-In Successful! Now please Check-Out when done.
              </div>";
    }

    if($_GET['msg'] == "checkout_success"){
        echo "<div class='alert alert-success'>
                ✅ Check-Out Successful!
              </div>";
    }
}

$user_id = $_SESSION['user_id'];

if(isset($_POST['checkout'])){

    $imageData = $_POST['image'] ?? '';

    $result = $conn->query("SELECT * FROM attendance 
                            WHERE user_id='$user_id' 
                            AND check_out IS NULL 
                            ORDER BY id DESC 
                            LIMIT 1");

    if($result->num_rows > 0){

        $row = $result->fetch_assoc();

        $check_in_time = strtotime($row['check_in']);
        $check_out_time = time();

        $total_seconds = abs($check_out_time - $check_in_time);
        $total_hours = round($total_seconds / 3600, 4);

        $fileName = null;

        if(!empty($imageData)){
            $imageData = str_replace('data:image/png;base64,', '', $imageData);
            $imageData = base64_decode($imageData);

            $fileName = "checkout_" . time() . ".png";
            $filePath = "../uploads/" . $fileName;

            file_put_contents($filePath, $imageData);
        }

        $update = $conn->query("UPDATE attendance 
                                SET check_out = NOW(),
                                    total_hours = '$total_hours',
                                    checkout_image = '$fileName'
                                WHERE id = ".$row['id']);

        if($update){
            header("Location: dashboard.php?msg=checkout_success");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Error updating record.</div>";
        }

    } else {
        echo "<div class='alert alert-warning'>No active check-in found!</div>";
    }
}
?>

<div class="card shadow">
    <div class="card-body">

        <h3 class="mb-4">Employee Check-Out (With Photo)</h3>

        <video id="video" width="100%" autoplay></video>
        <canvas id="canvas" style="display:none;"></canvas>

        <form method="POST" onsubmit="captureImage();">

            <input type="hidden" name="image" id="image">

            <button type="submit" name="checkout" class="btn btn-warning mt-3">
                Capture & Check Out
            </button>

            <a href="dashboard.php" class="btn btn-primary mt-3 ms-2">
                Back
            </a>
        </form>

    </div>
</div>

<script>
navigator.mediaDevices.getUserMedia({ video: true })
.then(stream => {
    document.getElementById('video').srcObject = stream;
});

function captureImage(){
    var canvas = document.getElementById("canvas");
    var video = document.getElementById("video");

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    canvas.getContext('2d').drawImage(video, 0, 0);

    var imageData = canvas.toDataURL("image/png");
    document.getElementById("image").value = imageData;
}
</script>

<?php include("../includes/footer.php"); ?>