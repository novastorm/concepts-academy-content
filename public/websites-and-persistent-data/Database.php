<?php
namespace Websites_And_Persistent_Data;

use PDO;

class Database {
    public static function initialize ($engine, $hostname, $username, $password, $database)
    {
        $dsn = "$engine:host=$hostname;dbname=$database";

        $dbh = new PDO($dsn, $username, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $dbh;
    }
}
?>
