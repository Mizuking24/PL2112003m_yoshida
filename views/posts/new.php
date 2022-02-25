<?php
  require('../../controllers/posts_controller.php');
  postNew();

  echo "ようこそ" . $_SESSION['login']['name'];

  // var_dump($_FILES['image']['name']);
  // var_dump($_POST['title']);
  // var_dump($_POST['body']);
?>

<!DOCTYPE html>
<html lang="jp">
  <head>
    <meta charset="UTF-8">
    <title>新規投稿画面</title>
  </head>
  <body>
    <header>
      <h1>SNSサンプル</h1>
      <ul>
        <li><a href="index.php">投稿一覧</a></li>
        <li><a href="new.php">新規投稿</a></li>
      </ul>
      <hr size='2' color="#a9a9a9" align="center">
    </header>
    <main>
      <h1>新規投稿画面</h1>
      <hr>
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="form">
          <p>image :</p>
          <input id="formImage" multiple type="file" name="image[]">
          <!-- <input id="formImage" type="file" name="image[]"> -->
        </div>
        <div class="form">
          <p>Title :</p>
          <input id="formTitle" type="text" name="title">
          <p id="titleError"></p>
        </div>
        <div class="form">
          <p>Body :</p>
          <textarea id="formBody" type="text" name="body"></textarea>
          <p id="bodyError"></p>
        </div>
        <input id="subId" type="submit" value="投稿" onclick="sub()">
      </form>
    </main>
    <footer></footer>
    <script type="text/javascript" src="newPost.js"></script>
  </body>
</html>