<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    if (password_verify($password, $hashed_password)) {
        $_SESSION["username"] = $username;
        header("Location: welcome.php");
        exit;
    } else {
        $error_msg = "Nieprawidłowa nazwa użytkownika lub hasło.";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Logowanie</title>
</head>
<body>
    <h1>Logowanie</h1>
    <?php if (isset($error_msg)) { ?>
        <p style="color: red;"><?php echo $error_msg; ?></p>
    <?php } ?>
    <form method="post" action="login