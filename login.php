<?php
session_start();

$users_file = "users.txt";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $users = file($users_file, FILE_IGNORE_NEW_LINES);
    foreach ($users as $user) {
        $user_info = explode(":", $user);
        if ($user_info[0] == $username && $user_info[1] == $password) {
            $_SESSION["username"] = $username;
            header("Location: welcome.php");
            exit;
        }
    }

    $error_msg = "Nieprawidłowa nazwa użytkownika lub hasło.";
}