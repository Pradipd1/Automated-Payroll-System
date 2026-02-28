<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != "employee"){
    header("Location: ../auth/login.php");
    exit();
}

include("../includes/header.php");

$user_id = $_SESSION['user_id'];

if(isset($_POST['checkin'])){

    $latitude = $_POST['latitude'] ?? '';
    $longitude = $_POST['longitude'] ?? '';
    $imageData = $_POST['image'] ?? '';

    // Prevent double check-in
    $check = $conn->query("SELECT * FROM attendance 
                           WHERE user_id='$user_id' 
                           AND check_out IS NULL");

    if($check->num_rows > 0){

        echo "<div class='alert alert-warning'>You are already checked in!</div>";

    } else {

        $fileName = null;

        // Save image if exists
        if(!empty($imageData)){

            $imageData = str_replace('data:image/png;base64,', '', $imageData);
            $imageData = base64_decode($imageData);

            $fileName = "photo_" . time() . ".png";
            $filePath = "../uploads/" . $fileName;

            file_put_contents($filePath, $imageData);
        }

        $sql = "INSERT INTO attendance 
                (user_id, check_in, latitude, longitude, image_path)
                VALUES 
                ('$user_id', NOW(), '$latitude', '$longitude', '$fileName')";

        if($conn->query($sql)){
            header("Location: checkout.php?msg=checkin_success");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Error saving record.</div>";
        }
    }
}
?>

<div class="card shadow">
    <div class="card-body">

        <h3 class="mb-4">Employee Check-In (With Photo)</h3>

        <video id="video" width="100%" autoplay></video>
        <canvas id="canvas" style="display:none;"></canvas>

        <form method="POST" onsubmit="captureImage(); getLocation();">

            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">
            <input type="hidden" name="image" id="image">

            <button type="submit" name="checkin" class="btn btn-success mt-3">
                Capture & Check In
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

function getLocation(){
    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(function(position){
            document.getElementById("latitude").value = position.coords.latitude;
            document.getElementById("longitude").value = position.coords.longitude;
        });
    }
}
</script>

<?php include("../includes/footer.php"); ?>