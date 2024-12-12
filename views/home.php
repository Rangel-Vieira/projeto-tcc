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
                <?php foreach($items as $item) { ?>
                    <section class="task-card" id="<?= $item['id'] ?>">
                        <header>
                            <p><?= $item['title'] ?></p>
                            <p><?= $item['status'] === 'completed' ? 'Completa' : 'Pendente' ?></p>
                        </header>
                        <div class="task-card-main">
                            <p><?= $item['description'] ?></p>
                            <figure>
                                <center>
                                    <img src="./image.php?image_path=<?= $item['image_url'] ?>" alt="Imagem atividade">
                                </center>
                            </figure>
                        </div>
                        <footer>
                            <p><?php $date = new DateTimeImmutable($item['done_date']); echo $date->format('d/m/y') ?></p>
                            <div>
                                <a href="/task?id=<?= $item['id'] ?>"><i class="material-icons">visibility</i></a>
                                <a href="/task/edit?id=<?= $item['id'] ?>"><i class="material-icons">edit</i></a>
                                <a href="/task/delete?id=<?= $item['id'] ?>"><i class="material-icons">delete</i></a>
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