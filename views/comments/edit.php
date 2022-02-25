<?php
  require('../../controllers/comments_controller.php');
  commentEdit();

  echo "ようこそ" . $_SESSION['login']['name'];

  // comments情報取得
  $stmt = $db->prepare('SELECT * FROM comments WHERE id = :id');
  $stmt->bindValue(':id', $_REQUEST['id'], PDO::PARAM_INT);
  $stmt->execute();
  $commentDate = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="jp">
  <head>
    <meta charset="UTF-8">
    <title>コメント編集画面</title>
  </head>
  <body>
    <header>
      <h1>SNSサンプル</h1>
      <ul>
        <li><a href="http://localhost/views/posts/index.php">投稿一覧</a></li>
        <li><a href="http://localhost/views/posts/new.php">新規投稿</a></li>
      </ul>
      <hr size='2' color="#a9a9a9" width="1500px" align="center">
    </header>
    <main>
      <h1>コメント編集画面</h1>
      <hr>
      <form action="" method="POST">
        <div class="form">
          <p>Comment :</p>
          <input id="formComment" type="text" name="comment" value=<?php echo $commentDate['comment']; ?>>
          <p id="commentError"></p>
        </div>
        <input id="subId" type="submit" value="編集する" >
      </form>
    </main>
    <footer></footer>
    <!-- <script type="text/javascript" src="newPost.js"></script> -->
  </body>
</html>