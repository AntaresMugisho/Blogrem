<?php

namespace App;
use \PDO;


class Connection{

    public static function get_pdo() : PDO
    {
        return new PDO("mysql:dbname=data_b;host=localhost", "root", "root", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}
?>
