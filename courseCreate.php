<?php
//Database Connection
require 'dbconnect.php';
//Start Session
session_start();
//Check user Authentication
include 'inc/auth.php';
require 'helper.php';
$userRoll = $_SESSION['user_role'];
//if block access to this page from student
if ($userRoll != 1) {
    echo "<script>javascript:document.location='index.php'</script>";
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
    <title>Course Create</title>
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
        <h1 class="my-4">Create New Course
            <!-- <small>Secondary Text</small -->
        </h1>
        <div class="row">
            <div class="col-md-8">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Faculty Name</label>
                        <input type="text" class="form-control" name="faculty_name" placeholder="Faculty Name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Course Title</label>
                        <input type="text" class="form-control" name="Course_title" placeholder="Course Title">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Course Code</label>
                        <input type="text" class="form-control" name="Course_code" placeholder="Course Code">
                    </div>
                    <button type="submit" class="btn btn-primary" name="Course_btn">Submit</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php
if (isset($_POST['Course_btn'])) {
    //Taking input
    $faculty_name   = validate_input($_POST['faculty_name']);
    $Course_title   = validate_input($_POST['Course_title']);
    $Course_code    = validate_input($_POST['Course_code']);
    $Course_code    = strtoupper($Course_code);
    $today = date("Y-m-d");
    $course_creator = $_SESSION['user_id'];
    $courseRandomCode = createRandomPassword();

    //Check any of the input field is empty
    if (empty($faculty_name) || empty($Course_title) || empty($Course_code)) {
        $notificationItemArray = array(
            'title'=>'Error!',
            'text'=>'All Fields Are Required.',
            'type'=>'error',
        );
    } else {
        //storing info to DB
        $sqlQuery   = "INSERT INTO `tbl_course`(`course_id`, `course_creatorid`, `course_faculty`, `course_title`, `course_code`, `course_regcode`, `course_create`) VALUES (NULL,'$course_creator','$faculty_name','$Course_title','$Course_code','$courseRandomCode','$today')";
        $result     = mysqli_query($dbconnect, $sqlQuery);
        if ($result) {
            $notificationItemArray = array(
                'title'=>'Success!',
                'text'=>'New Course Created.',
                'type'=>'success',
            );
            echo "<script>javascript:document.location='index.php'</script>";
        } else {
            $notificationItemArray = array(
                'title'=>'Error!',
                'text'=>'Failure To Created New Course.',
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
?>