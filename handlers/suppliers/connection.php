<?php

class Database{

    public static $connection;
    public static function connection(){
        if(!isset(Database::$connection)){
            Database::$connection = new mysqli("ecoplantlk.com","ecoplant","iDS6]19GP!sqx0","ecoplant_ecoplant_db","3306");
        }
    }

    public static function iud($q){
        Database::connection();
        Database::$connection->query($q);
    }

    public static function search($q){
        Database::connection();
        $resultset = Database::$connection->query($q);
        return $resultset;
    }

}
?>