<?php
require_once "/xampp/htdocs/AcommodationCRUD/class/Connection.php";
class User
{
    public static function all()
    {
        $pdo = Connection::connect();
        $query = $pdo->query('SELECT id_user, name,email, roll FROM users');
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
