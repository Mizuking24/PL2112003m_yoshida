<?php
  // require('../../controllers/posts_controller.php');
  // postShow();
  // require('../../controllers/comments_controller.php');
  // commentNew();
  require('../../controllers/replies_controller.php');
  replyIndex();

  echo "ようこそ" . $_SESSION['login']["name"];

  // comment情報取得
  $stm = $db->prepare('SELECT * FROM comments WHERE id = :id');
  $stm->bindValue(':id', $_REQUEST['id'], PDO::PARAM_INT);
  $stm->execute();
  $commentDate = $stm->fetch();
  // comment情報を取得できていなければ投稿一覧画面へ遷移させる。
  if (!isset($commentDate['comment']) || $commentDate['del_flg'] === true) {
    header('Location: index.php');
    exit();
  }

  // post情報取得
  $stmt = $db->prepare('SELECT * FROM posts WHERE id = :id');
  $stmt->bindValue(':id', $commentDate['postcode'], PDO::PARAM_INT);
  $stmt->execute();
  $postDate = $stmt->fetch();
  // post情報を取得できていなければ投稿一覧画面へ遷移させる。
  if (!isset($postDate['title']) || $postDate['del_flg'] === true) {
    header('Location: index.php');
    exit();
  }

  // reply情報取得
  $stmt = $db->prepare('SELECT * FROM replies WHERE commentcode = :commentcode');
  $stmt->bindValue(':commentcode', $commentDate['id'], PDO::PARAM_INT);
  $stmt->execute();
?>

<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="UTF-8">
  <title>返信画面</title>
</head>
<header>
  <h1>SNSサンプル</h1>
  <ul>
    <li><a href="http://localhost/views/posts/index.php">投稿一覧</a></li>
    <li><a href="http://localhost/views/posts/new.php">新規投稿</a></li>
  </ul>
  <hr size='2' color="#a9a9a9" width="1500px" align="center">
</header>
<body>
  <h1 align="center">コメント返信画面</h1>
  <h3 align="center">「<?php echo $commentDate['comment'] ?>」</h3>
  <p align="center"><?php echo $commentDate['created_at'] ?></p>
  <p align="center">投稿者：<?php echo $commentDate['name'] ?></p>
  <?php $showUrl = 'http://localhost/views/posts/show.php?id=' . $postDate['id'];?>
  <a href=<?php echo $showUrl; ?>>投稿詳細画面へ戻る</a>
  <hr size='3' color="#a9a9a9" width="450" align="center">

  <h2 align="center">返信一覧</h2>
  <?php while($replyDate = $stmt->fetch()): ?>
    <?php if ($replyDate['del_flg'] === NULL || $replyDate['del_flg'] === 0): ?>
      <p align="center"><?php print($replyDate['reply']); ?></p>
      <div align="center">
        <p>BY：<?php print($replyDate['name']); ?></p>
        <span><?php print($replyDate['created_at']); ?></span>
      </div>
      <?php if ($replyDate['name'] === $_SESSION['login']['name']): ?>
        <?php $replyEditUrl = 'http://localhost/views/replies/edit.php?id=' . $replyDate['id'];?>
        <?php $replyDestroyUrl = 'http://localhost/views/replies/destroy.php?id=' . $replyDate['id'];?>
        <div align="center">
          <a href=<?php echo $replyEditUrl;?>>編集</a>
          <a href=<?php echo $replyDestroyUrl;?>>削除</a>
        </div>
      <?php endif; ?>
      <hr size='1' color="#a9a9a9" width="450" align="center">
    <?php endif; ?>
  <?php endwhile; ?>

  <div align="center">
    <form action="" method="POST">
      <p>返信</p>
      <input id="formReply" type="text" name="reply">
      <input type="submit" value="返信する">
      <p id="replyErr"></p>
    </form>
  </div>

</body>
</html>