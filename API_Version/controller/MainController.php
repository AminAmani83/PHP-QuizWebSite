<?php


class MainController
{
    protected $f3;
    protected $db;

    function __construct()
    {
        $this->f3 = BASE::instance();
        $this->db = new DB\SQL(
            $this->f3->get('dbName'),
            $this->f3->get('dbUsername'),
            $this->f3->get('dbPassword'),
            array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION)
        );
    }

}