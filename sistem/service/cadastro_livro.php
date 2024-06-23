<?php
require '../models/Connection.php';
session_start();

// Verifica se o usuário está logado e a variável de sessão 'id' está definida
if (!isset($_SESSION['id'])) {
    header("Location: http://jrmlibrary.test/");
    exit();
}

if (isset($_POST['autor'], $_POST['titulo'], $_POST['subtitulo'], $_POST['edicao'], $_POST['editora'], $_POST['ano_publicacao'])) {
    $book_author = $_POST['autor'];
    $book_title = $_POST['titulo'];
    $book_subtitle = $_POST['subtitulo'];
    $book_edition = $_POST['edicao'];
    $book_pub = $_POST['editora'];
    $book_year = $_POST['ano_publicacao'];
    $user_id = $_SESSION['id'];
    $book_cover_path = null;

    if (isset($_FILES['capa_livro']) && $_FILES['capa_livro']['error'] == 0) {
        $file_name = uniqid();
        $file_extension = strtolower(pathinfo($_FILES["capa_livro"]["name"], PATHINFO_EXTENSION));
        if (!in_array($file_extension, ['jpg', 'jpeg', 'jfif', 'png'])) {
            die("Formatos de arquivos não aceitos, tente novamente...");
        }

        $new_file_name = $file_name . "." . $file_extension;

        $book_cover_path = "../user_images/" . $new_file_name;

        if (!move_uploaded_file($_FILES["capa_livro"]["tmp_name"], $book_cover_path)) {
            die("Erro ao fazer upload da imagem.");
        }
    }

    try {
        $pdo = Connection::connect('../settings.ini');

        if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
            $id = $_GET['id'];

            $sql = "SELECT usuario FROM livros WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([":id" => $id]);
            $book = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($book && $book['usuario'] == $user_id) {
                $sql = "UPDATE livros SET autor = :autor, titulo = :titulo, subtitulo = :subtitulo, edicao = :edicao, editora = :editora, ano_publicacao = :ano_publicacao WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(":autor", $book_author);
                $stmt->bindParam(":titulo", $book_title);
                $stmt->bindParam(":subtitulo", $book_subtitle);
                $stmt->bindParam(":edicao", $book_edition);
                $stmt->bindParam(":editora", $book_pub);
                $stmt->bindParam(":ano_publicacao", $book_year);
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->execute();

                if ($book_cover_path) {
                    $sql_images = "UPDATE imagens SET nome = :nome WHERE livro_id = :id";
                    $stmt = $pdo->prepare($sql_images);
                    $stmt->bindParam(":nome", $new_file_name);
                    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                    $stmt->execute();
                }
            } else {
                header("Location: http://jrmlibrary.test/meus_livros.php?errorMessage=cantModifieOtherBooks");
                exit();
            }
        } else {
            $sql = "INSERT INTO livros(autor, titulo, subtitulo, edicao, editora, ano_publicacao, usuario) VALUES(:autor, :titulo, :subtitulo, :edicao, :editora, :ano_publicacao, :usuario)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":autor", $book_author);
            $stmt->bindParam(":titulo", $book_title);
            $stmt->bindParam(":subtitulo", $book_subtitle);
            $stmt->bindParam(":edicao", $book_edition);
            $stmt->bindParam(":editora", $book_pub);
            $stmt->bindParam(":ano_publicacao", $book_year);
            $stmt->bindParam(":usuario", $user_id, PDO::PARAM_INT);
            $stmt->execute();

            $book_id = $pdo->lastInsertId();

            if ($book_cover_path) {
                $sql_images = "INSERT INTO imagens(nome, livro_id) VALUES(:nome, :livro_id)";
                $stmt = $pdo->prepare($sql_images);
                $stmt->bindParam(":nome", $new_file_name);
                $stmt->bindParam(":livro_id", $book_id, PDO::PARAM_INT);
                $stmt->execute();
            }
        }

        header("Location: http://jrmlibrary.test/meus_livros.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao conectar com o banco de dados: " . $e->getMessage();
    }
}
