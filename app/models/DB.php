<?php
class DB
{
    public static   $connection = NULL;
    public function __construct()
    {
        if (!self::$connection) {
            self::$connection =  new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            self::$connection->set_charset('utf8mb4');
        }
        return self::$connection;
    }
    public function select($sql)
    {
        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function selectArrayNum($sql)
    {
        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_NUM);
    }
    public function select_one($sql)
    {
        $sql->execute();
        return $sql->get_result()->fetch_assoc();
    }
}
