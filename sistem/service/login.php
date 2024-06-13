<?php

require 'Connection.php';

$user_email = $_POST['email'];
$user_password = $_POST['senha'];

$pdo = Connection::connect('settings.ini');

$sql = "SELECT * FROM usuarios WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->execute([':email' => $user_email]);

$user = $stmt->fetchAll();

if ($user) {
    if (password_verify($user_password, $user[0]['senha'])) {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION["id"] = $user[0]["id"];
        $_SESSION["email"] = $user[0]["email"];

        header("Location: http://jrmlibrary.test/painel.html");
        exit();
    } else {
        header("Location: http://jrmlibrary.test/index.html?errorMessage=wrongPassword");
        exit();
    }
} else {
    header("Location: http://jrmlibrary.test/index.html?errorMessage=emailNotFound");
    exit();
}