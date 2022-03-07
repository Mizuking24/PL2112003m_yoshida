<?php
  // DB接続処理
  require("../db/dbconnect.php");
  db_connection();

  global $db;

  header('Content-type: application/json; charset=UTF-8');

  if (isset($_GET['name'])) {
    $param = htmlspecialchars($_GET['name']);

    $users["status"] = "yes";
    $stmt = $db->prepare("SELECT * FROM users WHERE name = ?");
    $stmt->execute(array($_GET['name']));
    $users["user_info"] = $stmt->fetch();
  } else {
    $users["status"] = "no";
  }

  print json_encode($users, JSON_PRETTY_PRINT);
?>