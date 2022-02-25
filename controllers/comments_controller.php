<?php
  function commentNew() {
    global $db;
    // comment情報をDBに保存
    if (!empty($_POST['comment'])) {
      if (mb_strlen($_POST['comment'] < 51)) {
        $stmt = $db->prepare("INSERT INTO comments SET comment = :comment, name = :name, postcode = :postcode, created_at = now()");
        $stmt->bindValue(':comment', $_POST['comment'], PDO::PARAM_STR);
        $stmt->bindValue(':name', $_SESSION['login']["name"], PDO::PARAM_STR);
        $stmt->bindValue(':postcode', $_REQUEST['id'], PDO::PARAM_INT);
        $stmt->execute();
      }
    }
  }

  function commentEdit() {
    // DB接続処理
    require("../../db/dbconnect.php");
    db_connection();
    session_start();

    global $db;

    // ログインしていない場合ログイン画面に遷移させる
    if (!isset($_SESSION['login']['name'])) {
      header('../users/sessions/new.php');
      exit();
    }

    // comments情報取得
    $stmt = $db->prepare('SELECT * FROM comments WHERE id = :id');
    $stmt->bindValue(':id', $_REQUEST['id'], PDO::PARAM_INT);
    $stmt->execute();
    $commentDate = $stmt->fetch();

    if ($commentDate['del_flg'] === 1 || $commentDate['name'] != $_SESSION['login']['name']) {
      header('Location: http://localhost/views/posts/index.php');
      exit();
    }

    // PHPバリデーション
    if (!empty($_POST['comment']) && mb_strlen($_POST['comment'] < 51)) {
      // 投稿内容をDBに登録
      $stmt = $db->prepare("UPDATE LP2112003m_yoshida.comments SET comment = :comment, update_at = now() WHERE id = :id");
      $stmt->bindValue(':comment', $_POST["comment"], PDO::PARAM_STR);
      $stmt->bindValue(':id', $commentDate["id"], PDO::PARAM_INT);
      $stmt->execute();
      header('Location: http://localhost/views/posts/show.php?id='. $commentDate['postcode']);
      exit();
    }
  }

  function commentDestroy() {
    // DB接続処理
    require("../../db/dbconnect.php");
    db_connection();
    session_start();

    global $db;

    // ログインしていない場合ログイン画面に遷移させる
    if (!isset($_SESSION['login']['name'])) {
      header('../users/sessions/new.php');
      echo "ログインしていません";
      exit();
    }

    // urlにidがない、またはidが数字ではない、またはidが0以下の場合一覧ページに遷移させる。
    if (!isset($_REQUEST['id']) || !is_numeric($_REQUEST['id']) || $_REQUEST['id'] <= 0) {
      header('Location: index.php');
      exit();
    }

    // comments情報取得
    $stmt = $db->prepare('SELECT name, del_flg, postcode FROM comments WHERE id = :id');
    $stmt->bindValue(':id', $_REQUEST['id'], PDO::PARAM_INT);
    $stmt->execute();
    $commentDate = $stmt->fetch();

    // ログインしているユーザネームとpostsテーブルのnameが同じであれば処理を実行
    if ($_SESSION['login']['name'] === $commentDate['name']) {
      $stmt = $db->prepare('UPDATE LP2112003m_yoshida.comments SET del_flg = :del_flg WHERE id = :id');
      $stmt->bindValue(':id', $_REQUEST['id'], PDO::PARAM_INT);
      $stmt->bindValue(':del_flg', 1, PDO::PARAM_INT);
      $stmt->execute();
      header('Location: http://localhost/views/posts/show.php?id='. $commentDate['postcode']);
      echo "削除しました";
    } else {
      header('Location: index.php');
      // echo "削除できませんでした。";
    }
  }
?>