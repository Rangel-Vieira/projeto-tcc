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
                            <a href="/task"><i class="material-icons">visibility</i></a>
                            <a href="/task/edit"><i class="material-icons">edit</i></a>
                            <a href="/task/delete"><i class="material-icons">delete</i></a>
                        </div>
                    </footer>
                </section>
            </div>
        </div>
    </main>
    <?php require_once ROOT_DIR . 'views/footer.php' ?>
    </body>
</html>