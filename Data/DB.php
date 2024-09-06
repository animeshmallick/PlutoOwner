<?php

namespace Data;

class DB
{
    private $servername;
    private $username;
    private $password;
    private $dbname;

    function __construct() {
        $this->set_server_name();
        $this->set_user_name();
        $this->set_password();
        $this->set_db_name();
    }
    function set_server_name()
    {
        $this->servername = "localhost";
    }
    function set_user_name()
    {
        $this->username = "root";
    }
    function set_password()
    {
        $this->password = "";
    }
    function set_db_name()
    {
        $this->dbname = "shop";
    }

    function get_user_name()
    {
        return $this->username;
    }
    function get_server_name()
    {
        return $this->servername;
    }
    function get_password()
    {
        return $this->password;
    }
    function get_db_name()
    {
        return $this->dbname;
    }
}