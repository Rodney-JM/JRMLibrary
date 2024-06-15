<?php

require '../models/Connection.php';

if (isset($_POST['autor'], $_POST['titulo'], $_POST['subtitulo'], $_POST['edicao'], $_POST['editora'], $_POST['ano_publicacao'])) {
    $book_author = $_POST['autor'];
    $book_title = $_POST['titulo'];
    $book_subtitle = $_POST['subtitulo'];
    $book_edition = $_POST['edicao'];
    $book_pub = $_POST['editora'];
    $book_year = $_POST['ano_publicacao'];
    $book_cover = $_POST['capa_livro'];

    try {
        $pdo = Connection::connect('../settings.ini');

        // Verifica se $_GET['id'] está definido e é um número inteiro válido
        if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
            $id = $_GET['id'];

            $sql = "UPDATE livros SET autor = :autor, titulo = :titulo, subtitulo = :subtitulo, edicao = :edicao, editora = :editora, ano_publicacao = :ano_publicacao, capa_livro = :capa WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":autor", $book_author);
            $stmt->bindParam(":titulo", $book_title);
            $stmt->bindParam(":subtitulo", $book_subtitle);
            $stmt->bindParam(":edicao", $book_edition);
            $stmt->bindParam(":editora", $book_pub);
            $stmt->bindParam(":ano_publicacao", $book_year);
            $stmt->bindParam(":capa", $book_cover);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT); // Especifica que é um inteiro

        } else {
            // Inserção de um novo livro
            $sql = "INSERT INTO livros(autor, titulo, subtitulo, edicao, editora, ano_publicacao, capa_livro, usuario) VALUES(:autor, :titulo, :subtitulo, :edicao, :editora, :ano_publicacao, :capa, :usuario)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":autor", $book_author);
            $stmt->bindParam(":titulo", $book_title);
            $stmt->bindParam(":subtitulo", $book_subtitle);
            $stmt->bindParam(":edicao", $book_edition);
            $stmt->bindParam(":editora", $book_pub);
            $stmt->bindParam(":ano_publicacao", $book_year);
            $stmt->bindParam(":capa", $book_cover);
            $stmt->bindParam(":usuario", $_SESSION['id'], PDO::PARAM_INT);
        }

        $stmt->execute();
        $linesMod = $stmt->rowCount();

        if ($linesMod > 0) {
            header("Location: http://jrmlibrary.test/meus_livros.php");
            exit();
        } else {
            echo "Nenhum registro foi atualizado. Verifique se o ID está correto.";
        }
    } catch (PDOException $e) {
        echo "Erro ao conectar com o banco de dados: " . $e->getMessage();
    }
} else {
    echo "Todos os campos são obrigatórios.";
}