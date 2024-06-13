<?php

require 'Connection.php';

$user_name = $_POST['nome'];
$user_email = $_POST['email'];
$user_password = $_POST['senha'];

$hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

$pdo = Connection::connect('settings.ini'); 

$sql = "SELECT * FROM usuarios WHERE email = :email";
$query = $pdo->prepare($sql);
$query->execute([":email" => $user_email]);
$count = $query->fetchColumn();

if ($count > 0) {
    header("Location: http://jrmlibrary.test/cadastro.html?errorMessage=cdtEx");
    exit();
} else {
    $sql = "INSERT INTO usuarios(nome, email, senha) VALUES(:nome, :email, :senha)";
    $query = $pdo->prepare($sql); 
    $linesMod = $query->execute(
        [
            ":nome" => $user_name,
            ":email"=> $user_email,
            ":senha"=> $hashed_password
        ]
    );

    header("Location: http://jrmlibrary.test/index.html");
    exit();
}