<?php
include_once "config.php";
include_once "helpers.php";

$dbConn = conect();

if($_SERVER['REQUEST_METHOD'] == 'GET')
{
  if(isset($_GET['id']))
  {
    $sql = $dbConn->prepare("SELECT * FROM posts where id=:id");
    $sql->bindValue(':id', $_GET['id']);
    $sql->execute();
    header("HTTP/1.1 200 OK");
    echo json_encode($sql->fetch(PDO::FETCH_ASSOC));
    exit();
  }
  else
  {
    $sql = $dbConn->prepare("SELECT * FROM post");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    header("HTTP/1.1 200 OK");
    echo json_encode($sql->fetchAll());
    exit();
  }
}

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
  $input = $_POST;
  $sql = "INSERT INTO posts (title,status,content, user_id)
          VALUES 
          (:title, :status, :content, :user_id)";
  $statement = $dbConn->prepare($sql);
  bindAllValues($statement, $input);
  $statement->execute();
  $postId = $dbConn->lastInsertId();
  if($postId)
  {
    $input['id'] = $postId;
    header("HTTP/1.1 200 OK");
    echo json_encode($input);
    exit();
  }
}

if($_SERVER['REQUEST_METHOD'] == 'DELETE')
{
  $id = $_GET['id'];
  if(is_numeric($id))
  {
    $statement = $dbConn->prepare("DELETE FROM posts where id:id");
    $statement->bindValue(':id', $id);
    $statement->execute();
    header("HTTP/1.1 200 OK");
    exit();
  }

  header("HTTP/1.1 404");
  exit();
}

if($_SERVER['REQUEST_METHOD'] == 'PUT')
{
  $input = $_GET;
  $postId = $input['id'];
  $fields = getParams($input);

  $sql = "UPDATE posts SET $fields WHERE id=$postId";

  $statement = $dbConn->prepare($sql);
  bindAllValues($statement, $input);

  $statement->execute();
  header("HTTP/1.1 200 OK");
  exit();
}