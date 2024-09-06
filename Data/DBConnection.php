<?php

namespace Data;

use mysqli;
require("DB.php");

class DBConnection
{
    public function __construct(){

    }
    public function get_db_connection() {
        $data = new DB();
        $conn = new mysqli($data->get_server_name(), $data->get_user_name(), $data->get_password(), $data->get_db_name());
        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error);
        }
        #echo "Connected to DB successfully<br ><br >";
        return $conn;
    }
}