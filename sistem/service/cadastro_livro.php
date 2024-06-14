<?php 

require '../models/Connection.php';

$book_author = $_POST['autor'];
$book_title = $_POST['titulo'];
$book_subtitle = $_POST['subtitulo'];
$book_edition = $_POST['edicao'];
$book_pub = $_POST['editora'];
$book_year = $_POST['ano_publicacao'];

$pdo = Connection::connect('../settings.ini');

$sql = "INSERT INTO livros(autor, titulo, subtitulo, edicao, editora, ano_publicacao) VALUES(:autor, :titulo, :subtitulo, :edicao, :editora, :ano_publicacao)";

$stmt = $pdo->prepare($sql);

$linesMod = $stmt->execute([
    ":autor"=> $book_author,
    ":titulo"=> $book_title,
    ":subtitulo"=> $book_subtitle,
    ":edicao"=> $book_edition,
    ":editora"=> $book_pub,
    ":ano_publicacao"=> $book_year
]);

if($linesMod){
    header("Location: jrmlibrary.test/meus_livros");
}