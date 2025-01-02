<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title></title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light align-items-center" style="background-color: #e3f2fd;">
        <div class="container-fluid align-items-center">
            <div class="align-items-center">
            <img class="mx-2" src="assets/logo.png" width="30" height="30" alt="">
            <a class="navbar-brand" href="#"><strong>HotelPedia</strong></a>
            </div>
            <div class="d-flex align-items-center w-50">
            <h3 class="navbar-brand">High Quality Experience</h3>
            <?php if (isset($_SESSION['id_user'])) { ?>
                <a href="./logout.php" class="btn btn-primary mx-3 align-items-center w-25"><img src="assets/login-icon.png" class="mx-2" width="30" height="30" alt="">Logout</a>
            <?php } else { ?>
                <a href="./login.php" class="btn btn btn-primary mx-3 align-items-center w-25"><img src="assets/login-icon.png" class="mx-2" width="30" height="30" alt="">Login</a>
                <a href="./register.php" class="btn btn-outline-success mx-3 w-25">Register</a>
            <?php } ?>
            </div>

        </div>
    </nav>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>