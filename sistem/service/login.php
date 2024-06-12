<?php

require 'Connection.php';

$user_email = $_POST['email'];
$user_password = $_POST['senha'];

$pdo = Connection::connect('settings.ini');

$sql = "SELECT * FROM usuarios WHERE email = :email AND senha = :senha";

$stmt = $pdo->prepare($sql);

$linesMod = $stmt->execute([
    ':email'=>$user_email,
    ':senha'=>$user_password
]);

$matrizUser = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

var_dump($matrizUser);

if(count($matrizUser)=="1"){
    if(!isset($_SESSION)){
        session_start();
    }

    $_SESSION["id"] = $matrizUser[0]["id"];
    $_SESSION["email"] = $matrizUser[0]["email"];

    header("Location: http://jrmlibrary-main.test/painel.html");
}