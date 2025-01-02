<?php
require_once "./class/Auth.php";
Authentication::verifySession();
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
    require_once "/xampp/htdocs/ProjectPHP/AcommodationCRUD/class/Acommodation.php";
    require_once "/xampp/htdocs/ProjectPHP/AcommodationCRUD/class/User.php";
    $users = User::all();
    $acommodations = Acommodation::getAcommmodation();
    include "/xampp/htdocs/ProjectPHP/AcommodationCRUD/assets/navbar.php"
    ?>
    <main class="container">
        <h1>Acommodations Manager</h1>
        <h3 class="d-flex justify-content-center m-3">Welcome Back <?php echo $_SESSION['name']; ?> !</h3>s
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Register Acommodation</button>
        <table class="table">

            <head>
                <th>Name</th>
                <th>Description</th>
                <th>Address</th>
                <th>Price</th>
                <th>Available</th>
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
                        <td><?php echo $acommodation['address'] ?></td>
                        <td><?php echo $acommodation['price'] ?></td>
                        <td class="status <?php echo $class_status ?>"><?php echo $acommodation['available']  ?></td>
                        <td><button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#ModalStatus<?php echo $acommodation['id_acommodation']; ?>"> Change State</button></td>
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
                            <label for="">Address</label>
                            <textarea name="address" id="" class="form-control"></textarea>
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

    if (isset($_POST['name'], $_POST['description'], $_POST['address'], $_POST['price'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $address = $_POST['address'];
        $price = $_POST['price'];

        $acommodation = new Acommodation($name, $description, $address, $price);
        $acommodation->save();
    }
    ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>