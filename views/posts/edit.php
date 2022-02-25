<?php
  require('../../controllers/posts_controller.php');
  postEdit();

  echo "ようこそ" . $_SESSION['login']['name'];

  // post情報取得
  $stmt = $db->prepare('SELECT * FROM posts WHERE id = :id');
  $stmt->bindValue(':id', $_REQUEST['id'], PDO::PARAM_INT);
  $stmt->execute();
  $postdate = $stmt->fetch();

  // global $postdate;
?>

<!DOCTYPE html>
<html lang="jp">
  <head>
    <meta charset="UTF-8">
    <title>投稿編集画面</title>
  </head>
  <body>
    <header>
      <h1>SNSサンプル</h1>
      <ul>
        <li><a href="index.php">投稿一覧</a></li>
        <li><a href="new.php">新規投稿</a></li>
      </ul>
      <hr size='2' color="#a9a9a9" width="1500px" align="center">
    </header>
    <main>
      <h1>投稿編集画面</h1>
      <hr>
      <form action="" method="POST">
        <div class="form">
          <p>Title :</p>
          <input id="formTitle" type="text" name="title" value=<?php echo $postdate['title']; ?>>
          <p id="titleError"></p>
        </div>
        <div class="form">
          <p>Body :</p>
          <textarea id="formBody" type="text" name="body"><?php echo $postdate['body']; ?></textarea>
          <p id="bodyError"></p>
        </div>
        <input id="subId" type="submit" value="編集する" onclick="sub()">
      </form>
    </main>
    <footer></footer>
    <script type="text/javascript" src="newPost.js"></script>
  </body>
</html>