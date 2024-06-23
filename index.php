<?php
    if(isset($_GET['session'])=="destroy"){
        session_start();
        session_destroy();

        header("Location: http://jrmlibrary.test/index.php");
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FrancisComic</title>

    <!-- icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Palanquin:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="./src/styles/registers_pages.css">
</head>
<body>
    <main>
        <section class="cadastro_section">
            <h2>Bem-vindo de volta<br>a FrancisComic <i class="fa-solid fa-book-bookmark"></i></h2>
            <p class="paraf">Melhore suas leituras usando nossa plataforma para a organização!</p>
            <form method="post" action="./sistem/service/login.php">
                <div class="input_container">
                    <label for="email">Email</label>
                    <i class="fa-solid fa-user"></i><input type="email" name="email"  id="email" placeholder="Insira seu email" required>
                </div>
                <div class="input_container">
                    <label for="password">Senha</label>
                    <i class="fa-solid fa-key"></i><input type="password" name="senha" id="password" placeholder="Insira sua senha" required>
                </div>
                <button type="submit">Entrar</button>
                <div id="error-message" style="display: none; color: rgb(255, 26, 26); font-family: Montserrat, sans-serif; text-wrap: wrap; text-align: center;"></div>
            </form>
            <p>ou</p>
            <a href="cadastro.php" class="jconta">Não tem uma conta? Cadastre-se</a>
        </section>
        <section class="image_section">
            <img src="./src/assets/images/bg2.jpg" alt="Background Japan Landscape">
        </section>
    </main>

    <script src="./src/scripts/login.js"></script>
    
</body>
</html>