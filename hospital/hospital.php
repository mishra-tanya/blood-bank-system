<?php
session_start();
if (isset($_REQUEST['logout'])) {
    session_unset();
    session_destroy();
}
if (!isset($_SESSION['user_id'])) {
    header("location:../login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Bank System</title>
    <link rel="shortcut icon" href="img.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <style>
        body{
            background-image:url("../image1.png");
        }
        .container {
            padding-top: 10px;
            padding-bottom: 50px;
        }

        .card {
            background:rgba(0, 0, 0, 0);;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

<?php 
    require("../config.php");
    $user_id = $_SESSION["user_id"];
    $sql = "SELECT hospital_id FROM hospital WHERE user_id= $user_id;";
    $result = $conn->query($sql);
    $data = $result->fetch_assoc();
    $hospital_id = $data['hospital_id'];

    $message = '';
    $error_message = '';
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $blood_type = $_POST['blood_type'];
        $expiration_date = $_POST['expiration_date'];
        
        // Validate expiration date
        if (strtotime($expiration_date) > strtotime(date('Y-m-d'))) {
            $stmt = $conn->prepare("INSERT INTO add_blood (hospital_id, blood_type, expiration_date) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $hospital_id, $blood_type, $expiration_date);
            if ($stmt->execute()) {
                $message = "Record inserted successfully";
            } else {
                $error_message = "Failed to insert record";
            }
            $stmt->close();
        } else {
            $error_message = "Expiration date should be greater than current date.";
        }
    }
    ?>
    <nav class="navbar navbar-expand-lg ">
        <div class="container-fluid">
            <img src="../image1.png" alt="" style="width:70px;margin-right: 10px;">
            <a class="navbar-brand" href="#">Blood Bank</a>
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
                        <a href="viewrequest.php" class="nav-link active">View Requests</a>
                    </li>
                </ul>
                <form method="get" action=''>
                    <button type="submit" name="logout" class=" btn btn-dark px-2 py-1">Logout</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="m-3">
    <?php if (!empty($message)) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $message; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <!-- Display error message -->
    <?php if (!empty($error_message)) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $error_message; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>
    </div>
   
    <div class="container">
        <div class="container mt-3">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card shadow-lg p-4">
            <h1 class="text-center mt-3">Add Blood Info</h1>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="blood_type" class="form-label">Blood Type:</label>
                                <select class="form-select" id="blood_type" name="blood_type" required>
                                    <option value="" disabled selected>Select Blood Type</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="expiration_date" class="form-label">Expiration date:</label>
                                <input type="date" class="form-control" id="expiration_date" name="expiration_date" required min="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-dark">Add Blood</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white py-2 ">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p>&copy; 2024 Blood Bank System</p>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
