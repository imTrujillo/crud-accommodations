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
    <title>Register</title>
</head>

<body style="width:100%; display: flex; flex-direction: column; align-items:center;">
    <nav class="navbar navbar-expand-lg navbar-light align-items-center w-100" style="background-color: #e3f2fd; ">
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
        echo "<div class='alert alert-danger w-100' role='alert'>" . $_GET['error'] . "</div>";
    }
    ?>
    <div class="card m-4 p-4 w-75 d-flex flex-row">
        <img src="assets/wallpaper2.jpg" class="w-75 img-rounded" alt="...">
        <div class="card-body" style="text-align:left;">
            <h1 class="fw-bold me-5 mt-5">Create a new account!</h1>
            <form action="" method="post">
                <label for="">Name</label>
                <input type="text" class="form-control" name="name">
                <label for="">Email</label>
                <input type="text" class="form-control" name="email">
                <label for="">Password</label>
                <input type="password" class="form-control" name="password">
                <label for="">Roll</label>
                <select name="roll" class="form-control" id="">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
                <input type="submit" class="btn btn-primary w-100 my-4" value="Register">
            </form>
        </div>
    </div>
    </div>
    <?php
        if (isset($_POST['email'], $_POST['password'])) {
            if(isset($_POST['email'], $_POST['password']) && strlen($_POST['password']) >= 8 && strlen($_POST['email']) > 8 && strlen($_POST['name']) > 3)
            {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $roll = $_POST['roll'];
                Authentication::register($name, $email, $password, $roll);
            }
    
        }
        else
        {
            echo "<div class='alert alert-danger w-100' role='alert'>All the fields are required.</div>";
        }
    ?>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>