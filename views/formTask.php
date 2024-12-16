<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once ROOT_DIR . 'views/defaultHeadConfigs.php' ?>
    <title>Editar tarefa</title>
</head>
<body>
    <header id="header">
        <?php require_once ROOT_DIR . 'views/header.php' ?>
        <h1>Edição de tarefa</h1>
    </header>
    <main id="main">
        <div class="container">
            <center>
                <form action="/task/createEdit" class="form-task" method="post">
                    <input type="hidden" id="input-id" name="input-id" value="<?= $task->id ?>">
                    <input id="input-title" name="input-title" type="text" placeholder="Título" required value="<?= $task->title ?? '' ?>">
                    <textarea id="input-description" name="input-description" placeholder="Descrição" required><?= $task->description ?? '' ?></textarea>
                    <div class="flex space-between">
                        <label for="input-date">
                            Data de conclusão
                            <input id="input-date" name="input-date" type="date" value=<?= $task->doneDate ?>>
                        </label>
                        <label for="input-image">
                            Envie uma imagem
                            <input id="input-image" name="input-image" type="file" accept="image/png, image/gif, image/jpeg">
                        </label>
                        <label for="input-status">
                            Status
                            <select id="input-status" name="input-status">
                                <option value="pending" id="pending">Pendente</option>
                                <option value="completed" id="completed">Concluída</option>
                            </select>
                        </label>
                    </div>
                    <a href="/">
                        <button type="button" id="input-cancel" class="styled-button red">Cancelar</button>
                    </a>
                    <button type="submit" id="input-submit" class="styled-button green">Enviar</button>
                </form>
            </center>
            <script>
                $(() => {
                    const selected = $(<?= $task->status ?>);
                    selected.attr('selected', true);
                })
            </script>
        </div>
    </main>
    <?php require_once ROOT_DIR . 'views/footer.php' ?>
    </body>
</html>