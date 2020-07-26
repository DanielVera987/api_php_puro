<?php
define('HOST', 'localhost');
define('NAME_BD', 'api_crud');
define('USER_BD', 'root');
define('PASSWORD_BD', '');

function conect()
{
  try {
    $conn = new PDO("mysql:host= {HOST};dbname={NAME_BD};charset=utf8", USER_BD, PASSWORD_BD);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $conn;
  } catch (PDOException $exception) {
    exit($exception->getMessage());
  }
}
