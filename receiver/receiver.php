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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Bank System</title>
    <link rel="shortcut icon" href="../image1.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<style>
.home {
    position: relative;
    width: 100%;
    margin-bottom: 30px;
}

.home img {
    margin: 0;
    width: 100%;
    display: block;
}

.button-container {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
}

.button-container button {
    margin: 10px;
    padding: 10px 20px;
    font-size: 16px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
</style>

<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid"><img src="../image1.png" alt="" style="width:70px;margin-right:10px">
            <a class="navbar-brand" href="#">
                Blood Bank </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="receiver.php">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="#available">Available Blood</a>
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

    <div class="home">
        <img src="../image1.png" alt="">
        <div class="button-container">
            <a href='#available' class="btn  m-2">Available Blood</a>
        </div>
    </div>

    <div class="m-4">
        <h1 class="text-center mb-4">Blood Bank Management System</h1>
        <div class="m-4">
        <span class="p-4 m-4 text-center">

The Blood Bank Management System is a vital tool for
efficiently managing distribution.
 It enables easy tracking of blood types,
  and recipient needs, ensuring timely access
 to blood products. With features like blood type compatibility checks, and
 request processing, it streamlines operations and
improves patient care.
</span>
        </div>
        <h2 class="text-center mt-4 "style="margin-top:40px">Blood Compatibilities</h2>
        <div class="table-responsive m-4 d-flex justify-content-center">
            <table class="table table-bordered table-hover text-center table-sm" style="max-width: 600px;">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>Blood Type</th>
                        <th>Donate Blood To</th>
                        <th>Receive Blood From</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>A+</th>
                        <td>A+ AB+</td>
                        <td>A+ A- O+ O-</td>
                    </tr>
                    <tr>
                        <th>A-</th>
                        <td>A+ A- AB+ AB-</td>
                        <td>A- O-</th>
                    </tr>
                    <tr>
                        <th>B+</th>
                        <td>B+ AB+</td>
                        <td>B+ B- O+ O-</td>
                    </tr>
                    <tr>
                        <th>B-</th>
                        <td>B+ B- AB+ AB-</td>
                        <td>B- O-</td>
                    </tr>
                    <tr>
                        <th>AB+</th>
                        <td>AB+</td>
                        <td>Everyone</td>
                    </tr>
                    <tr>
                        <th>AB-</th>
                        <td>AB+ AB- </td>
                        <td>AB- A- B- O-</td>
                    </tr>
                    <tr>
                        <th> O+</th>
                        <td>O+ A+ B+ AB+</td>
                        <td>O+ O-</td>
                    </tr>
                    <tr>
                        <th>O-</th>
                        <td>Everyone</td>
                        <td>O-</td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

    <div class="container">
        <div class="text-center m-2 mb-4" id="available">
            <h1>Available Blood</h1>
        </div>

        <?php
        $compatibility = [
            "A+" => ["A+", "O+", "A-", "O-"],
            "O+" => ["O+", "O-"],
            "B+" => ["B+", "O+", "B-", "O-"],
            "AB+" => ["A+", "B+", "AB+", "O+", "A-", "B-", "AB-", "O-"],
            "A-" => ["A-", "O-"],
            "O-" => ["O-"],
            "B-" => ["B-", "O-"],
            "AB-" => ["A-", "B-", "AB-", "O-"],
        ];
        require("../config.php");
        $user_id = $_SESSION["user_id"];
        $sql = "SELECT receiver_id,blood_group FROM receiver WHERE user_id= $user_id;";
        $data = $conn->query($sql)->fetch_assoc();
        $receiver_id = $data['receiver_id'];
        $receiver_blood_group = $data['blood_group'];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_REQUEST['request'])) {
                $blood_info_id = $_REQUEST['bloodId'];
                $request_date = date("Y/m/d");
                $sql = "INSERT INTO request(receiver_id, blood_info_id, request_date) VALUES ($receiver_id, $blood_info_id, '$request_date');";
                if ($conn->query($sql)) {
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>";
                    echo "Request Sent Successfully</div>";
                } else {
                    echo "Request Failed";
                }
            }
        }
        ?>
        <div class="table-responsive">
            <table class='table  table-bordered table-hover text-center'>
                <thead class="bg-danger text-white">
                    <tr>
                        <th>S.No</th>
                        <th>Hospital</th>
                        <th>Hospital Contact</th>
                        <th>Blood Type</th>
                        <th>Expiration Date</th>
                        <th>Request Blood Sample</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th> <input class="form-control" id="hospitalSearch" type="text" name="hospital_query"
                                placeholder="Search Hospital"></th>
                        <th> </th>
                        <th><select class="form-control" id="bloodTypeSearch" name="blood_type_query">
                                <option value="">Select Blood Type</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                            </select></th>
                        <th><input class="form-control" id="expirationDateSearch" type="date" name="expiration_query"
                                placeholder="Search Expiration Date"></th>
                        <th> </th>


                    </tr>
                </thead>
                <?php
                $limit = 10;
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $start = ($page - 1) * $limit;

                $totalRecordsQuery = "SELECT COUNT(*) AS total FROM add_blood";
                $totalRecordsResult = $conn->query($totalRecordsQuery);
                $totalRecords = $totalRecordsResult->fetch_assoc()['total'];

                $sql = "SELECT * FROM add_blood ORDER BY blood_info_id DESC LIMIT $start, $limit";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $i = $start + 1;
                    while ($row = $result->fetch_assoc()) {
                        $hospital_query = "SELECT * FROM hospital WHERE hospital_id = {$row['hospital_id']};";
                        $hospital_details = $conn->query($hospital_query)->fetch_assoc();
                        echo "<tr class='data-row'>";
                        echo "<td>" . $i . "</td>";
                        echo <<<details
                        <td class='hospital'>{$hospital_details['hospital_name']}<br>{$hospital_details['address']}  </td>
                        details;
                        echo <<<details
                        <td class='hospital'> {$hospital_details['phone_number']}</td>
                        details;
                        echo "<td class='blood-type'>" . $row["blood_type"] . "</td>";
                        echo "<td class='expiration-date'>" . $row["expiration_date"] . "</td>";
                        if (in_array($row["blood_type"], $compatibility[$receiver_blood_group])) {
                            $request_query = "SELECT receiver_id,blood_info_id FROM request WHERE receiver_id = $receiver_id;";

                            $request_query_result = $conn->query($request_query);
                            if ($request_query_result->num_rows > 0) {
                                $flag = 0;
                                while ($request_details = $request_query_result->fetch_assoc()) {
                                    if ($row['blood_info_id'] == $request_details['blood_info_id']) {
                                        $flag = 1;
                                    }
                                }
                                if ($flag == 0) {
                                    echo "<td><form action='' method='POST'><button class='btn btn-primary' type='submit'
                                     name='request'>Request</button><input type='hidden' value={$row['blood_info_id']} 
                                     name='bloodId' ></form></td>";
                                } else {
                                    echo "<td><span style='color: green;'>Already Requested</span></td>";
                                }
                            } else {
                                echo "<td><form action='' method='POST'><button class='btn btn-primary' type='submit' 
                                name='request'>Request</button><input type='hidden' value={$row['blood_info_id']} 
                                name='bloodId' ></form></td>";
                            }
                        } else {
                            echo "<td><span style='color: red;'> $receiver_blood_group is not compatible with {$row['blood_type']} </span></td>";
                        }
                        echo "</tr>";
                        $i++;
                    }
                    echo "</table>";
                } else {
                    echo "No blood samples available.";
                }
                ?>
            </table>
        </div>

        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php
                $totalPages = ceil($totalRecords / $limit);

                for ($i = 1; $i <= $totalPages; $i++) {
                    echo "<li class='page-item'><a class='page-link' href='?page=$i'>$i</a></li>";
                }
                ?>
            </ul>
        </nav>
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
    <script src="receiver.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>