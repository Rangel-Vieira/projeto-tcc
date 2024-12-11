<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar tarefa</title>
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/libs/google-fonts.css">
</head>
<body>
    <header id="header">
        <?php require_once '../views/header.php' ?>
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
                    <button type="button" id="button-task-go-back" class="green-button">Voltar</button>
                </section>
            </center>
        </div>
    </main>
    <?php require_once '../views/footer.php' ?>
    </body>
</html>