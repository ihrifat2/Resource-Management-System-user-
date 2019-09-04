<?php
//Database Connection
require 'dbconnect.php';
//Start Session
session_start();
//Check user Authentication
include 'inc/auth.php';
$userId = $_SESSION['user_id'];
$userRoll = $_SESSION['user_role'];
//collect info from DB
$sql    = "SELECT * FROM `tbl_userinfo` WHERE `userinfo_id` = '$userId' AND `userinfo_role` = '$userRoll'";
$rslt   = mysqli_query($dbconnect, $sql);
$row    = mysqli_fetch_assoc($rslt);
$name   = $row['userinfo_name'];
$uname  = $row['userinfo_uname'];
$rollid = $row['userinfo_rollid'];
$email  = $row['userinfo_email'];
$status = $row['userinfo_status'];
function getStatus($value) {
    $result = '';
    if ($value == 0) {
        $result = 'Activated';
    } else {
        $result = 'Deactivated';
    }
    return $result;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>DashBoard</title>
    <script src="assets/js/jquery.slim.min.js"></script>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/all.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/sweetalert.min.js"></script>
</head>
<body>
    <!-- Navbar Start -->
    <?php include 'inc/navbar.php'; ?>
    <!-- Navbar End -->

    <div class="container">
        <!-- show user profile info -->
        <div class="row my-4">
            <div class="col-md-8 userProfile">
                <h3 class="my-3">Profile Details</h3>
                <ul>
                    <li>Name : <?php echo $name; ?></li>
                    <li>Username : <?php echo $uname; ?></li>
                    <li>Roll/ID : <?php echo $rollid; ?></li>
                    <li>Email : <?php echo $email; ?></li>
                    <li>Status : <?php echo getStatus($status); ?></li>
                </ul>
            </div>
            <div class="col-md-4">
                <!-- <img class="img-fluid" src="http://placehold.it/750x500" alt=""> -->
            </div>
        </div>
        <div class="row">
            <!-- password change -->
            <div class="col-md-6">
                <form method="post" action="">
                    <div class="form-group">
                        <label>Old Password</label>
                        <input type="password" class="form-control" name="passChng_oldpass" placeholder="Old Password">
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" class="form-control" name="passChng_newpass" placeholder="New Password">
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" name="passChng_conpass" placeholder="Confirm Password">
                    </div>
                    <button type="submit" class="btn btn-primary" name="passChng_btn">Submit</button>
                </form>
            </div>
            <!-- Name And Username change -->
            <div class="col-md-6">
                <form method="post" action="">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" class="form-control" name="userinfo_fname" placeholder="Full Name">
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" name="userinfo_uname" placeholder="Username">
                    </div>
                    <button type="submit" class="btn btn-primary" name="userinfo_btn">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        if (window.parent && window.parent.parent){
            window.parent.parent.postMessage(["resultsFrame", {
                height: document.body.getBoundingClientRect().height,
                slug: "o7ev9czn"
            }], "*")
        }
        window.name = "result"
    </script>
</body>
</html>
<?php

if (isset($_POST['userinfo_btn'])) {
    //Taking input
    $fname = $_POST['userinfo_fname'];
    $uname = $_POST['userinfo_uname'];
    //update user info
    $sql    = "UPDATE `tbl_userinfo` SET `userinfo_name`='$fname',`userinfo_uname`='$uname' WHERE `userinfo_id` = '$userId'";
    $rslt   = mysqli_query($dbconnect, $sql);
    if ($rslt) {
        $notificationItemArray = array(
            'title'=>'Success!',
            'text'=>'Profile Information Changed.',
            'type'=>'success',
        );
    } else {
        $notificationItemArray = array(
            'title'=>'Error!',
            'text'=>'Invalid Email Format.',
            'type'=>'error',
        );
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

if (isset($_POST['passChng_btn'])) {
    //Taking input
    $oldpass = $_POST['passChng_oldpass'];
    $newpass = $_POST['passChng_newpass'];
    $conpass = $_POST['passChng_conpass'];
    // get information for check old password
    $passchgQuery   = "SELECT * FROM `tbl_userinfo` WHERE `userinfo_id` = '$userId'";
    $passchgResult  = mysqli_query($dbconnect, $passchgQuery);
    $passchgRows    = mysqli_fetch_array($passchgResult);
    $admin_paswd    = $passchgRows['userinfo_passwd'];
    //checking old password
    $check          = password_verify($oldpass, $admin_paswd);
    if ($check) {
        //check both password is match
        if ($newpass == $conpass) {
            //encrypt password
            $password   = password_hash($conpass, PASSWORD_BCRYPT);
            //updating user password
            $sql    = "UPDATE `tbl_userinfo` SET `userinfo_passwd`='$password' WHERE `userinfo_id` = '$userId'";
            $rslt   = mysqli_query($dbconnect, $sql);
            if ($rslt) {
                $notificationItemArray = array(
                    'title'=>'Success!',
                    'text'=>'Password Changed.',
                    'type'=>'success',
                );
            } else {
                $notificationItemArray = array(
                    'title'=>'Error!',
                    'text'=>'Failed To Changed Password.',
                    'type'=>'error',
                );
            }
        } else {
            $notificationItemArray = array(
                'title'=>'Error!',
                'text'=>'New Password And Confirm Password Not Matched.',
                'type'=>'error',
            );
        }
    } else {
        $notificationItemArray = array(
            'title'=>'Error!',
            'text'=>'Old Password Not Matched.',
            'type'=>'error',
        );
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