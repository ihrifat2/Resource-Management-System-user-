<?php
//Database Connection
require 'dbconnect.php';
//Start Session
session_start();
//Check user Authentication
if(isset($_SESSION["user_id"]) && isset($_SESSION["user_name"]) && isset($_SESSION["user_role"])){
    header("Location: index.php");
}
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
    <title>Login</title>
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
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card card-signin my-5">
                    <div class="card-body">
                        <h5 class="card-title text-center">Sign In</h5>
                        <form class="form-signin" method="post" action="">
                            <div class="form-label-group">
                                <input type="email" class="form-control" name="login_email" placeholder="Email address" autofocus>
                                <label for="inputEmail">Email address</label>
                            </div>
                            <div class="form-label-group">
                                <input type="password" class="form-control" name="login_passwd" placeholder="Password">
                                <label for="inputPassword">Password</label>
                            </div>
                            <button class="btn btn-lg btn-primary btn-block text-uppercase" name="login_btn" type="submit">Sign in</button>
                            <a class="btn btn-lg btn-success d-block text-center mt-2 small" href="registration.php">Sign Up</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
if (isset($_POST['login_btn'])) {
    //Taking input
    $login_email    = validate_input($_POST['login_email']);
    $login_passwd   = validate_input($_POST['login_passwd']);

    //Check any of the input field is empty
    if (empty($login_email) || empty($login_passwd)) {
        $notificationItemArray = array(
            'title'=>'Error!',
            'text'=>'All Fields Are Required.',
            'type'=>'error',
        );
    } else {
        //filter email
        if (filter_var($login_email, FILTER_VALIDATE_EMAIL)) {
            // get information 
            $sqlQuery       = "SELECT * FROM `tbl_userinfo` WHERE `userinfo_email` = '$login_email'";
            $result         = mysqli_query($dbconnect, $sqlQuery);
            $rows           = mysqli_fetch_array($result);
            $store_password = $rows['userinfo_passwd'];
            $userinfo_id    = $rows['userinfo_id'];
            $userinfo_uname = $rows['userinfo_uname'];
            $userinfo_role  = $rows['userinfo_role'];
            //check password in matched
            $check          = password_verify($login_passwd, $store_password);
            if ($check) {
                //store info to the session for authentication
                $_SESSION['user_id']    = $userinfo_id;
                $_SESSION['user_name']  = $userinfo_uname;
                $_SESSION['user_role']  = $userinfo_role;
                echo "<script>javascript:document.location='index.php'</script>";
            } else {
                $notificationItemArray = array(
                    'title'=>'Error!',
                    'text'=>'Email Or Password Is Invalid.',
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