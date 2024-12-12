<?php 

namespace Rangel\Config;
use PDO;

class Connection {

    public static function getConnection(): PDO{
        $databasePath = ROOT_DIR . 'database.sqlite';
        $connection = new PDO('sqlite:' . $databasePath);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $connection;
    }

}