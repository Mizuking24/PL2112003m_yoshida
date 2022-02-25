<?php
  function registrationControlNew() {
    session_start();

    // 全ての項目に値が入っていれば処理を行う
    if (!empty($_POST['userName']) && !empty($_POST['email']) && !empty($_POST['password'])) {
      if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) && mb_strlen ($_POST["password"]) > 5 && mb_strlen ($_POST["password"]) < 21) {
        $_SESSION['join'] = $_POST;
        header('Location: check.php');
        exit();
      }
    }
  }

  function registrationControlCheck() {
    session_start();

    require("../../../db/dbconnect.php");
    db_connection();

    global $db;
    $stmt = $db->prepare("SELECT * FROM users WHERE name = :name");
    $stmt->bindValue(':name', $_SESSION["join"]["userName"]);
    $stmt->execute();
    $member = $stmt->fetch();

    // new.phpからのアクセス以外はnew.phpへ遷移させる
    if (!isset($_SESSION["join"])) {
      header('Location: new.php');
      exit();
    }

    if (!empty($_POST["check"])) {
      if ($member["name"] === $_SESSION["join"]["userName"]) {
        echo "このuserNameは使用できません。変更してください。";
      } else {
        // パスワードをハッシュ化
        $hash = password_hash($_SESSION["join"]["password"], PASSWORD_BCRYPT);

        // メールアドレスを暗号化
        $password = 'secpass';
        $method = 'aes-256-cbc';
        $ivLength = openssl_cipher_iv_length($method);
        $iv = openssl_random_pseudo_bytes($ivLength);
        $options = 0;
        $encrypted = openssl_encrypt($_SESSION["join"]["email"], $method, $password, $options, $iv);

        // 入力情報をDBに登録
        $id = str_shuffle('ABCDEFGHIJKLNMOPQRSTUVWXYZabcdefghijklnmopqrstuvwxyz0123456789');
        $str = substr(str_shuffle($id), 0, 10);

        $stm = $db->prepare("INSERT INTO users SET id = ?, name = ?, email = ?, password = ?, created_at = now()");
        $stm->execute(array(
          $str,
          $_SESSION['join']['userName'],
          $encrypted,
          $hash
        ));

        // 入力されたアドレスにメール送信
        $decrypted = openssl_decrypt($encrypted, $method, $password, $options, $iv);
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");

        $email = "mizukiti2424@gmail.com";//送信元
        $subject = "本登録のご案内"; // 題名
        $body = "仮登録ありがとうございます。\n下記URLより本登録を行ってください。\nhttp://localhost/views/users/registrations/thank.php"; // 本文
        $to = $decrypted; // 宛先
        $header = "From: $email\nReply-To: $email\n";

        mb_send_mail($to, $subject, $body, $header);

        unset($_SESSION["join"]);
        header('Location: sent.php');
        exit();
      }
    }
  }

  function sessionControl() {
    // DB接続処理
    require("../../../db/dbconnect.php");
    db_connection();
    session_start();

    global $db;

    // PHPバリデーション
    if (!empty($_POST['userName']) && !empty($_POST['password'])) {
      if (mb_strlen ($_POST["password"]) > 5 && mb_strlen ($_POST["password"]) < 21) {
        // ログイン情報認証
        $stmt = $db->prepare("SELECT * FROM users WHERE name = :name");
        $stmt->bindValue(':name', $_POST["userName"], PDO::PARAM_STR);
        $stmt->execute();
        if ($member = $stmt->fetch()) {
          if ($member["name"] === $_POST["userName"]) {
            if (password_verify($_POST["password"], $member['password'])) {
              $_SESSION['login'] = $member;
              header('Location: ../../posts/index.php');
              exit();
            } else {
              echo "userNameまたはpasswordが違います。";
            }
          } else {
            echo "userNameまたはpasswordが違います。";
          }
        } else {
          echo "ユーザーが存在しません。";
        }
      }
    }
  }
?>