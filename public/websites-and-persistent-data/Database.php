<?php
namespace Websites_And_Persistent_Data;

class Database {
    public static function initialize ($engine, $hostname, $username, $password, $database)
    {
        $dsn = "$engine:host=$hostname;dbname=$database";
        try {
            $dbh = new \PDO($dsn, $username, $password);
            $dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        catch (\PDOException $e) {
            die("Connection failed: " . $e->getMessage() . "\n");
        }

        return $dbh;
    }
}
?>
