<?php
require './sistem/models/Connection.php';

try {
    $pdo = Connection::connect('./sistem/settings.ini');

    $sql = "SELECT id, autor, titulo, subtitulo, edicao, editora, ano_publicacao, capa_livro FROM livros";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($books === false) {
        $books = [];
    }

    $book = null;
    if (isset($_GET['id'])) {
        $book_id = $_GET['id'];
        if ($book_id) {
            $sql = "SELECT id, autor, titulo, subtitulo, edicao, editora, ano_publicacao, capa_livro, usuario FROM livros WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $book_id]);
            $book = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }if(isset($_GET['idRemove'])){
        $book_id = $_GET['idRemove'];
        $sql = "DELETE FROM livros WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":id"=> $book_id]);

        header("Location: http://jrmlibrary.test/meus_livros.php");
    }
} catch (Exception $e) {
    echo 'Erro ao buscar dados: ' . $e->getMessage();
    $books = [];
}
?>

<!DOCTYPE html>
<html lang="en">
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

    <link rel="stylesheet" href="src/styles/meus_livros.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo_container">
                <img src="/src/assets/icons/OIG3.png" alt="Logo imagem">
                <h3>FrancisComic</h3>
            </div>
            <ul>
                <a href="painel.php"><li><i class="fa-solid fa-house"></i>Início</li></a>
                <a href="#"><li><i class="fa-solid fa-book"></i>Meus livros</li></a>
                <a href="index.php"><li><i class="fa-solid fa-user"></i>Sair</li></a>
            </ul>
        </nav>
    </header>

    <main>
        <section class="title">
            <div class="topic">
                <i class="fa-solid fa-book"></i><h2>Meus livros</h2>
            </div>

            <div class="form_container active">
                <?php if ($book): ?>
                <i class="fa-solid fa-circle-xmark"></i>
                <h3>Editar informações do livro</h3>
                <form action="/sistem/service/cadastro_livro.php?id=<?= htmlspecialchars($book['id']); ?>" method="post">
                    <div class="input_container">
                        <label for="autor">Autor</label>
                        <input type="text" name="autor" id="autor" placeholder="Autor do livro" value="<?php echo htmlspecialchars($book['autor']); ?>" required>
                    </div>

                    <div class="input_container">
                        <label for="titulo">Título</label>
                        <input type="text" name="titulo" id="titulo" placeholder="Título do livro" value="<?php echo htmlspecialchars($book['titulo']); ?>" required>
                    </div>

                    <div class="input_container">
                        <label for="subtitulo">Subtítulo</label>
                        <input type="text" name="subtitulo" id="subtitulo" placeholder="Subtítulo do livro" value="<?php echo htmlspecialchars($book['subtitulo']); ?>" required>
                    </div>

                    <div class="input_container">
                        <label for="edicao">Edição</label>
                        <input type="number" name="edicao" id="edicao" placeholder="Número da edição" value="<?php echo htmlspecialchars($book['edicao']); ?>" required>
                    </div>

                    <div class="input_container">
                        <label for="editora">Editora</label>
                        <input type="text" name="editora" id="editora" placeholder="Editora do livro" value="<?php echo htmlspecialchars($book['editora']); ?>" required>
                    </div>

                    <div class="input_container">
                        <label for="ano_publicacao">Ano de publicação</label>
                        <input type="date" name="ano_publicacao" id="ano_publicacao" placeholder="Ano de publicação" value="<?php echo htmlspecialchars($book['ano_publicacao']); ?>" required>
                    </div>

                    <div class="input_container">
                        <label for="capa_livro">Capa do livro (opcional)</label>
                        <input type="text" name="capa_livro" id="capa_livro" placeholder="Arquivo da capa" value="<?php echo htmlspecialchars($book['capa_livro']); ?>">
                    </div>
                    <button type="submit">Atualizar</button>
                </form>
                <?php else: ?>
                <i class="fa-solid fa-circle-xmark"></i>
                <h3>Insira as informações do livro</h3>
                <form action="/sistem/service/cadastro_livro.php" method="post">
                <div class="input_container">
                        <label for="autor">Autor</label>
                        <input type="text" name="autor" id="autor" placeholder="Autor do livro" required>
                    </div>

                    <div class="input_container">
                        <label for="titulo">Título</label>
                        <input type="text" name="titulo" id="titulo" placeholder="Título do livro" required>
                    </div>

                    <div class="input_container">
                        <label for="subtitulo">Subtítulo</label>
                        <input type="text" name="subtitulo" id="subtitulo" placeholder="Subtítulo do livro" required>
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
                        <input type="text" name="capa_livro" id="capa_livro" placeholder="Arquivo da capa">
                    </div>
                    <button type="submit">Registrar</button>
                </form>
                <?php endif; ?>
            </div>

            <button id="btnAdd"><i class="fa-solid fa-plus"></i>Adicionar</button>
        </section>
        <section class="table">
            <table>
                <thead>
                    <tr class="cab">
                        <th>Autor</th>
                        <th>Título</th>
                        <th>Subtítulo</th>
                        <th>Edição</th>
                        <th>Editora</th>
                        <th>Ano</th>
                        <th>Capa</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($books as $book): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($book['autor']); ?></td>
                        <td><?php echo htmlspecialchars($book['titulo']); ?></td>
                        <td><?php echo htmlspecialchars($book['subtitulo']); ?></td>
                        <td><?php echo htmlspecialchars($book['edicao']); ?></td>
                        <td><?php echo htmlspecialchars($book['editora']); ?></td>
                        <td><?php echo htmlspecialchars($book['ano_publicacao']); ?></td>
                        <td><?php echo htmlspecialchars($book['capa_livro']); ?></td>
                        <td class="acoes">
                            <a class="editBtn" href="http://jrmlibrary.test/meus_livros.php?id=<?= htmlspecialchars($book['id']); ?>"><i class="fa-solid fa-pen-nib"></i></a>

                            <a href="http://jrmlibrary.test/meus_livros.php?idRemove=<?= htmlspecialchars($book['id']); ?>"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>

    <script src="src/scripts/painel.js"></script>
</body>
</html>
