<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de tarefas</title>
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/libs/google-fonts.css">
</head>
<body>
    <header id="header">
        <?php require_once '../views/header.php' ?>
        <h1>Bem vindo ao gerenciador de tarefas!</h1>
    </header>
    <main id="main">
        <div class="container">
            <p class="container-title">Aqui você poderá visualizar, alterar ou excluir suas atividades quando quiser</p>
            <div class="task-cards">
                <section class="task-card">
                    <header>
                        <p>Título</p>
                        <p>Status</p>
                    </header>
                    <div class="task-card-main">
                        <p>Descrição</p>
                        <figure>
                            <center>
                                <img src="./image.php?image_path=../media/img/vaso.jpeg" alt="Imagem atividade">
                            </center>
                        </figure>
                    </div>
                    <footer>
                        <p>Data de conclusão</p>
                        <div>
                            <a href="#"><i class="material-icons">visibility</i></a>
                            <a href="#"><i class="material-icons">edit</i></a>
                            <a href="#"><i class="material-icons">delete</i></a>
                        </div>
                    </footer>
                </section>
            </div>
        </div>
    </main>
    <?php require_once '../views/footer.php' ?>
    </body>
</html>