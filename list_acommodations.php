<?php
require_once "./class/Auth.php";
Authentication::verifySession();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acommodations</title>
</head>

<body>
    <?php
    include_once "/xampp/htdocs/ProjectPHP/AcommodationCRUD/class/Acommodation.php";
    include_once "/xampp/htdocs/ProjectPHP/AcommodationCRUD/assets/navbar.php";
    require_once "/xampp/htdocs/ProjectPHP/AcommodationCRUD/class/Booking.php";
    ?>
    <h3 class="d-flex justify-content-center m-3">Welcome Back <?php echo $_SESSION['name']; ?> !</h3>
    <h1 class="fw-bold mx-5 mt-5">Your reservations</h1>
    <hr class="w-75 mx-5">
    <?php
    $acommodations = Acommodation::getAcommmodationByStatus();
    $bookings = Book::getBookingByUser($_SESSION['id_user']); ?>

    <section class="container center d-flex">
    <?php if (empty($bookings)) { ?>
            <p>The reservations will appear here.</p>
        <?php } else {
        foreach ($bookings as $booking) 
        { 
            ?>
            <div class="card text-white m-4" style="width: 18rem; background-color:lightseagreen;">
            <h5 class="card-title bg-color p-3 mb-2 bg-success text-white"> <?php echo $booking['status'] ?></h5>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $booking['name'] ?></h5>
                    <h6 class="card-text"><strong>Check-in Date:</strong> <?php echo $booking['start_date'] ?></h6>
                    <h6 class="card-text"><strong>Check-out Date:</strong> <?php echo $booking['end_date'] ?></h6>
                    <?php if ($booking['status'] === 'Active') { ?>
                        <form action="" method="post">
                            <input type="hidden" name="id_booking" value="<?php echo $booking['id_booking']; ?>">
                            <button type="submit" class="btn btn-primary">Cancel</button>
                        </form>
                    <?php } ?>
                </div>
            </div>
</div>
            <?php
        }}
            ?>
    </section>

    <h2 class="fw-bold mx-5 mt-5">Where do you plan to travel?</h1>
    <hr class="w-75 mx-5">
        <section class="container center d-flex">
            <?php foreach ($acommodations as $acommodation) { 
                $isBooked = Book::checkBookingsByUser($acommodation['id_acommodation'], $_SESSION['id_user']);
                ?>
                <div class="card bg-light m-3" style="width: 18rem;">
                    <img src="assets/image.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                    <h6 class="card-text"><?php echo $acommodation['address'] ?></h6>
                        <h5 class="card-title"><?php echo $acommodation['name'] ?></h5>
                        <p class="card-text"><?php echo $acommodation['description'] ?></p>
                        <h5 class="card-title"> $ <?php echo $acommodation['price'] ?></h5>
                        <?php if (!$isBooked) { ?>
                            <a href="#" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#ModalStatus<?php echo $acommodation['id_acommodation']; ?>">Book</a>
                        <?php } else { ?>
                            <span class="btn btn-secondary btn-lg pt-0 w-100"> Booked </span>
                        <?php } ?>
                    </div>
                </div>

                <div class="modal fade" id="ModalStatus<?php echo $acommodation['id_acommodation']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5 " id="exampleModalLabel">Booking an accommodation</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="" method="post">
                                <div class="modal-body">
                                    <h4 class="p-3 mb-2 alert alert-secondary"><?php echo $acommodation['name']; ?></h4>
                                    <input type="hidden" name="id_acommodation" value="<?php echo $acommodation['id_acommodation'] ?>">
                                    <label for="" class="w-100">Check-in-Date</label>
                                    <input type="date" name="start-date" class="control-form" required>
                                    <label for="" class="w-100">Check-out-Date</label>
                                    <input type="date" name="end-date" class="control-form" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">Reserve</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </section>
        <?php
        if(isset($_POST['id_booking']))
        {
            $id_booking= (int) $_POST['id_booking'];
            $_SESSION['id_booking'] = $id_booking;
            Book::cancelBooking($id_booking);
        }

        if (isset($_POST['start-date'], $_POST['end-date'], $_POST['id_acommodation'])) {
            $startDate = $_POST['start-date'];
            $endDate = $_POST['end-date'];

            if ($startDate > $endDate) {
                echo "Error: Check-out date must be after check-in date.";
            } else {
                $id_acommodation = (int) $_POST['id_acommodation'];
                $booking = new Book($_SESSION['id_user'], $id_acommodation, $startDate, $endDate);
                $booking->save();
            }
        }

        ?>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>