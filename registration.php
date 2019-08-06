<?php
require 'dbconnect.php';
session_start();
if(isset($_SESSION["sdt_id"]) && isset($_SESSION["sdt_name"]) && isset($_SESSION["sdt_role"])){
    header("Location: index.php");
}
function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = addslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration</title>
    <script src="assets/js/jquery.slim.min.js"></script>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/all.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/sweetalert.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-xl-9 mx-auto">
                <div class="card card-signin flex-row my-5">
                    <div class="card-img-left d-none d-md-flex">
                        <!-- Background image for card set in CSS! -->
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-center">Register</h5>
                        <form class="form-signin" method="post" action="">
                            <div class="form-label-group">
                                <input type="text" class="form-control" name="reg_fullname" placeholder="Full Name" autofocus>
                                <label for="inputUserame">Full Name</label>
                            </div>
                            <div class="form-label-group">
                                <input type="text" class="form-control" name="reg_uname" placeholder="Username">
                                <label for="inputUserame">Username</label>
                            </div>
                            <div class="form-label-group">
                                <input type="text" class="form-control" name="reg_sdtId" placeholder="Student ID">
                                <label for="inputStudentID">Student ID</label>
                            </div>
                            <div class="form-label-group">
                                <input type="email" class="form-control" name="reg_email" placeholder="Email address">
                                <label for="inputEmail">Email address</label>
                            </div>
                            <div class="form-label-group">
                                <input type="password" class="form-control" name="reg_newPasswd" placeholder="Password">
                                <label for="inputPassword">Password</label>
                            </div>
                            <div class="form-label-group">
                                <input type="password" class="form-control" name="reg_conPasswd" placeholder="Password">
                                <label for="inputConfirmPassword">Confirm password</label>
                            </div>
                            <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit" name="reg_btn">Register</button>
                            <a class="btn btn-lg btn-success d-block text-center mt-2 small" href="login.php">Sign In</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
if (isset($_POST['reg_btn'])) {
    $reg_fullname   = validate_input($_POST['reg_fullname']);
    $reg_uname      = validate_input($_POST['reg_uname']);
    $reg_sdtId      = validate_input($_POST['reg_sdtId']);
    $reg_email      = validate_input($_POST['reg_email']);
    $reg_newPasswd  = validate_input($_POST['reg_newPasswd']);
    $reg_conPasswd  = validate_input($_POST['reg_conPasswd']);
    $today = date("Y-m-d");

    if (empty($reg_fullname) || empty($reg_uname) || empty($reg_sdtId) || empty($reg_email) || empty($reg_newPasswd) || empty($reg_conPasswd)) {
        $notificationItemArray = array(
            'title'=>'Error!',
            'text'=>'All Fields Are Required.',
            'type'=>'error',
        );
    } else {
        if (filter_var($reg_email, FILTER_VALIDATE_EMAIL)) {
            if ($reg_newPasswd == $reg_conPasswd) {
                $passwd     = password_hash($reg_newPasswd, PASSWORD_BCRYPT);
                $sqlQuery   = "INSERT INTO `tbl_sdtinfo`(`sdtinfo_id`, `sdtinfo_name`, `sdtinfo_uname`, `sdtinfo_rollid`, `sdtinfo_email`, `sdtinfo_passwd`, `sdtinfo_create`) VALUES (NULL,'$reg_fullname','$reg_uname','$reg_sdtId','$reg_email','$passwd','$today')";
                $result = mysqli_query($dbconnect, $sqlQuery);
                if ($result) {
                    $notificationItemArray = array(
                        'title'=>'Success!',
                        'text'=>'Registration Successfull.',
                        'type'=>'success',
                    );
                } else {
                    $notificationItemArray = array(
                        'title'=>'Error!',
                        'text'=>'An Unexpected Error Occured.',
                        'type'=>'error',
                    );
                }
            } else {
                $notificationItemArray = array(
                    'title'=>'Error!',
                    'text'=>'Password Not Matched.',
                    'type'=>'error',
                );
            }
        } else {
            $notificationItemArray = array(
                'title'=>'Error!',
                'text'=>'Invalid Email Format.',
                'type'=>'error',
            );
        }
    }
    if(!empty($_SESSION["notification_item"])) {
        if(in_array($RMSNotification["notification"],array_keys($_SESSION["notification_item"]))) {
            foreach($_SESSION["notification_item"] as $k => $v) {
                if($RMSNotification["notification"] == $k) {
                    if(empty($_SESSION["notification_item"][$k]["type"])) {
                        $_SESSION["notification_item"][$k]["type"] = 0;
                    }
                    $_SESSION["notification_item"][$k]["type"] += 'danger';
                }
            }
        } else {
            $_SESSION["notification_item"] = array_merge($_SESSION["notification_item"],$notificationItemArray);
        }
    } else {
        $_SESSION["notification_item"] = $notificationItemArray;
    }
}
include 'inc/notification.php';
?>