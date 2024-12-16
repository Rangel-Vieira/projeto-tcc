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
            <a href="/task/new">
                <button type="button" id="button-task-go-back" class="styled-button green spacing-bottom">
                    Adicionar
                </button>
            </a>
            <p class="container-title">Aqui você poderá visualizar, alterar ou excluir suas atividades quando quiser</p>
            <div class="task-cards">
                <?php foreach($items as $item) { ?>
                    <section class="task-card" id="<?= $item->getId() ?>">
                        <header>
                            <p><?= $item->getTitle() ?></p>
                            <p><?= $item->getStatus() === 'completed' ? 'Completa' : 'Pendente' ?></p>
                        </header>
                        <div class="task-card-main">
                            <p><?= $item->getDescription() ?></p>
                            <figure>
                                <center>
                                    <img src="./image.php?image_path=<?= $item->getImageUrl() ?>" alt="Imagem atividade">
                                </center>
                            </figure>
                        </div>
                        <footer>
                            <p><?php $item->getDoneDate()->format('d-m-Y') ?></p>
                            <div>
                                <a href="/task?id=<?= $item->getId() ?>"><i class="material-icons">visibility</i></a>
                                <a href="/task/edit?id=<?= $item->getId() ?>"><i class="material-icons">edit</i></a>
                                <a href="/task/delete?id=<?= $item->getId() ?>"><i class="material-icons">delete</i></a>
                            </div>
                        </footer>
                    </section>    
                <?php  } ?>
            </div>
        </div>
    </main>
    <?php require_once ROOT_DIR . 'views/footer.php' ?>
    </body>
</html>