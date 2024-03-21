<?php
include_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
    $password = filter_var(trim($_POST["password"]), FILTER_SANITIZE_STRING);
    $user_type = $_POST["user_type"];
    if ($email && $password && $user_type) {
        $query = "SELECT * FROM user WHERE email = ? AND password = ? AND user_type = ?";
        $stmt = $conn->prepare($query);
        if ($stmt && $stmt->bind_param("sss", $email, $password, $user_type) && $stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $user_id = $result->fetch_assoc()["user_id"];
                session_start();
                $_SESSION['user_id'] = $user_id;
                header("location: " . ($user_type == "Hospital" ? "hospital/hospital.php" : "receiver/receiver.php"));
                exit();
            } else {
                echo "<script>alert('Invalid Username or Password');</script>";
            }
        }
    } else {
        echo "<script>alert('Please enter valid email, password, and select user type');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Bank System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<style>
body {
    background-image: url("image1.png");
    background-repeat: no-repeat;
}

.card {
    background: rgba(0, 0, 0, 0);
    border-radius: 10px;
}
</style>

<body>

    <?php
require('nav.php');
?>
    <div class="container my-2">
        <div class="row justify-content-center">
            <div class="col-md-4 col-sm-12">
                <div class="card shadow-lg p-4 " id="login-card">
                    <h1 class="text-center mb-4">Login</h1>

                    <form method="post" action="">
                        <div class="form-group my-3">
                            <label for="user_type"><i class="fas fa-user"></i> Choose your account type:</label>
                            <select class="form-control" id="user_type" name="user_type">
                                <option value="Hospital" selected>Hospital</option>
                                <option value="Receiver">Receiver</option>
                            </select>
                        </div>

                        <div class="form-group my-3">
                            <label for="email"><i class="fas fa-envelope"></i> Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group my-3">
                            <label for="password"><i class="fas fa-lock"></i> Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-dark">Login</button>
                        </div>
                        <div class="text-center mt-2">
                            <span>Not Signed Up?</span>
                            <a href="registration.php" class="text-dark">Sign Up</a>
                            <span>Now</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <footer class="bg-dark text-white py-2">
        <div class="container ">
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