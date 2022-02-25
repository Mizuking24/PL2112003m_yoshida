<?php
  require("../../../controllers/users_controller.php");
  registrationControlCheck();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>確認画面</title>
</head>
<body>
  <div class="content">
    <form action="" method="POST">
      <input type="hidden" name="check" value="checked">
      <h1>入力情報の確認</h1>
      <p>ご入力情報に変更が必要な場合、下のボタンを押し、変更を行ってください。</p>
      <p>登録情報はあとから変更することもできます。</p>
      <hr>

      <div class="control">
        <p>ニックネーム</p>
        <p>
          <span><?php echo htmlspecialchars($_SESSION['join']['userName'], ENT_QUOTES); ?></span>
        </p>
      </div>

      <div class="control">
        <p>メールアドレス</p>
        <p>
          <span><?php echo htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES); ?></span>
        </p>
      </div>

      <div class="control">
        <p>パスワード</p>
        <p>
          <span><?php echo htmlspecialchars($_SESSION['join']['password'], ENT_QUOTES); ?></span>
        </p>
      </div>

      <br>
      <a href="new.php">変更する</a>
      <button type="submit">登録する</button>
    </form>
  </div>
</body>
</html>