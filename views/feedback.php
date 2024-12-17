<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once ROOT_DIR . 'views/defaultHeadConfigs.php' ?>
    <title>Gerenciador de tarefas</title>
</head>
<body>
    <header id="header">
        <?php require_once ROOT_DIR . 'views/header.php' ?>
        <h1>Bem vindo ao gerenciador de tarefas!</h1>
    </header>
    <main id="main">
        <div class="container">
            <p class="container-title">A atividade foi <?= $acao ?> com sucesso</p>
            <a href="/">
                <button type="button" id="button-task-go-back" class="styled-button green spacing-bottom">
                    Voltar
                </button>
            </a>
        </div>
    </main>
    <?php require_once ROOT_DIR . 'views/footer.php' ?>
    </body>
</html>