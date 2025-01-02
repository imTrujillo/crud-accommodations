<?php

include_once "/xampp/htdocs/ProjectPHP/AcommodationCRUD/class/Connection.php";
class Acommodation
{
    private $id;
    private $name;
    private $description;
    private $address;
    private $price;
    private $available;

    public function __construct($name, $description, $address, $price)
    {
        $this->name = $name;
        $this->description = $description;
        $this->address = $address;
        $this->available = "Available";
        $this->price = $price;
    }

    public function save()
    {
        try
        {
            $pdo = Connection::connect();
            $query = $pdo->prepare('INSERT INTO acommodations(name, description, address, price, available) VALUES (?,?,?,?,?)');
            $result = $query->execute(["$this->name","$this->description","$this->address", $this->price, "$this->available"]);

            if ($result)
            {
                echo "<script>window.location.href= './index.php';</script>";
            }
        }
        catch(PDOException $ex)
        {
            echo "Fatal error in registering the acommodation. " . $ex->getMessage();
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
        try
        {
            $pdo = Connection::connect();
            $query = $pdo->prepare("UPDATE acommodations SET available = :available WHERE id_acommodation = :id_acommodation");
            $query->bindParam(':available', $new_status, PDO::PARAM_STR);
            $query->bindParam(':id_acommodation', $id_acommodation, PDO::PARAM_INT);
            $result = $query->execute();

            if($result)
            {
                echo "The status has been updated.";
            }
        }
        catch (PDOException $ex)
        {
            echo "Fatal error in updating the status." . $ex->getMessage();
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