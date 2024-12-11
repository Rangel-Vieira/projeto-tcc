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
        <h1>Edição de tarefa</h1>
    </header>
    <main id="main">
        <div class="container">
            <center>
                <form action="" class="form-task">
                    <input id="input-title" name="input-title" type="text" placeholder="Título" required>
                    <textarea id="input-description" name="input-description" placeholder="Descrição" required></textarea>
                    <div class="flex space-between">
                        <label for="input-date">
                            Data de conclusão
                            <input id="input-date" name="input-date" type="date">
                        </label>
                        <label for="input-image">
                            Envie uma imagem
                            <input id="input-image" type="file" accept="image/png, image/gif, image/jpeg">
                        </label>
                        <label for="input-status">
                            Status
                            <select id="input-status" name="input-status">
                                <option value="pending" selected>Pendente</option>
                                <option value="completed">Concluída</option>
                            </select>
                        </label>
                    </div>
                    <button type="submit" id="input-submit" class="green-button">Enviar</button>
                </form>
            </center>
        </div>
    </main>
    <?php require_once '../views/footer.php' ?>
    </body>
</html>