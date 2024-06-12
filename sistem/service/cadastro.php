<?php

require 'Connection.php';

$user_name = $_POST['nome'];
$user_email = $_POST['email'];
$user_password = $_POST['senha'];

$pdo = Connection::connect('settings.ini'); 

$sql = "INSERT INTO usuarios(nome, email, senha) VALUES(:nome, :email, :senha)";

$query = $pdo->prepare($sql); 

$linesMod = $query->execute(
    [
        ":nome" => $user_name,
        ":email"=> $user_email,
        ":senha"=> $user_password
    ]
);
