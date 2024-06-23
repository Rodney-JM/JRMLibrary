<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
        header("Location: http://jrmlibrary.test/");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel - FrancisComic</title>

    
    <!-- icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Palanquin:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="src/styles/home_main.css">
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
                <a href="#"><li><i class="fa-solid fa-house"></i>Início</li></a>
                <a href="meus_livros.php"><li><i class="fa-solid fa-book"></i>Meus livros</li></a>
                <a href="index.php?session=destroy"><li><i class="fa-solid fa-user"></i>Sair</li></a>
            </ul>
        </nav>
    </header>
    <main class="home_main">
        <section class="image_container">
            <img src="/src/assets/images/bookstore.svg" alt="Bookstore image" class="bookstore_image">
        </section>
        <section class="text_container">
            <div class="logo">
                <img src="/src/assets/icons/OIG3.jpg" alt="">
                <h2>Francis<span>Comic</span></h2>
            </div>
            
            <p>FrancisComic é uma plataforma online projetada para simplificar a gestão de bibliotecas pessoais e coleções de livros. Com uma interface intuitiva e amigável, os usuários <br>podem facilmente adicionar novos livros à sua biblioteca, atualizar informações como status de leitura ou classificação, e até mesmo excluir títulos quando necessário.</p>
            <ul class="medias">
                <a href="https://github.com/Rodney-JM" target="_blank"><li><i class="fa-brands fa-github"></i></li></a>
                <a href="https://www.linkedin.com/in/rondiney-patr%C3%ADcio-258234298/" target="_blank"><li><i class="fa-brands fa-linkedin-in"></i></li></a>
                <a href="" target="_blank"><li><i class="fa-brands fa-instagram"></i></li></a>
            </ul>

            <a href="meus_livros.php" class="start_button">Começar agora</a>
        </section>
    </main>
    
</body>
</html>
