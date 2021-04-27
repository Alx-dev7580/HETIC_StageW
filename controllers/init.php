<?php 
   session_start();
   
   //include configurations
   include_once('../config/autoload.php');

   //require models
   require_once('../config/database.php');
   require_once('../models/common.php');
   require_once('../models/users.php');

   //instentiation
   $database = new Database();
   $db = $database->db;
   $cmn = new Common();
   $usr = new Users();
?>