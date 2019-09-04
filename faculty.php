<?php
//Database Connection
require 'dbconnect.php';
//Start Session
session_start();
//Check user Authentication
include 'inc/auth.php';
require 'helper.php';
require 'sqlhelper.php';
$today = date("Y-m-d");
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
//if courseid is in parameter
if (isset($_GET['courseid'])) {
    $courseid = $_GET['courseid'];
    $userId = $_SESSION['user_id'];
    //storing all the information to the array 
    $courseDetailsData = array();
    $courseDetailsQuery = "SELECT * FROM `tbl_post` WHERE `post_fid` = '$userId' AND `post_cid` = '$courseid' ORDER BY `post_id` DESC";
    $courseDetailsResult = $dbconnect->query($courseDetailsQuery);
    if ($courseDetailsResult) {
        while ($courseDetailsRows = $courseDetailsResult->fetch_array(MYSQLI_ASSOC)) {
            $courseDetailsData[] = $courseDetailsRows;
        }
        $courseDetailsResult->close();
    }
} else {
    echo "<script>javascript:document.location='error.html'</script>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Course Details</title>
    <script src="assets/js/jquery.slim.min.js"></script>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/all.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/sweetalert.min.js"></script>
    <style>
        .main_area{margin:0 auto; width:400; text-align:center; margin-top:200px;}
        .main_area a{ text-decoration:none;}
        .main_area span{font-size:25px; background:#df4662; color:#FFFFFF; padding:5px 10px; border:1px solid bc344d; border-radius:5px;}
    </style>
</head>
<body>
    <!-- Navbar Start -->
    <?php include 'inc/navbar.php'; ?>
    <!-- Navbar End -->
    <div class="container my-4">
        <!-- Page Heading -->
        <div class="row my-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="h5"><?php echo getFacultyFullname($userId); ?></div>
                        <div class="h7">Course Name : <?php echo getCourseName($courseid); ?></div>
                        <div class="h7 text-muted">Course Code : <?php echo getCourseCode($courseid); ?></div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="h6 text-muted">Course Follower</div>
                            <div class="h5"><?php echo getCourseFollower($courseid); ?></div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 gedf-main">

                <!--- \\\\\\\Post-->
                <div class="card gedf-card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="posts-tab" data-toggle="tab" href="#posts" role="tab" aria-controls="posts" aria-selected="true">
                                    Post Details
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="images-tab" data-toggle="tab" role="tab" aria-controls="images" aria-selected="false" href="#images">File</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                                    <div class="form-group">
                                        <label class="sr-only" for="message">post</label>
                                        <textarea class="form-control" name="post_text" rows="3" placeholder="What are you thinking?"></textarea>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
                                    <div class="form-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="post_image">
                                            <label class="custom-file-label" for="customFile">Upload File</label>
                                        </div>
                                    </div>
                                    <div class="py-4"></div>
                                </div>
                            </div>
                            <div class="btn-toolbar justify-content-between">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" name="post_btn">Share</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Post /////-->

                <!--- \\\\\\\Post-->
                <?php
                //print all the course Details
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
                ?>
                <!-- Post /////-->

            </div>
            <div class="col-md-3">
                <div class="card gedf-card">
                    <div class="card-body">
                        <h5 class="card-title">Registration Code</h5>
                        <p class="card-text"><?php echo getCourseRegCode($courseid); ?></p>
                    </div>
                </div>
                <!-- <div class="card gedf-card">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                            card's content.</p>
                        <a href="#" class="card-link">Card link</a>
                        <a href="#" class="card-link">Another link</a>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</body>
</html>
<?php
if (isset($_POST['post_btn'])) {
    //Taking input
    $post_text  = validate_input($_POST['post_text']);

    //Processing image
    $target_dir     = 'assets/post/'; 
    $filename       = $_FILES[ 'post_image' ][ 'name' ];
    $image_tmp      = $_FILES[ 'post_image' ][ 'tmp_name' ];
    $image_ext      = substr( $filename, strrpos( $filename, '.' ) + 1);
    $post_image     = "p_" . md5( uniqid() . $filename ) . '.' . $image_ext;
    $target_file    = $target_dir . $post_image;

    //Check any of the input field is empty
    if (empty($post_text) || empty($post_image)) {
        $notificationItemArray = array(
            'title'=>'Error!',
            'text'=>'All Fields Are Required.',
            'type'=>'error',
        );
    } else {
        //check image is uploaded or not
        if( !move_uploaded_file( $image_tmp, $target_file ) ) {
            $notificationItemArray = array(
                'title'=>'Error!',
                'text'=>'Image not Uploaded.',
                'type'=>'error',
            );
        } else {
            //storing info to DB
            $sqlQuery   = "INSERT INTO `tbl_post`(`post_id`, `post_cid`, `post_fid`, `post_text`, `post_file`, `post_create`) VALUES (NULL,'$courseid','$userId','$post_text','$post_image','$today')";
            $result     = mysqli_query($dbconnect, $sqlQuery);
            if ($result) {
                $notificationItemArray = array(
                    'title'=>'Success!',
                    'text'=>'New Course Created.',
                    'type'=>'success',
                );
                // echo "<script>javascript:document.location='index.php'</script>";
            } else {
                $notificationItemArray = array(
                    'title'=>'Error!',
                    'text'=>'Failure To Created New Course.',
                    'type'=>'error',
                );
            }
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