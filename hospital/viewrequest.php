<?php
session_start();

if (isset($_REQUEST['logout'])) {
    session_unset();
    session_destroy();
    header("location:../login.php");
    exit();
}

if (!isset($_SESSION['user_id'])) {
    header("location:../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title> 
    <link rel="shortcut icon" href="../image1.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>

<body>
<?php 
require("../config.php");
$user_id = $_SESSION["user_id"];
$sql = "SELECT hospital_id FROM hospital WHERE user_id= $user_id; ";
$result = $conn->query($sql);
$data = $result->fetch_assoc();
$hospital_id = $data['hospital_id'];
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid"><img src="../image1.png" alt="" style="width:70px;margin-right:10px">
        <a class="navbar-brand" href="#">Blood Bank </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="hospital.php">Home</a>
                </li>
                <li class="nav-item">
                    <a href="viewrequest.php" class="nav-link active ">View Requests</a>
                </li>
            </ul>
            <form method="get" action=''>
                <button type="submit" name="logout" class="btn btn-dark px-2 py-1">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>

<div class="m-4">
    <div class="container mt-4" id="bloodrequest">
        <div class="text-center m-2 mb-4">
            <h1>View Requests</h1>
        </div>
    </div>
    <div class="table-responsive">
        <?php
        $sql =  "SELECT 
        r.full_name,r.address ,r.phone_number,b.blood_type,b.expiration_date,rq.request_date, rq.request_id, rq.status
        FROM request rq
        JOIN receiver r ON rq.receiver_id = r.receiver_id
        JOIN add_blood b ON rq.blood_info_id = b.blood_info_id
        JOIN hospital h ON b.hospital_id = h.hospital_id
        WHERE h.hospital_id = $hospital_id ORDER BY request_id DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='table table-bordered  table-hover text-center'>";
            echo "<thead class='bg-dark text-white m-4'><tr><th>S.No</th>
            <th>Receiver</th>
            <th>Address</th>
            <th>Contact No.</th>
            <th>Blood Type</th>
            <th>Expiration Date</th>
            <th>Requested Date</th>
            <th>Track Status</th></tr></thead>";
            $i=1;
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" .$i. "</td>";
                echo "<td>" . $row["full_name"] . "</td>";
                echo "<td>" . $row["address"] .    " </td>";
                echo "<td>" . $row["phone_number"] . "</td>";
                echo "<td>" . $row["blood_type"] . "</td>";
                echo "<td>" . $row["expiration_date"] . "</td>";
                echo "<td>" . $row["request_date"] . "</td>";
                if (!empty($row['status'])) {
                    echo "<td><button class='btn btn-success disabled'>Blood Transferred</button></td>";
                } else {
                    echo "<td><button class='btn btn-primary' data-request-id='".$row['request_id']."' onclick='markAsSeen(".$row['request_id'].", this)'>Not Transferred</button></td>";
                }
                
                echo "</tr>";
                $i++;
            }
            echo "</table>";
        } else {
            echo "No blood request available.";
        }
        $conn->close();
        ?>
    </div>
</div>

<footer class="bg-dark text-white py-2">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <p>&copy; 2024 Blood Bank System</p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function markAsSeen(request_id, button) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "mark_seen.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            if (xhr.responseText === "success") {
                localStorage.setItem("request_" + request_id, "seen");
                button.textContent = "Blood Transferred";
                button.classList.remove("btn-danger");
                button.classList.add("btn-success");
                button.disabled = true;
            } else {
                console.log("Error marking request as transferred.");
            }
        }
    };
    xhr.send("request_id=" + request_id);
}

document.addEventListener("DOMContentLoaded", function() {
    var buttons = document.querySelectorAll(".btn-primary");
    buttons.forEach(function(button) {
        var requestId = button.getAttribute("data-request-id");
        if (localStorage.getItem("request_" + requestId) === "seen") {
            button.textContent = "Blood Transferred";
            button.classList.remove("btn-primary");
            button.classList.add("btn-success");
            button.disabled = true;
        }
    });
});
</script>


</body>
</html>
