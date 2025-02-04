<?php 
use Connection\database\Database;
use Users\User;
require_once "../Model/Database.php";
require_once "../Model/User.php";

session_start();

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'login') {
            if (!empty($_POST['email']) && !empty($_POST['password'])) {
                $user->setemail( $_POST['email']) ;
                $user->setpassword( $_POST['password']) ;
                $result = $user->login();
                if ($result['success']) {
                    if($_SESSION['role']=='student'){
                        header('Location:index.php');
                    }else if($_SESSION['role']=='teacher'){
                        header('Location: Course_Management_teacher.php');

                    }else if($_SESSION['role']=='admin'){
                        header('Location:Admin.php');
                    }
                    exit;
                } else {
                    $error = $result['message'];
                }
            } else {
                $error = 'Veuillez remplir tous les champs';
            }
        } elseif ($_POST['action'] === 'register') {
            if (!empty($_POST['username']) && !empty($_POST['email']) && 
                !empty($_POST['password']) && !empty($_POST['confirm_password']) &&
                !empty($_POST['role'])) {
                
                if ($_POST['password'] !== $_POST['confirm_password']) {
                    $error = 'Les mots de passe ne correspondent pas';
                } else {
                    $user->setusername($_POST['username']) ;
                    $user->setemail($_POST['email']);
                    $user->setpassword($_POST['password']) ;
                    $user->setrole( $_POST['role']);
                    
                    $result = $user->register();
                    if ($result['success']) {
                        $success = $result['message'];
                    } else {
                        $error = $result['message'];
                    }
                }
            } else {
                $error = 'Veuillez remplir tous les champs';
            }
        }
    }
}


?>