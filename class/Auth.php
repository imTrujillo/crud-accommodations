<?php
require_once "/xampp/htdocs/ProjectPHP/AcommodationCRUD/class/Connection.php";

class Authentication
{
    public static function login ($email,$password)
    {
        $pdo = Connection::connect();
        $query = $pdo->prepare('SELECT id_user, name, email, password, roll FROM users WHERE email = :email');
        $query->bindParam(':email',$email);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($user)
        {
            if ($password == $user['password'])
            {
                session_start();
                $_SESSION['id_user']=$user['id_user'];
                $_SESSION['name']=$user['name'];
                if ($user['roll'] == "admin")
                {
                    header ("location: manager_acommodations.php");
                }
                else
                {
                    header ("location: list_acommodations.php");
                }
                
            }
            else
            {
                echo "<div class='alert alert-danger w-100' role='alert'>Incorrect credentials.</div>";
            }
        }
        else
        {
            echo "<div class='alert alert-danger w-100' role='alert'>The user wasn't found.</div>";
        }
    }

    public static function logout()
    {
        session_start();
        session_destroy();
        session_unset();
        header('location: index.php');
        exit;
    }

    public static function verifySession()
    {
        session_start();
        if (!isset($_SESSION['id_user']))
        {
            header("location: login.php?error= <div class='alert alert-danger w-100' role='alert'>You must login.</div>");
            exit;
        }
    }

    public static function register($name, $email,$password,$roll)
    {
        try
        {
            $pdo = Connection::connect();
            $query = $pdo->prepare('INSERT INTO users(name, email,password, roll) values (:name,:email,:password,:roll)');
            $query->bindParam(':name',$name);
            $query->bindParam(':email',$email);
            $query->bindParam(':password',$password);
            $query->bindParam(':roll',$roll);
    
            if ($query->execute())
            {
                $id_user = $pdo->lastInsertId();
                $_SESSION['id_user']=$id_user;
                $_SESSION['name']=$name;
                header("location: login.php?error= <div class='alert alert-success w-100' role='alert'>The account has been created.</div>");
                exit;
            }
            else
            {
                echo "<div class='alert alert-danger w-100' role='alert'>Sorry. Try Again.</div>";
            }
        }
        catch (PDOException $ex)
        {
            echo "<div class='alert alert-danger w-100' role='alert'>An error has ocurred :(.";
            echo $ex->getMessage() . "</div>";
        }

    }
}

?>