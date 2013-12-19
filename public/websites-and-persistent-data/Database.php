<?php
namespace Websites_And_Persistent_Data;

class Database {
    public static function initialize ($hostname, $username, $password, $database) {

        $dbh = new \mysqli($hostname, $username, $password, $database);

        if ($dbh->connect_error) {
            die("Connection failed: " . mysqli_connect_error() . "\n");
        }

        return $dbh;
    }
}
?>
