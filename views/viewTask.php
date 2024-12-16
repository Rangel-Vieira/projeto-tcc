<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once ROOT_DIR . 'views/defaultHeadConfigs.php' ?>
    <title>Editar tarefa</title>
</head>
<body>
    <header id="header">
        <?php require_once ROOT_DIR . 'views/header.php' ?>
        <h1>Visualização de tarefa</h1>
    </header>
    <main id="main">
        <div class="container">
            <center>
                <section class="form-task flex-column flex-center space-items">
                    <header class="flex space-around">
                        <div>
                            <p>Data de conclusão</p>
                            <p><?= $task->getDoneDate()->format('d-m-Y') ?? 'Não concluída' ?></p>
                        </div>
                        <div>
                            <p>Status</p>
                            <p><?= $task->getStatus() === 'completed' ? 'Completa' : 'Pendente' ?></p>
                        </div>
                    </header>    
                    <p><?= $task->getTitle() ?></p>
                    <p><?= $task->getDescription() ?></p>
                    <div>
                        <img src="./image.php?image_path=<?= $task->getImageUrl() ?>" alt="Imagem da atividade">
                    </div>
                    <a href="/">
                        <button type="button" id="button-task-go-back" class="styled-button green">
                            Voltar
                        </button>
                    </a>
                </section>
            </center>
        </div>
    </main>
    <?php require_once ROOT_DIR . 'views/footer.php' ?>
    </body>
</html>