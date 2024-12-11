<?php 

$path = isset($_GET['image_path']) ? $_GET['image_path'] : false;

if ($path && file_exists($path)) {
    $mimeType = mime_content_type($path);
    header('Content-Type: ' . $mimeType);
    readfile($path);
}