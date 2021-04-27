<?php 
    // paramètres base de donnéees
    define('DB_NAME', "gestion_contact");
    define('DB_USER', "root");
    define('DB_PASSWORD', "");
    define('HOST', "localhost");
    define('SGBD', "mysql");

    //nom des tables
    define('T_USERS', "users");

    //configuration public
    $base  = "http://".$_SERVER['HTTP_HOST'];
    $base .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
    define('BASE_URL', $base.'public/');
    define('REQUEST', $base.'controllers/');
?>