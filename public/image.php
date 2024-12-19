<?php 

//TODO: Esse código tem um problema de segurança, por ficar na pasta pública, pode ser chamado diretamente na URL e dar acessos indevidos...
//Para fins do projeto não resolvi, mas em uma aplicação real poderia se tornar um problema

$path = $_GET['image_path'] != null ? '../media/img/' . $_GET['image_path'] : './img/default_image.png';
if ($path && file_exists($path)) {
    read($path);
}

function read($path){
    $mimeType = mime_content_type($path);
    header('Content-Type: ' . $mimeType);
    readfile($path);
    exit;
}