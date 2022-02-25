<?php
  function replyIndex() {
    // DB接続処理
    require("../../db/dbconnect.php");
    db_connection();
    session_start();

    // ログインしていない場合ログイン画面に遷移させる
    if (!isset($_SESSION['login']['name'])) {
      header('../users/sessions/new.php');
      exit();
    }

    // urlにidがない、またはidが数字ではない、またはidが0以下の場合一覧ページに遷移させる。
    if (!isset($_REQUEST['id']) || !is_numeric($_REQUEST['id']) || $_REQUEST['id'] <= 0) {
      header('Location: index.php');
      exit();
    }

    global $db;

    // reply情報をDBに保存
    if (!empty($_POST['reply'])) {
      if (mb_strlen($_POST['reply'] < 51)) {
        $stmt = $db->prepare("INSERT INTO replies SET reply = :reply, name = :name, commentcode = :commentcode, created_at = now()");
        $stmt->bindValue(':reply', $_POST['reply'], PDO::PARAM_STR);
        $stmt->bindValue(':name', $_SESSION['login']["name"], PDO::PARAM_STR);
        $stmt->bindValue(':commentcode', $_REQUEST['id'], PDO::PARAM_INT);
        $stmt->execute();
      }
    }
  }

  function replyEdit() {
    // DB接続処理
    require("../../db/dbconnect.php");
    db_connection();
    session_start();

    // ログインしていない場合ログイン画面に遷移させる
    if (!isset($_SESSION['login']['name'])) {
      header('../users/sessions/new.php');
      exit();
    }

    global $db;

    // replies情報取得
    $stmt = $db->prepare('SELECT * FROM replies WHERE id = :id');
    $stmt->bindValue(':id', $_REQUEST['id'], PDO::PARAM_INT);
    $stmt->execute();
    $replyDate = $stmt->fetch();

    if ($replyDate['del_flg'] === 1 || $replyDate['name'] != $_SESSION['login']['name']) {
      header('Location: http://localhost/views/posts/index.php');
      exit();
    }

    // PHPバリデーション
    if (!empty($_POST['reply']) && mb_strlen($_POST['reply'] < 51)) {
      // 投稿内容をDBに登録
      $stmt = $db->prepare("UPDATE LP2112003m_yoshida.replies SET reply = :reply, update_at = now() WHERE id = :id");
      $stmt->bindValue(':reply', $_POST["reply"], PDO::PARAM_STR);
      $stmt->bindValue(':id', $replyDate["id"], PDO::PARAM_INT);
      $stmt->execute();
      header('Location: http://localhost/views/replies/index.php?id='. $replyDate['commentcode']);
      exit();
    }
  }

  function replyDestroy() {
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

    // replies情報取得
    $stmt = $db->prepare('SELECT * FROM replies WHERE id = :id');
    $stmt->bindValue(':id', $_REQUEST['id'], PDO::PARAM_INT);
    $stmt->execute();
    $replyDate = $stmt->fetch();

    // ログインしているユーザネームとrepliesテーブルのnameが同じであれば処理を実行
    if ($_SESSION['login']['name'] === $replyDate['name']) {
      $stmt = $db->prepare('UPDATE LP2112003m_yoshida.replies SET del_flg = :del_flg WHERE id = :id');
      $stmt->bindValue(':id', $_REQUEST['id'], PDO::PARAM_INT);
      $stmt->bindValue(':del_flg', 1, PDO::PARAM_INT);
      $stmt->execute();
      header('Location: http://localhost/views/replies/index.php?id='. $replyDate['commentcode']);
      // echo "削除しました";
    } else {
      header('Location: index.php');
      // echo "削除できませんでした。";
    }
  }
?>