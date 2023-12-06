<?php 
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    const DB_SERVER = 'localhost';
    const DB_NAME = 'TechNest';
    const DB_USER = 'root';
    const DB_PASSWORD = 'root';

    $base = mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);

?>