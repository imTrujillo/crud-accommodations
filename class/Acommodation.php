<?php
include_once "/xampp/htdocs/AcommodationCRUD/class/Connection.php";
class Acommodation
{
    private $id;
    private $name;
    private $description;
    private $stars;
    private $address;
    private $price;
    private $available;
    private $rooms;
    private $capacity;

    public function __construct($name, $description, $stars, $address, $price, $rooms, $capacity)
    {
        $this->name = $name;
        $this->description = $description;
        $this->stars = $stars;
        $this->address = $address;
        $this->available = "Available";
        $this->price = $price;
        $this->rooms = $rooms;
        $this->capacity = $capacity;
    }

    public function save()
    {
        try {
            $pdo = Connection::connect();
            $query = $pdo->prepare('INSERT INTO acommodations(name, description, stars, address, price, available, rooms, capacity) VALUES (?,?,?,?,?,?,?,?)');
            $result = $query->execute(["$this->name", "$this->description", $this->stars, "$this->address", $this->price, "$this->available", $this->rooms, $this->capacity]);

            if ($result) {
                header("location: manager_acommodations.php?error= <div class='alert alert-success w-100' role='alert'>The accommodation was registered succesfully.</div>");
                exit;
            }
        } catch (PDOException $ex) {
            echo  "<div class='alert alert-danger w-100' role='alert'>Fatal error in registering the acommodation" . $ex->getMessage() . "</div>";
        }
    }

    public static function getAcommmodation()
    {
        $pdo = Connection::connect();
        $query = $pdo->query("SELECT * FROM acommodations");
        $query->execute();
        $array = $query->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public static function updateAcommodationStatus($id_acommodation, $new_status)
    {
        try {
            $pdo = Connection::connect();
            $query = $pdo->prepare("UPDATE acommodations SET available = :available WHERE id_acommodation = :id_acommodation");
            $query->bindParam(':available', $new_status, PDO::PARAM_STR);
            $query->bindParam(':id_acommodation', $id_acommodation, PDO::PARAM_INT);
            $result = $query->execute();

            if ($result) {
                header("location: manager_acommodations.php?error= <div class='alert alert-success w-100' role='alert'>The status has been updated.</div>");
                exit;
            }
        } catch (PDOException $ex) {
            echo "<div class='alert alert-danger w-100' role='alert'>Fatal error in updating the status. " . $ex->getMessage() . "</div>";
        }
    }

    public static function getAcommmodationByStatus()
    {
        $pdo = Connection::connect();
        $query = $pdo->query("SELECT * FROM acommodations WHERE available='Available'");
        $query->execute();
        $array = $query->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }
}
