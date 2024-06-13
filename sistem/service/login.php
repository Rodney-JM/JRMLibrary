<?php

require '../models/Connection.php';

session_start();

$user_email = $_POST['email'];
$user_password = $_POST['senha'];

$pdo = Connection::connect('../settings.ini');

$sql = "SELECT * FROM usuarios WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->execute([':email' => $user_email]);

$user = $stmt->fetchAll();

if ($user) {
    if (password_verify($user_password, $user[0]['senha'])) {
        $_SESSION['loggedin'] = true;
        $_SESSION["id"] = $user[0]["id"];
        $_SESSION["email"] = $user[0]["email"];

        header("Location: http://jrmlibrary.test/painel.php");
        exit();
    } else {
        header("Location: http://jrmlibrary.test/index.php?errorMessage=wrongPassword");
        exit();
    }
} else {
    header("Location: http://jrmlibrary.test/index.php?errorMessage=emailNotFound");
    exit();
}
