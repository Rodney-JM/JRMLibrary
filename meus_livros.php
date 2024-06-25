<?php
require './sistem/models/Connection.php';

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: http://jrmlibrary.test/");
    exit();
}

try {
    $pdo = Connection::connect('./sistem/settings.ini');

    // Busca todos os livros com suas imagens associadas
    $sql = "SELECT l.id, l.autor, l.titulo, l.subtitulo, l.edicao, l.editora, l.ano_publicacao, l.usuario, MAX(i.nome) AS capa 
            FROM livros l 
            LEFT JOIN imagens i ON l.id = i.livro_id 
            GROUP BY l.id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($books === false) {
        $books = [];
    }

    // Verifica se há um livro específico para edição
    if (isset($_GET['id'])) {
        $book_id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        if ($book_id) {
            $sql = "SELECT id, autor, titulo, subtitulo, edicao, editora, ano_publicacao FROM livros WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":id", $book_id, PDO::PARAM_INT);
            $stmt->execute();
            $book = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }

    // Ação de exclusão de livro e imagens associadas
    if (isset($_GET['idRemove'])) {
        $book_id = filter_var($_GET['idRemove'], FILTER_VALIDATE_INT);
        if ($book_id) {
            try {
                $pdo->beginTransaction();

                // Exclui imagens associadas ao livro
                $sql = "DELETE FROM imagens WHERE livro_id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(":id", $book_id, PDO::PARAM_INT);
                $stmt->execute();

                // Exclui o livro
                $sql = "DELETE FROM livros WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(":id", $book_id, PDO::PARAM_INT);
                $stmt->execute();

                $pdo->commit();
                header("Location: http://jrmlibrary.test/meus_livros.php");
                exit();
            } catch (Exception $e) {
                $pdo->rollBack();
                error_log("Erro ao excluir livro e imagens: " . $e->getMessage());
            }
        }
    }
} catch (Exception $e) {
    error_log("Erro ao buscar dados: " . $e->getMessage());
    $books = [];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus livros - FrancisComic</title>

    <!-- icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Palanquin:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="src/styles/meus_livros/meus_livros.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="user_name" style="display:flex; justify-content:center; align-items:center; gap:.5rem;font-family:'Montserrat'">
                <i class="fa-solid fa-user"></i>
                <h3><?php echo $_SESSION["nome"];?></h3>
            </div>
            <div class="logo_container">
                <img src="/src/assets/icons/OIG3.png" alt="Logo imagem">
                <h3>FrancisComic</h3>
            </div>
            <ul>
                <a href="painel.php"><li><i class="fa-solid fa-house"></i>Início</li></a>
                <a href="#"><li><i class="fa-solid fa-book"></i>Meus livros</li></a>
                <a href="index.php?session=destroy"><li><i class="fa-solid fa-user"></i>Sair</li></a>
            </ul>
        </nav>
    </header>

    <main>
        <section class="title">
            <div class="topic">
                <i class="fa-solid fa-book"></i><h2>Meus livros</h2>
            </div>

            <div class="form_container active">
            <?php if (isset($book) && isset($_GET['id'])):?>
                <a href="meus_livros.php"><i class="fa-solid fa-circle-xmark"></i></a>
                <h3>Editar informações do livro</h3>
                <form action="/sistem/service/cadastro_livro.php?id=<?= htmlspecialchars($book['id']);?>" method="post" enctype="multipart/form-data">
                    <div class="input_container">
                        <label for="autor">Autor</label>
                        <input type="text" name="autor" id="autor" placeholder="Autor do livro" value="<?php echo htmlspecialchars($book['autor']);?>" required>
                    </div>

                    <div class="input_container">
                        <label for="titulo">Título</label>
                        <input type="text" name="titulo" id="titulo" placeholder="Título do livro" value="<?php echo htmlspecialchars($book['titulo']);?>" required>
                    </div>

                    <div class="input_container">
                        <label for="subtitulo">Subtítulo</label>
                        <input type="text" name="subtitulo" id="subtitulo" placeholder="Subtítulo do livro" value="<?php echo htmlspecialchars($book['subtitulo']);?>" required>
                    </div>

                    <div class="input_container">
                        <label for="edicao">Edição</label>
                        <input type="number" name="edicao" id="edicao" placeholder="Número da edição" value="<?php echo htmlspecialchars($book['edicao']);?>" required>
                    </div>

                    <div class="input_container">
                        <label for="editora">Editora</label>
                        <input type="text" name="editora" id="editora" placeholder="Editora do livro" value="<?php echo htmlspecialchars($book['editora']);?>" required>
                    </div>

                    <div class="input_container">
                        <label for="ano_publicacao">Ano de publicação</label>
                        <input type="date" name="ano_publicacao" id="ano_publicacao" placeholder="Ano de publicação" value="<?php echo htmlspecialchars($book['ano_publicacao']);?>" required>
                    </div>

                    <div class="input_container">
                        <label for="capa_livro">Capa do livro (opcional)</label>
                        <input type="file" name="capa_livro" id="capa_livro" placeholder="Arquivo da capa">
                    </div>
                    <button type="submit">Atualizar</button>
                </form>
            <?php else:?>
                <a href="meus_livros.php"><i class="fa-solid fa-circle-xmark"></i></a>
                <h3>Insira as informações do livro</h3>
                <form action="/sistem/service/cadastro_livro.php" method="post" enctype="multipart/form-data">
                    <div class="input_container">
                        <label for="autor">Autor</label>
                        <input type="text" name="autor" id="autor" placeholder="Autor do livro" required>
                    </div>

                    <div class="input_container">
                        <label for="titulo">Título</label>
                        <input type="text" name="titulo" id="titulo" placeholder="Título do livro" required>
                    </div>

                    <div class="input_container">
                        <label for="subtitulo">Subtítulo (Máx 50 carac.)</label>
                        <input type="text" name="subtitulo" id="subtitulo" placeholder="Subtítulo do livro" required maxlength="50">
                    </div>

                    <div class="input_container">
                        <label for="edicao">Edição</label>
                        <input type="number" name="edicao" id="edicao" placeholder="Número da edição" required>
                    </div>

                    <div class="input_container">
                        <label for="editora">Editora</label>
                        <input type="text" name="editora" id="editora" placeholder="Editora do livro" required>
                    </div>

                    <div class="input_container">
                        <label for="ano_publicacao">Ano de publicação</label>
                        <input type="date" name="ano_publicacao" id="ano_publicacao" placeholder="Ano de publicação" required>
                    </div>

                    <div class="input_container">
                        <label for="capa_livro">Capa do livro (opcional)</label>
                        <input type="file" name="capa_livro" id="capa_livro" placeholder="Arquivo da capa">
                    </div>
                    <button type="submit">Registrar</button>
                </form>
            <?php endif;?>
        </div>
            </div>

            <button id="btnAdd"><i class="fa-solid fa-plus"></i>Adicionar</button>
        </section>
        <section class="table">
                <div class="table_elements">
                    <?php foreach ($books as $book): ?>
                    <div class="element">
                        <?php if ($book['capa']): ?>
                                <img src="/sistem/user_images/<?php echo htmlspecialchars($book['capa']); ?>" alt="Capa do livro" class="capa">
                            <?php else: ?>
                                Sem capa
                        <?php endif; ?>
                        <div>
                            <div class="content_area">
                                <p><span>Autor: </span><?php echo htmlspecialchars($book['autor']); ?></p>
                                <p><span>Título: </span><?php echo htmlspecialchars($book['titulo']); ?></p>
                                <p><span>Subtítulo: </span><?php echo htmlspecialchars($book['subtitulo']); ?></p>
                                <p><span>Edição: </span><?php echo htmlspecialchars($book['edicao']); ?></p>
                                <p><span>Editora: </span><?php echo htmlspecialchars($book['editora']); ?></p>
                                <p><span>Data: </span><?php htmlspecialchars($book['ano_publicacao']); ?></p>
                            </div>

                            <div class="acoes">
                                <a class="editBtn" href="http://jrmlibrary.test/meus_livros.php?id=<?= htmlspecialchars($book['id']); ?>"><i class="fa-solid fa-pen-nib"></i></a>
                                <a href="http://jrmlibrary.test/meus_livros.php?idRemove=<?= htmlspecialchars($book['id']); ?>"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </table>
        </section>
    </main>

    <script src="/src/scripts/painel/meus_livros.js"></script>
</body>
</html>