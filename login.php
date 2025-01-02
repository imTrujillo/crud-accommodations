<?php
session_start();
require_once "/xampp/htdocs/ProjectPHP/AcommodationCRUD/class/Auth.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Login</title>
</head>

<body style="width:100%; display: flex; flex-direction: column; align-items:center;">
    <nav class="navbar navbar-expand-lg navbar-light w-100" style="background-color: #e3f2fd; ">
        <div class="container-fluid align-items-center" style="justify-content:center;">
            <div class="align-items-center">
                <img class="mx-2" src="assets/logo.png" width="30" height="30" alt="">
                <a class="navbar-brand" href="#"><strong>HotelPedia</strong></a>
            </div>
            <div class="d-flex align-items-center w-50">
                <h3 class="navbar-brand">High Quality Experience</h3>
            </div>
        </div>
    </nav>
    <?php
    if (isset($_GET['error'])) {
        echo "<p>" . $_GET['error'] . "</p>";
    }
    ?>
    <div class="card m-4 p-4 w-75 d-flex flex-md-row flex-xs-column"  >
        <img src="assets/wallpaper.jpg" class="col col-md-6 rounded img-fluid" alt="...">
        <div class="card-body" style="text-align:left;">
            <h1 class="fw-bold me-5 mt-5" style="color: blue;">Login into your account</h1>
            <form action="" method="post">
                <label for="">Email</label>
                <input type="text" class="form-control" name="email" required>
                <label for="">Password</label>
                <input type="password" class="form-control" name="password" minlength="8" required>
                <input type="submit" class="btn btn-primary w-100 my-4" value="Login">
            </form>
        </div>
    </div>
    </div>


    <?php
    if (isset($_POST['email'], $_POST['password'])) {
        if(isset($_POST['email'], $_POST['password']) && strlen($_POST['password']) >= 8 && strlen($_POST['email']) > 8)
        {
            $email = $_POST['email'];
            $password = $_POST['password'];
            Authentication::login($email, $password);
        }

    }
    ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>