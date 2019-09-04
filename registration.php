<?php
//Database Connection
require 'dbconnect.php';
//Start Session
session_start();
//Check user Authentication
if(isset($_SESSION["user_id"]) && isset($_SESSION["user_name"]) && isset($_SESSION["user_role"])){
    header("Location: index.php");
}
require 'sqlhelper.php';
//validate user input
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
                                <input type="text" class="form-control" name="reg_fullname" autofocus>
                                <label for="inputUserame">Full Name</label>
                            </div>
                            <div class="form-label-group">
                                <input type="text" class="form-control" name="reg_uname">
                                <label for="inputUserame">Username</label>
                            </div>
                            <div class="form-label-group">
                                <input type="text" class="form-control" name="reg_sdtId">
                                <label for="inputStudentID">Student ID</label>
                            </div>
                            <div class="form-label-group">
                                <input type="email" class="form-control" name="reg_email">
                                <label for="inputEmail">Email address</label>
                            </div>
                            <div class="form-label-group">
                                <input type="password" class="form-control" name="reg_newPasswd">
                                <label for="inputPassword">Password</label>
                            </div>
                            <div class="form-label-group">
                                <input type="password" class="form-control" name="reg_conPasswd">
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
    //Taking input
    $reg_fullname   = validate_input($_POST['reg_fullname']);
    $reg_fullname   = ucwords($reg_fullname);
    $reg_uname      = validate_input($_POST['reg_uname']);
    $reg_sdtId      = validate_input($_POST['reg_sdtId']);
    $reg_email      = validate_input($_POST['reg_email']);
    $reg_newPasswd  = validate_input($_POST['reg_newPasswd']);
    $reg_conPasswd  = validate_input($_POST['reg_conPasswd']);
    $today = date("Y-m-d");

    //Check any of the input field is empty
    if (empty($reg_fullname) || empty($reg_uname) || empty($reg_sdtId) || empty($reg_email) || empty($reg_newPasswd) || empty($reg_conPasswd)) {
        $notificationItemArray = array(
            'title'=>'Error!',
            'text'=>'All Fields Are Required.',
            'type'=>'error',
        );
    } else {
        //filter email
        if (filter_var($reg_email, FILTER_VALIDATE_EMAIL)) {
            if (checkEmail($reg_email) == 0) {
                //check both password is match
                if ($reg_newPasswd == $reg_conPasswd) {
                    //encrypt password
                    $passwd     = password_hash($reg_newPasswd, PASSWORD_BCRYPT);
                    //storing info to DB
                    $sqlQuery   = "INSERT INTO `tbl_userinfo`(`userinfo_id`, `userinfo_name`, `userinfo_uname`, `userinfo_rollid`, `userinfo_email`, `userinfo_passwd`, `userinfo_create`) VALUES (NULL,'$reg_fullname','$reg_uname','$reg_sdtId','$reg_email','$passwd','$today')";
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
                    'text'=>'Email Already Registered.',
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
    //storing notification to session
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
//show notification from session
include 'inc/notification.php';
?>