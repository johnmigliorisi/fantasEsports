<?php
class DBHandler {
    private $db;

    function __construct() {
        $this->connect_database();
    }

    public function getInstance() {
        return $this->db;
    }

    private function connect_database() {
        define('USER', 'dl7_fantasy');
        define('PASSWORD', 'HOCfantasy');

        // Database connection
        try {
            $connection_string = 'mysql:host=localhost;dbname=dl7_fantasy_esports;charset=utf8';
            $connection_array = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            );

            $this->db = new PDO($connection_string, USER, PASSWORD, $connection_array);
            // echo 'Database connection established';
        }
        catch(PDOException $e) {
            $this->db = null;
        }
    }   
}

?>