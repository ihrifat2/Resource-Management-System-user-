
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
</head>
<body>
    <!-- Navbar Start -->
    <?php include 'inc/navbar.php'; ?>
    <!-- Navbar End -->

    <div class="container">
        <div class="row my-4">
            <div class="col-md-4">
                <img class="img-fluid" src="http://placehold.it/750x500" alt="">
            </div>
            <div class="col-md-8 userProfile">
                <h3 class="my-3">Profile Details</h3>
                <ul>
                    <li>Name : </li>
                    <li>Username : </li>
                    <li>Email : </li>
                    <li>Phone : </li>
                </ul>
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
