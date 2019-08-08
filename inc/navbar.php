    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">Resource Management System</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>            
            <?php
                if (isset($_SESSION["user_id"]) && isset($_SESSION["user_name"]) && isset($_SESSION["user_role"])) {
            ?>
            <?php
                if ($_SESSION["user_role"] == 0) {
            ?>
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0" action="" method="post">
                <div class="input-group">
                    <input class="form-control" type="text" name="reg_code" placeholder="Course code" aria-label="Enter">
                    <div class="input-group-append">
                        <button class="btn btn-outline-success" name="reg_btn" type="submit">Enter</button>
                    </div>
                </div>
            </form>
            <?php
                }
            ?>
            <ul class="navbar-nav ml-auto ml-md-0">
                <?php
                    if ($_SESSION["user_role"] == 1) {
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="courseCreate.php">Course Create</a>
                </li>
                <?php
                    }
                ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo ucfirst($_SESSION["user_name"]); ?>
                    </a>
                    <!-- Here's the magic. Add the .animate and .slide-in classes to your .dropdown-menu and you're all set! -->
                    <div class="dropdown-menu dropdown-menu-right animate slideIn" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="profile.php">Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
            <?php
                }
            ?>
        </div>
    </nav>
<?php

if (isset($_POST['reg_btn'])) {
    $reg_code = $_POST['reg_code'];
    $uid    = $_SESSION['user_id'];
    $today  = date("Y-m-d");

    if (empty($reg_code)) {
        $notificationItemArray = array(
            'title'=>'Error!',
            'text'=>'Enrolled Code Can\'t Be Empty.',
            'type'=>'error',
        );
    } else {

        $sqlQuery   = "SELECT `course_id` FROM `tbl_course` WHERE `course_regcode` = '$reg_code'";
        $result     = mysqli_query($dbconnect, $sqlQuery);
        $rows       = mysqli_fetch_array($result);
        $cid        = $rows['course_id'];

        if ($cid) {
            $sqlQuery   = "SELECT `enroll_id` FROM `tbl_enrollinfo` WHERE `enroll_cid` = '$cid' AND `enroll_uid` = '$uid'";
            $result     = mysqli_query($dbconnect, $sqlQuery);
            $rows       = mysqli_fetch_array($result);
            $eid        = $rows['enroll_id'];
            if ($eid) {
                $notificationItemArray = array(
                    'title'=>'Error!',
                    'text'=>'You Have Already Enrolled To This Course.',
                    'type'=>'error',
                );
            } else {
                $enrollQuery = "INSERT INTO `tbl_enrollinfo`(`enroll_id`, `enroll_cid`, `enroll_uid`, `enroll_create`) VALUES (NULL,'$cid','$uid','$today')";
                $enrollResult = $dbconnect->query($enrollQuery);
                if ($enrollResult) {
                    $notificationItemArray = array(
                        'title'=>'Success!',
                        'text'=>'Your Successfully Enrolled To This Course.',
                        'type'=>'success',
                    );
                    echo "<script>javascript:document.location='index.php'</script>";
                } else {
                    $notificationItemArray = array(
                        'title'=>'Error!',
                        'text'=>'Failed To Enrolled In This Course.',
                        'type'=>'error',
                    );
                }
            }
        } else {
            $notificationItemArray = array(
                'title'=>'Error!',
                'text'=>'Enrolled Code Not Found.',
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

?>