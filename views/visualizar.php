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
                            <p>DATA</p>
                        </div>
                        <div>
                            <p>Status</p>
                            <p>STATUS</p>
                        </div>
                    </header>    
                    <p>Título da atividade</p>
                    <p>Descrição da atividade</p>
                    <div>
                        <img src="./image.php?image_path=../media/img/vaso.jpeg" alt="Imagem da atividade">
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
    <?php require_once '../views/footer.php' ?>
    </body>
</html>