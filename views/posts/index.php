<?php
  require('../../controllers/posts_controller.php');
  postIndex();

  // post情報取得
  $stmt = $db->prepare('SELECT id, title, name, created_at, del_flg FROM posts ORDER BY created_at DESC');
  $stmt->execute();

  $stm = $db->prepare("SELECT count(id) FROM posts WHERE DATE_FORMAT(created_at, '%Y-%m') = DATE_FORMAT(now(), '%Y-%m')");
  $stm->execute();
  $postCount = $stm->fetch();

  $st = $db->prepare("SELECT count(id) FROM users WHERE DATE_FORMAT(created_at, '%Y-%m') = DATE_FORMAT(now(), '%Y-%m')");
  $st->execute();
  $userCount = $st->fetch();


  echo "ようこそ" . $_SESSION['login']["name"];
?>

<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="UTF-8">
  <title>投稿一覧画面</title>
</head>
<header>
  <h1>SNSサンプル</h1>
  <ul>
    <li><a href="index.php">投稿一覧</a></li>
    <li><a href="new.php">新規投稿</a></li>
  </ul>
  <hr size='2' color="#a9a9a9" width="1500px" align="center">
</header>
<body>
  <h1 align="center">投稿一覧画面</h1>

  <?php while($postDate = $stmt->fetch()): ?>
    <?php if($postDate['del_flg'] === NULL || $postDate['del_flg'] === false): ?>
      <?php $url = 'http://localhost/views/posts/show.php?id=' . $postDate['id'];?>
      <div align="center">
        <a href=<?php echo $url;?>><?php print($postDate['title']); ?></a>
      </div>
      <p align="center">投稿者：<?php print($postDate['name']); ?></p>
      <p align="center"><?php print($postDate['created_at']); ?></p>
      <hr size='3' color="#a9a9a9" width="450" align="center">
    <?php endif ?>
  <?php endwhile; ?>

  <p>累計登録者数<?php echo $userCount["count(id)"]; ?>人/月</p>
  <p>累計投稿数<?php echo $postCount["count(id)"]; ?>件/月</p>

</body>
</html>