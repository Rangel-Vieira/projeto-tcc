<?php 

use Rangel\Config\Connection;

$statusEnum = "'pending', 'completed'";
$connection = Connection::getConnection();
$connection->query('
        CREATE TABLE IF NOT EXISTS tb_task (
        id INTEGER PRIMARY KEY, 
        title TEXT NOT NULL, 
        description TEXT, 
        done_date TEXT, 
        status TEXT CHECK (status IN (' . $statusEnum . ')), 
        image_url TEXT)'
    );