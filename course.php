<?php
require 'helper.php';
$string = "My milkshake brings all the boys to the yard";
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
        <div class="row mt-3">
            <div class="col-md-5" style="position: relative; border: 1px solid black;">
                <h1 class="text-center" style="position: absolute; top: 0; bottom: 0; left: 0; right: 0; width: 50%; height: 30%; margin: auto;">
                    <?php 
                        echo getFirstWord($string);
                    ?>
                </h1>
            </div>
            <div class="col-md-7">
                <h3 class="my-3">Course Description</h3>
                <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae. Sed dui lorem, adipiscing in adipiscing et, interdum nec metus. Mauris ultricies, justo eu convallis placerat, felis enim.</p>
            </div>
        </div>

        <h3 class="my-4">Course Activity</h3>

        <!--- \\\\\\\Post-->
        <div class="card gedf-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="mr-2">
                            <img class="rounded-circle" width="45" src="https://picsum.photos/50/50" alt="">
                        </div>
                        <div class="ml-2">
                            <div class="h5 m-0">Miracles Lee Cross</div>
                        </div>
                    </div>
                    <div class="activity">
                        <div class="dropdown">
                            <button class="btn btn-link dropdown-toggle" type="button" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-ellipsis-h"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="gedf-drop1">
                                <div class="h6 dropdown-header">Configuration</div>
                                <a class="dropdown-item" href="#">Save</a>
                                <a class="dropdown-item" href="#">Hide</a>
                                <a class="dropdown-item" href="#">Report</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <div class="text-muted h7 mb-2"> <i class="fa fa-clock-o"></i>10 min ago</div>
                <a class="card-link" href="#">
                    <h5 class="card-title">Lorem ipsum dolor sit amet, consectetur adip.</h5>
                </a>

                <p class="card-text">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo recusandae nulla rem eos ipsa praesentium esse magnam nemo dolor
                    sequi fuga quia quaerat cum, obcaecati hic, molestias minima iste voluptates.
                </p>
            </div>
            <div class="card-footer">
                <a href="#" class="card-link"><i class="fa fa-gittip"></i> Like</a>
                <a href="#" class="card-link"><i class="fa fa-comment"></i> Comment</a>
            </div>
        </div>
        <hr>
        <!-- Post /////-->


        <!--- \\\\\\\Post-->
        <div class="card gedf-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="mr-2">
                            <img class="rounded-circle" width="45" src="https://picsum.photos/50/50" alt="">
                        </div>
                        <div class="ml-2">
                            <div class="h5 m-0">Miracles Lee Cross</div>
                        </div>
                    </div>
                    <div class="activity">
                        <div class="dropdown">
                            <button class="btn btn-link dropdown-toggle" type="button" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-ellipsis-h"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="gedf-drop1">
                                <div class="h6 dropdown-header">Configuration</div>
                                <a class="dropdown-item" href="#">Save</a>
                                <a class="dropdown-item" href="#">Hide</a>
                                <a class="dropdown-item" href="#">Report</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <div class="text-muted h7 mb-2"> <i class="fa fa-clock-o"></i>10 min ago</div>
                <a class="card-link" href="#">
                    <h5 class="card-title">Lorem ipsum dolor sit amet, consectetur adip.</h5>
                </a>

                <p class="card-text">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo recusandae nulla rem eos ipsa praesentium esse magnam nemo dolor
                    sequi fuga quia quaerat cum, obcaecati hic, molestias minima iste voluptates.
                </p>
            </div>
            <div class="card-footer">
                <a href="#" class="card-link"><i class="fa fa-gittip"></i> Like</a>
                <a href="#" class="card-link"><i class="fa fa-comment"></i> Comment</a>
            </div>
        </div>
        <hr>
        <!-- Post /////-->

        <!--- \\\\\\\Post-->
        <div class="card gedf-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="mr-2">
                            <img class="rounded-circle" width="45" src="https://picsum.photos/50/50" alt="">
                        </div>
                        <div class="ml-2">
                            <div class="h5 m-0">Miracles Lee Cross</div>
                        </div>
                    </div>
                    <div class="activity">
                        <div class="dropdown">
                            <button class="btn btn-link dropdown-toggle" type="button" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-ellipsis-h"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="gedf-drop1">
                                <div class="h6 dropdown-header">Configuration</div>
                                <a class="dropdown-item" href="#">Save</a>
                                <a class="dropdown-item" href="#">Hide</a>
                                <a class="dropdown-item" href="#">Report</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <div class="text-muted h7 mb-2"> <i class="fa fa-clock-o"></i>10 min ago</div>
                <a class="card-link" href="#">
                    <h5 class="card-title">Lorem ipsum dolor sit amet, consectetur adip.</h5>
                </a>

                <p class="card-text">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo recusandae nulla rem eos ipsa praesentium esse magnam nemo dolor
                    sequi fuga quia quaerat cum, obcaecati hic, molestias minima iste voluptates.
                </p>
            </div>
            <div class="card-footer">
                <a href="#" class="card-link"><i class="fa fa-gittip"></i> Like</a>
                <a href="#" class="card-link"><i class="fa fa-comment"></i> Comment</a>
            </div>
        </div>
        <hr>
        <!-- Post /////-->

        <!-- Pagination -->
        <ul class="pagination justify-content-center">
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
        </ul>
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
