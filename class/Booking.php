<?php

class Book
{
    public $id_booking;
    private $id_user;
    private $id_acommodation;
    private $startDate;
    private $endDate;
    private $status;

    public function __construct($id_user, $id_acommodation, $startDate, $endDate)
    {
        $this->id_user = $id_user;
        $this->id_acommodation = $id_acommodation;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->status = "Active";
    }

    public function save()
    {
        try {
            $pdo = Connection::connect();
            $query = $pdo->prepare('INSERT INTO bookings(id_user, id_acommodation, start_date, end_date, status) VALUES (?,?,?,?,?)');
            $result = $query->execute([$this->id_user, $this->id_acommodation, $this->startDate, $this->endDate, $this->status]);

            if ($result) {
                header("location: manager_acommodations.php?error= <div class='alert alert-success w-100' role='alert'>The reservation has been added.</div>");
                exit;
            }
        } catch (PDOException $ex) {
            $ex->getMessage();
        }
    }

    public static function cancelBooking($id_booking)
    {
        try {
            $pdo = Connection::connect();
            $query = $pdo->prepare("DELETE FROM bookings WHERE id_booking = ?");
            $result = $query->execute([$id_booking]);

            if ($result) {
                header("location: manager_acommodations.php?error= <div class='alert alert-success w-100' role='alert'>The reservation has been cancelled.</div>");
                exit;
            }
        } catch (PDOException $ex) {
            echo "<div class='alert alert-danger w-100' role='alert'>Fatal error in cancelling the reservation." . $ex->getMessage() . "</div>";
        }
    }

    public static function getBookingByUser($id_user)
    {
        $pdo = Connection::connect();
        $query = $pdo->prepare("SELECT b.id_booking, b.id_acommodation, b.id_user, b.start_date, b.end_date, b.status, a.name FROM bookings b INNER JOIN acommodations a ON a.id_acommodation=b.id_acommodation WHERE b.id_user = ?");
        $query->execute([$id_user]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function checkBookingsByUser($id_acommodation, $id_user)
    {
        $pdo = Connection::connect();
        $query = $pdo->prepare('SELECT COUNT(*) As count from bookings WHERE id_acommodation = ? and id_user = ?');
        $result = $query->execute([$id_acommodation, $id_user]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }
}
