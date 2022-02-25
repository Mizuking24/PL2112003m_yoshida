<?php
  function postNew() {
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


    // // 画像を含めた投稿の保存
    if(!empty($_FILES['image']['name'][0]) && !empty($_FILES['image']['name'][1])){
      // 画像ファイル名を取得
      $filename1 = $_FILES['image']['name'][0];
      $filename2 = $_FILES['image']['name'][1];

      // move_uploaded_fileの第二引数
      $uploaded_path1 = '/Applications/MAMP/htdocs/PL2112003m_yoshida/images/'. $filename1;
      $uploaded_path2 = '/Applications/MAMP/htdocs/PL2112003m_yoshida/images/'. $filename2;

      // 画像をローカルフォルダに移す。
      $result1 = move_uploaded_file($_FILES['image']['tmp_name'][0], $uploaded_path1);
      $result2 = move_uploaded_file($_FILES['image']['tmp_name'][1], $uploaded_path2);

      if ($result1 && $result2) {
        $image_path = $uploaded_path;
        // PHPバリデーション
        if (!empty($_POST['title']) && !empty($_POST['body'])) {
          if (mb_strlen ($_POST["title"]) < 21) {
            if (mb_strlen ($_POST["body"]) < 101) {
              // 投稿内容をDBに登録
              $stmt = $db->prepare("INSERT INTO posts SET title = :title, body = :body, name = :name, image = :image, image2 = :image2, created_at = now()");
              $stmt->bindValue(':title', $_POST["title"], PDO::PARAM_STR);
              $stmt->bindValue(':body', $_POST["body"], PDO::PARAM_STR);
              $stmt->bindValue(':name', $_SESSION['login']['name'], PDO::PARAM_STR);
              $stmt->bindValue(':image', $filename1);
              $stmt->bindValue(':image2', $filename2);
              $stmt->execute();
              header('Location: index.php');
              exit();
            }
          }
        }
      }
    } else if (!empty($_FILES['image']['name'][0])) {
      // 画像ファイル名を取得
      $filename1 = $_FILES['image']['name'][0];

      // move_uploaded_fileの第二引数
      $uploaded_path1 = '/Applications/MAMP/htdocs/PL2112003m_yoshida/images/'. $filename1;

      // 画像をローカルフォルダに移す。
      $result1 = move_uploaded_file($_FILES['image']['tmp_name'][0], $uploaded_path1);

      if ($result1) {
        $image_path = $uploaded_path;
        // PHPバリデーション
        if (!empty($_POST['title']) && !empty($_POST['body'])) {
          if (mb_strlen ($_POST["title"]) < 21) {
            if (mb_strlen ($_POST["body"]) < 101) {
              // 投稿内容をDBに登録
              $stmt = $db->prepare("INSERT INTO posts SET title = :title, body = :body, name = :name, image = :image, created_at = now()");
              $stmt->bindValue(':title', $_POST["title"], PDO::PARAM_STR);
              $stmt->bindValue(':body', $_POST["body"], PDO::PARAM_STR);
              $stmt->bindValue(':name', $_SESSION['login']['name'], PDO::PARAM_STR);
              $stmt->bindValue(':image', $filename1);
              $stmt->execute();
              header('Location: index.php');
              exit();
            }
          }
        }
      }
    }

    // PHPバリデーション
    if (!empty($_POST['title']) && !empty($_POST['body'])) {
      if (mb_strlen ($_POST["title"]) < 21) {
        if (mb_strlen ($_POST["body"]) < 101) {
          // 投稿内容をDBに登録
          $stmt = $db->prepare("INSERT INTO posts SET title = :title, body = :body, name = :name, created_at = now()");
          $stmt->bindValue(':title', $_POST["title"], PDO::PARAM_STR);
          $stmt->bindValue(':body', $_POST["body"], PDO::PARAM_STR);
          $stmt->bindValue(':name', $_SESSION['login']['name'], PDO::PARAM_STR);
          $stmt->execute();
          header('Location: index.php');
          exit();
        }
      }
    }
  }

  function postIndex() {
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
  }

  function postShow() {
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
  }

  function postEdit() {
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

    // post情報取得
    $stmt = $db->prepare('SELECT * FROM posts WHERE id = :id');
    $stmt->bindValue(':id', $_REQUEST['id'], PDO::PARAM_INT);
    $stmt->execute();
    $postdate = $stmt->fetch();

    // PHPバリデーション
    if (!empty($_POST['title']) && !empty($_POST['body'])) {
      if (mb_strlen ($_POST["title"]) < 21) {
        if (mb_strlen ($_POST["body"]) < 101) {
          echo $_POST["title"];
          echo $_POST["body"];
          // 投稿内容をDBに登録
          $stmt = $db->prepare("UPDATE LP2112003m_yoshida.posts SET title = :title, body = :body, update_at = now() WHERE id = :id");
          $stmt->bindValue(':title', $_POST["title"], PDO::PARAM_STR);
          $stmt->bindValue(':body', $_POST["body"], PDO::PARAM_STR);
          $stmt->bindValue(':id', $postdate["id"], PDO::PARAM_INT);
          $stmt->execute();
          // $url = 'http://localhost/views/posts/edit.php?id=' . $postdate['id'];
          header('Location: index.php');
          exit();
        }
      }
    }
  }

  function postDestroy() {
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

    // posts情報取得
    $stmt = $db->prepare('SELECT name, del_flg FROM posts WHERE id = :id');
    $stmt->bindValue(':id', $_REQUEST['id'], PDO::PARAM_INT);
    $stmt->execute();
    $postDate = $stmt->fetch();

    // ログインしているユーザネームとpostsテーブルのnameが同じであれば処理を実行
    if ($_SESSION['login']['name'] === $postDate['name']) {
      $stmt = $db->prepare('UPDATE LP2112003m_yoshida.posts SET del_flg = :del_flg WHERE id = :id');
      $stmt->bindValue(':id', $_REQUEST['id'], PDO::PARAM_INT);
      $stmt->bindValue(':del_flg', 1, PDO::PARAM_INT);
      $stmt->execute();
      header('Location: index.php');
      // echo "削除しました";
    } else {
      header('Location: index.php');
      // echo "削除できませんでした。";
    }
  }
?>