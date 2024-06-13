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

    <link rel="stylesheet" href="src/styles/home_page.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo_container">
                <img src="/src/assets/icons/OIG3.png" alt="Logo imagem">
                <h3>FrancisComic</h3>
            </div>
            <ul>
                <li><i class="fa-solid fa-house"></i>Início</li>
                <li><i class="fa-solid fa-book"></i>Meus livros</li>
                <li><i class="fa-solid fa-user"></i>Sair</li>
            </ul>
        </nav>
    </header>
    
</body>
</html>
