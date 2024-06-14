<?php 

require '../models/Connection.php';

$book_author = $_POST['autor'];
$book_title = $_POST['titulo'];
$book_subtitle = $_POST['subtitulo'];
$book_edition = $_POST['edicao'];
$book_pub = $_POST['editora'];
$book_year = $_POST['ano_publicacao'];
$book_cover = $_POST['capa_livro'];

$pdo = Connection::connect('../settings.ini');

$sql = "INSERT INTO livros(autor, titulo, subtitulo, edicao, editora, ano_publicacao, capa_livro) VALUES(:autor, :titulo, :subtitulo, :edicao, :editora, :ano_publicacao, :capa)";

$stmt = $pdo->prepare($sql);

$linesMod = $stmt->execute([
    ":autor"=> $book_author,
    ":titulo"=> $book_title,
    ":subtitulo"=> $book_subtitle,
    ":edicao"=> $book_edition,
    ":editora"=> $book_pub,
    ":ano_publicacao"=> $book_year,
    ":capa"=> $book_cover
]);

if ($linesMod) {
    header("Location: http://jrmlibrary.test/meus_livros.php");
    exit();
} else {
    echo "Erro ao inserir o livro.";
}