<?php
ob_start();
require_once "./class/Auth.php";
Authentication::verifySession();
if ($_SESSION['roll'] != 'admin') {
    header('Location: list_acommodations.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Acommodations Manager</title>
</head>

<body>
    <?php
    require_once "/xampp/htdocs/AcommodationCRUD/class/Acommodation.php";
    require_once "/xampp/htdocs/AcommodationCRUD/class/User.php";
    $users = User::all();
    $acommodations = Acommodation::getAcommmodation();
    include "/xampp/htdocs/AcommodationCRUD/assets/navbar.php"
    ?>
    <main class="container">
        <div class="d-flex justify-content-center flex-column" style="align-items: center;">
            <img src="assets/profile-icon.jpg" class=" mx-3" style="width: 14rem; height: 14rem;" alt="">
            <h1 class="mx-3 mt-3"><strong>Acommodations Manager</strong></h1>
            <h3 class="m-3">Welcome Back Admin <?php echo $_SESSION['name']; ?> !</h3>s
        </div>

        <button type="button" class="btn btn-primary m-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Register Acommodation</button>

        <div class="table-responsive">
            <table class="table table-striped table-hover">

                <head class="table-dark">
                    <th>Name</th>
                    <th>Description</th>
                    <th>Stars</th>
                    <th>Address</th>
                    <th>Rooms</th>
                    <th>Capacity</th>
                    <th>Price</th>
                    <th>Available</th>
                    <th class="bg-danger text-white">Options</th>
                </head>
                <tbody>
                    <?php foreach ($acommodations as $acommodation) {
                        $class_status = "";
                        match ($acommodation['available']) {
                            "Available" => $class_status = 'text-success fw-bold',
                            "Unavailable" => $class_status = 'text-danger fw-bold',
                            default => $class_status = ''
                        };
                    ?>
                        <tr>
                            <td><?php echo $acommodation['name'] ?></td>
                            <td><?php echo $acommodation['description'] ?></td>
                            <td><?php echo $acommodation['stars'] ?></td>
                            <td><?php echo $acommodation['address'] ?></td>
                            <td><?php echo $acommodation['rooms'] ?></td>
                            <td><?php echo $acommodation['capacity'] ?></td>
                            <td><?php echo $acommodation['price'] ?></td>
                            <td class="status <?php echo $class_status ?>"><?php echo $acommodation['available']  ?></td>
                            <td><button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#ModalStatus<?php echo $acommodation['id_acommodation']; ?>"> Change State</button></td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="ModalStatus<?php echo $acommodation['id_acommodation']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Status Update</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="" method="post">
                                        <div class="modal-body">
                                            <h4><?php echo $acommodation['name']; ?></h4>
                                            <input type="hidden" name="id_acommodation" value="<?php echo $acommodation['id_acommodation'] ?>">
                                            <label for="">Status</label>
                                            <select name="available" id="" class="form-control">
                                                <option value="">Select the state...</option>
                                                <option value="Unavailable">Unavailable</option>
                                                <option value="Available">Available</option>
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-dark">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Create the acommodation -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Acommodations Register</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="post">
                        <div class="modal-body">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name">
                            <label for="">Description</label>
                            <textarea name="description" id="" class="form-control"></textarea>
                            <label for="">Stars (0-5)</label>
                            <input type="text" name="stars" max="5" min="0" step="1" class="form-control">
                            <label for="">Address</label>
                            <textarea name="address" id="" class="form-control"></textarea>
                            <label for="">Rooms</label>
                            <input type="text" class="form-control" min="0" step="1" name="rooms">
                            <label for="">Capacity (Guests)</label>
                            <input type="text" class="form-control" min="0" step="1" name="capacity">
                            <label for="">Price</label>
                            <input type="text" class="form-control" name="price">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-dark">Save Acommodation</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <?php
    if (isset($_POST['id_acommodation'], $_POST['available'])) {
        $id = $_POST['id_acommodation'];
        $status = $_POST['available'];

        Acommodation::updateAcommodationStatus($id, $status);
    }

    if (isset($_POST['name'], $_POST['description'], $_POST['address'], $_POST['stars'], $_POST['price'], $_POST['rooms'], $_POST['capacity'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $address = $_POST['address'];
        $price = $_POST['price'];
        $stars = $_POST['stars'];
        $rooms = $_POST['rooms'];
        $capacity = $_POST['capacity'];

        if (!is_numeric($stars) || $stars < 0 || $stars > 5) {
            echo "<div class='alert alert-danger w-100' role='alert'>The stars must be within the range: 0-5.</div>";
        } elseif (!is_numeric($price) || $price < 0) {
            echo "<div class='alert alert-danger w-100' role='alert'>The price can't be negative.</div>";
        } elseif (!is_numeric($rooms) || $rooms < 0) {
            echo "<div class='alert alert-danger w-100' role='alert'>The number of rooms can't be negative.</div>";
        } elseif (!is_numeric($capacity) || $capacity < 0) {
            echo "<div class='alert alert-danger w-100' role='alert'>The capacity can't be negative.</div>";
        } else {
            $acommodation = new Acommodation($name, $description, $stars, $address, $price, $rooms, $capacity);
            $acommodation->save();
        }
    }
    ob_end_flush();
    ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>