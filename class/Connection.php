<?php 
class Connection
{
    public static function connect()
    {
        try
        {
            $dsn = 'mysql:host=betijjbam0dc5vgbd21o-mysql.services.clever-cloud.com;dbname=betijjbam0dc5vgbd21o; charset=utf8';
            $user = 'ukxomjex4klr0ezd';
            $password = 'dPBK24P9VCDaFaLsvAy7';
            $pdo = new PDO($dsn,$user,$password);
            return $pdo;
        }
        catch (PDOException $ex)
        {
            echo "The connection to the database was failed." . $ex->getMessage();
            exit();
        }
    }
}
?>