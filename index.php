<?php
//Database Connection
require 'dbconnect.php';
//Start Session
session_start();
//Check user Authentication
include 'inc/auth.php';
$userId = $_SESSION['user_id'];
$userRoll = $_SESSION['user_role'];
//store course info
$courseData = array();
if ($userRoll == 1) {
    //if user login as a faculty member
    //store info regarding user id
    $courseQuery = "SELECT * FROM `tbl_course` WHERE `course_creatorid` = '$userId' ORDER BY `course_id` DESC";
    $courseResult = $dbconnect->query($courseQuery);
    if ($courseResult) {
        while ($courseRows = $courseResult->fetch_array(MYSQLI_ASSOC)) {
            $courseData[] = $courseRows;
        }
        $courseResult->close();
    }
} else {
    //if user login as a student
    //get enroll course info by checking the student user id
    $courseQuery = "SELECT * FROM `tbl_course` INNER JOIN `tbl_enrollinfo` ON `tbl_course`.`course_id` = `tbl_enrollinfo`.`enroll_cid` WHERE `tbl_enrollinfo`.`enroll_uid` = '$userId' ORDER BY `tbl_enrollinfo`.`enroll_id` DESC";
    $courseResult = $dbconnect->query($courseQuery);
    if ($courseResult) {
        while ($courseRows = $courseResult->fetch_array(MYSQLI_ASSOC)) {
            $courseData[] = $courseRows;
        }
        $courseResult->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
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

        <!-- Page Heading -->
        <h1 class="my-4">Cources List
            <!-- <small>Secondary Text</small -->
        </h1>

        <div class="row">
            <?php
            //print all the course info
            foreach ($courseData as $courseRow) {
                if ($userRoll == 1) {
                    $link = "faculty.php?courseid=" . $courseRow['course_id'];
            ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card-content">
                        <div class="card-img">
                            <img src="https://placeimg.com/380/230/nature" alt="">
                            <span>
                                <h4><?php echo $courseRow['course_title']; ?></h4>
                                <p><?php echo $courseRow['course_code']; ?></p>
                                <p><?php echo $courseRow['course_faculty']; ?></p>
                            </span>
                        </div>
                        <div class="card-desc">
                            <a href="<?php echo $link; ?>" class="btn-card">Read</a>
                        </div>
                    </div>
                </div>
            <?php
                } else {
                    $link = "course.php?courseid=" . $courseRow['course_id'];
            ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card-content">
                        <div class="card-img">
                            <img src="https://placeimg.com/380/230/nature" alt="">
                            <span>
                                <h4><?php echo $courseRow['course_title']; ?></h4>
                                <p><?php echo $courseRow['course_code']; ?></p>
                            </span>
                        </div>
                        <div class="card-desc">
                            <a href="<?php echo $link; ?>" class="btn-card">Read</a>
                        </div>
                    </div>
                </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
<?php
include 'inc/notification.php';
?>