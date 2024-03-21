<?php
require("config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_type =$_POST["userType"];
    if ($user_type == "hospital") {
        if (empty($_POST["hospitalEmail"]) || empty($_POST["hospitalPassword"]) || empty($user_type)) {
            echo "<script>alert('Please enter all required fields.'); window.location.assign('registration.php');</script>";
            exit;
        }
        if (!filter_var($_POST["hospitalEmail"], FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Invalid email');  window.location.assign('registration.php');</script>";
            exit;
        }
        $hospital_name = $_POST["hospitalName"];
        $hospital_email =$_POST["hospitalEmail"];
        $hospital_password =$_POST["hospitalPassword"];
        $hospital_address = $_POST["hospitalAddress"];
        $hospital_phone_number = $_POST["hospitalPhone"];
        $sql = "SELECT * FROM user WHERE email = '$hospital_email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "<script>alert('Email already exists!');  window.location.assign('registration.php');</script>";
            die();
        }
        $sql = "INSERT INTO user (email, password, user_type) VALUES ('$hospital_email', '$hospital_password', '$user_type')";
        $conn->query($sql);
        $user_id = $conn->insert_id;
        $sql = "INSERT INTO hospital (user_id, hospital_name, address, phone_number)
                VALUES ('$user_id', '$hospital_name', '$hospital_address',   '$hospital_phone_number')";
        $conn->query($sql);

    } 
    //for receiver
    else {
         if (empty($_POST["receiverEmail"]) || empty($_POST["receiverPassword"]) || empty($user_type)) {
            echo "<script>alert('Please enter all required fields.');
            window.location.assign('registration.php');</script>";
            exit;
        }
        if (!filter_var($_POST["receiverEmail"], FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Invalid email');  window.location.assign('registration.php');</script>";
            exit;
        }
        $receiver_email = $_POST["receiverEmail"];
        $receiver_password =  $_POST["receiverPassword"];
        $receiver_full_name =  $_POST["receiverFullName"];
        $receiver_address =  $_POST["receiverAddress"];
        $receiver_phone_number =  $_POST["receiverPhone"];
        $receiver_blood_group =  $_POST["receiverBloodGroup"];

        $sql = "SELECT * FROM user WHERE email = '$receiver_email'";
        $result = $conn->query($sql);
       if ($result->num_rows > 0) {
            echo "<script>alert('Email already exists!');  window.location.assign('registration.php');</script>";
            die();
        }
        $sql = "INSERT INTO user (email, password, user_type)VALUES ('$receiver_email', '$receiver_password', '$user_type')";
        $conn->query($sql);
        $user_id = $conn->insert_id;
        $sql = "INSERT INTO receiver (user_id, full_name, address, phone_number, blood_group)
                VALUES ('$user_id', '$receiver_full_name', '$receiver_address',  '$receiver_phone_number', '$receiver_blood_group')";
        $conn->query($sql);
        }
    echo "<script>alert('Registration successful.');  window.location.assign('login.php');</script>";
    $conn->close();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Blood Bank System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


    <style>
    body {
        background-image: url("image1.png");
        background-repeat: no-repeat;
    }

    .hide-fields {
        display: none;
    }

    .card {
        background: rgba(0, 0, 0, 0);
        border-radius: 10px;
    }
    </style>
</head>

<body>
    <?php
    require('nav.php');
    ?>
    <div class="container my-2 ">
        <h1 class="text-center mb-3">Sign Up</h1>
        <div class="row">
            <div class="card col-8 mx-auto">
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-group my-3 my-2">
                            <label>Select account type:</label>
                            <select class="form-control" id="userType" name="userType" required>
                                <option value="" selected disabled>Select Account Type</option>
                                <option value="hospital">Hospital</option>
                                <option value="receiver">Receiver</option>
                            </select>
                        </div>
                        <div id="hospitalFields" class="form-group my-3 my-2 hide-fields" style="display:none">
                            <label>Hospital name:</label>
                            <input type="text" class="form-control" id="hospitalName" name="hospitalName">

                            <label>Address:</label>
                            <input type="text" class="form-control" id="hospitalAddress" name="hospitalAddress">

                            <label>Phone number:</label>
                            <input type="text" class="form-control" id="hospitalPhone" name="hospitalPhone">

                            <label>Email address:</label>
                            <input type="email" class="form-control" id="hospitalEmail" name="hospitalEmail">

                            <label>Password:</label>
                            <input type="password" class="form-control" id="hospitalPassword" name="hospitalPassword">
                        </div>

                        <div id="receiverFields" class="form-group hide-fields my-3 my-2">
                            <label>Receiver name:</label>
                            <input type="text" class="form-control" id="receiverFullName" name="receiverFullName">
                            <label>Blood group:</label>
                            <select class="form-control" id="receiverBloodGroup" name="receiverBloodGroup">
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                            </select>

                            <label>Address:</label>
                            <input type="text" class="form-control" id="receiverAddress" name="receiverAddress">

                            <label>Phone number:</label>
                            <input type="text" class="form-control" id="receiverPhone" name="receiverPhone">

                            <label>Email address:</label>
                            <input type="email" class="form-control" id="receiverEmail" name="receiverEmail">

                            <label>Password:</label>
                            <input type="password" class="form-control" id="receiverPassword" name="receiverPassword">
                        </div>
                </div>
            </div>
            <div class="text-center m-3">
                <button type="submit" class="btn btn-dark">Create Account</button>
            </div>

            </form>
        </div>
    </div>
    </div>
    </div>
    <script>
    $(document).ready(function() {
        $('#userType').on('change', function() {
            if ($(this).val() == 'hospital') {
                $('#hospitalFields').show();
                $('#receiverFields').hide();
            } else if ($(this).val() == 'receiver') {
                $('#hospitalFields').hide();
                $('#receiverFields').show();
            } else {
                $('.hide-fields').hide();
            }
        });
    });
    </script>

    </div>
</body>

</html>