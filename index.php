<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<?php
    include_once "/xampp/htdocs/ProjectPHP/AcommodationCRUD/class/Acommodation.php";
    include_once "/xampp/htdocs/ProjectPHP/AcommodationCRUD/assets/navbar.php";
    require_once "/xampp/htdocs/ProjectPHP/AcommodationCRUD/class/Booking.php";
    $acommodations = Acommodation::getAcommmodationByStatus(); ?>
    <h2 class="fw-bold mx-5 mt-5">Check out these acommodations</h1>
    <hr class="w-75 mx-5">
        <section class="container">
            <?php foreach ($acommodations as $acommodation) { 
                ?>
                <div class="card m-4 p-4 d-flex flex-row align-items-center" style="width:95%;">
                    <img src="assets/image.jpg" class="card-img-top rounded img-rounded w-25" style="height:min-content;" alt="...">
                    <div class="card-body">
                        <h3 class="card-title" style="color:blue;"><?php echo $acommodation['name'] ?></h3>
                        <a class="card-text"><strong><?php echo $acommodation['address'] ?></strong></a>
                        <p class="card-text"><?php echo $acommodation['description'] ?></p>

                    </div>
                    <div class="d-flex justify-content-end flex-column" style="width: 30%; align-items:end;">
                    <h5 class="text-success text-end">Since $<?php echo $acommodation['price'] ?></h5>
                    <a href="login.php"><button class="btn btn-success" style="width: 6rem;"> Book</button> </a>
                    </div>
                </div>
            <?php } ?>
        </section>
        <?php
        ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>