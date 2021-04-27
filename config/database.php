<?php
    class Database {
        public $db;

        public function __construct()
        {
            try {
                $this->db = new PDO(SGBD.':host='.HOST.';dbname='.DB_NAME,DB_USER,DB_PASSWORD,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            }
            catch(Exception $e) {
                trigger_error($e->getMessage(),E_USER_ERROR);
            }
        }
    }
?>