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
            <h2>Bem-vindo a FrancisComic <i class="fa-solid fa-book-bookmark"></i></h2>
            <p class="paraf">Melhore suas leituras usando nossa plataforma para a organização!</p>
            <form method="post" action="./sistem/service/cadastro.php" id="form">
                <div class="input_container">
                    <label for="nome">Nome</label>
                    <i class="fa-solid fa-pen"></i><input type="text" name="nome"  id="nome" placeholder="Insira seu nome" required>
                </div>
                <div class="input_container">
                    <label for="password">Email</label>
                    <i class="fa-solid fa-user-tag"></i><input type="email" name="email" id="email" placeholder="Insira o seu email" required>
                </div>
                <div class="input_container">
                    <label for="senha">Senha</label>
                    <i class="fa-solid fa-key"></i><input type="password" name="senha"  id="senha" placeholder="Crie sua senha" required>
                </div>
                <div class="input_container">
                    <label for="senhaConfirm">Senha(Confirmação)</label>
                    <i class="fa-solid fa-key"></i><input type="password" name="senhaConfirm" id="senhaConfirm" placeholder="Insira sua senha" required>
                </div>
                <button type="submit" id="btn">Cadastrar</button>
                <div id="error-message" style="display: none; color: rgb(255, 26, 26); font-family: Montserrat, sans-serif;"></div>
            </form>
            <p>ou</p>
            <a href="index.php" class="jconta">Já tem uma conta? Entre</a>
        </section>
        <section class="image_section">
            <img src="./src/assets/images/bg2.jpg" alt="Background Japan Landscape">
        </section>
    </main>

    <script src="./src/scripts/main.js"></script>
    
</body>
</html>