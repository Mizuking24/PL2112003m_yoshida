<?php
  // DB接続処理
  require("../../db/dbconnect.php");
  db_connection();
  session_start();

  global $db;

  // ログインしていない場合ログイン画面に遷移させる
  // if (!isset($_SESSION['login']['name'])) {
  //   header('../users/sessions/new.php');
  //   exit();
  // }

  // urlにidがない、またはidが数字ではない、またはidが0以下の場合一覧ページに遷移させる。
  // if (!isset($_REQUEST['id']) || !is_numeric($_REQUEST['id']) || $_REQUEST['id'] <= 0) {
  //   header('Location: index.php');
  //   exit();
  // }

  // post情報取得
  $stmt = $db->prepare('SELECT * FROM posts WHERE id = :id');
  $stmt->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
  $stmt->execute();
  $postdate = $stmt->fetch();
  // post情報を取得できていなければ投稿一覧画面へ遷移させる。
  if (!isset($postdate['title']) || $postdate['del_flg'] === true) {
    header('Location: index.php');
    exit();
  }

  // likes情報取得
  $stm = $db->prepare('SELECT name FROM likes WHERE postcode = :postcode');
  $stm->bindValue(':postcode', $postdate['id'], PDO::PARAM_INT);
  $stm->execute();

  // likesテーブルのfavoを0にする
  while($likeDate = $stm->fetch()) {
    if ($likeDate['name'] === $_SESSION['login']['name']) {
      $stmt = $db->prepare('UPDATE LP2112003m_yoshida.likes SET favo = :favo, update_at = now() WHERE postcode = :postcode');
      $stmt->bindValue(':favo', 0, PDO::PARAM_INT);
      // $stmt->bindValue(':name', $_SESSION['login']['name'], PDO::PARAM_STR);
      $stmt->bindValue(':postcode', $_SESSION['id'], PDO::PARAM_INT);
      $stmt->execute();
      // header('Location: http://localhost/views/posts/show.php?id='. $_SESSION['id']);
      exit();
    }
  }

  // likesテーブルのfavoを0にする
  // $stmt = $db->prepare('UPDATE LP2112003m_yoshida.likes SET favo = :favo, update_at = now() WHERE name = :name');
  // $stmt->bindValue(':favo', 0, PDO::PARAM_INT);
  // $stmt->bindValue(':name', $_SESSION['login']['name'], PDO::PARAM_STR);
  // $stmt->execute();
  // // header('Location: http://localhost/views/posts/show.php?id='. $_REQUEST['id']);
  // exit();
?>