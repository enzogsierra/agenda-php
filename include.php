<?php
require __DIR__ . "/vendor/autoload.php";
use Model\ActiveRecord;

// Conectar a la db
function connectDB(): mysqli
{
    $db = new mysqli("localhost", "root", "root", "agendaphp");
    if(!$db) debug("Error al conectar a la db");
    return $db;
}
$db = connectDB();
ActiveRecord::setDB($db);

//
function debug($var, $exit = 1)
{
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    if($exit) exit;
}