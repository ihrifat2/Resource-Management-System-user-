<?php
require 'dbconnect.php';
session_start();
require 'helper.php';
require 'sqlhelper.php';

$today = date("Y-m-d");
$uid = $_SESSION['user_id'];
$cid = $_GET['courseid'];

// getting course title from course id
$cnameQuery     = "SELECT `course_title` FROM `tbl_course` WHERE `course_id` = '$cid'";
$cnameResult    = $dbconnect->query($cnameQuery);
$cnameRow       = $cnameResult->fetch_array(MYSQLI_ASSOC);
$cname          = $cnameRow['course_title'];

// getting enroll id from enroll course id and enroll user id 
$findRegCourseQuery     = "SELECT `enroll_id` FROM `tbl_enrollinfo` WHERE `enroll_cid` = '$cid' AND `enroll_uid` = '$uid'";
$findRegCourseResult    = $dbconnect->query($findRegCourseQuery);
$findRegCourseRow       = $findRegCourseResult->fetch_array(MYSQLI_ASSOC);
$uid = $findRegCourseRow['enroll_id'];
$courseDetailsData = array();
//if student is registered to the course then store all activity from DB
if ($uid) {
    $courseDetailsQuery = "SELECT * FROM `tbl_post` WHERE `post_cid` = '$cid' ORDER BY `post_id` DESC";
    $courseDetailsResult = $dbconnect->query($courseDetailsQuery);
    if ($courseDetailsResult) {
        while ($courseDetailsRows = $courseDetailsResult->fetch_array(MYSQLI_ASSOC)) {
            $courseDetailsData[] = $courseDetailsRows;
        }
        $courseDetailsResult->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Course Details</title>
    <script src="assets/js/jquery.slim.min.js"></script>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/all.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar Start -->
    <?php include 'inc/navbar.php'; ?>
    <!-- Navbar End -->

    <div class="container">
        <h1 class="my-4">Course Name : <?php echo getFirstWord($cname); ?> </h1>

        <h3 class="my-4">Course Activity</h3>

        <!--- \\\\\\\Post-->
        <?php
        //if course activity found
        if (count($courseDetailsData) > 1) {
            //print all the course activity
            foreach ($courseDetailsData as $courseDetailsRow) {
        ?>
        <div class="card gedf-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="mr-2">
                            <img class="rounded-circle" width="45" src="https://picsum.photos/50/50" alt="">
                        </div>
                        <div class="ml-2">
                            <div class="h5 m-0">@<?php echo getFacultyUsername($courseDetailsRow["post_fid"]); ?></div>
                            <div class="h7 text-muted"><?php echo getFacultyFullname($courseDetailsRow["post_fid"]); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="text-muted h7 mb-2">
                    <i class="fa fa-clock-o"></i>
                    <?php echo momentAgo($courseDetailsRow["post_create"], $today); ?>
                </div>
                <p class="card-text">
                    <?php echo $courseDetailsRow["post_text"]; ?>
                    <br>
                    Download file from 
                    <a href="download.php?filename=<?php echo $courseDetailsRow["post_file"]; ?>" target="_blank">here</a>
                </p>
            </div>
        </div>
        <hr>
        <?php
            }
        } else {
        ?>
        <div class="card gedf-card">
            <div class="card-header">
                <p>No Activity Found.</p>
            </div>
        </div>
        <?php
        }
        ?>
        <!-- Post /////-->

        <!-- Pagination -->
        <!-- <ul class="pagination justify-content-center">
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">1</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">2</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">3</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul> -->
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
