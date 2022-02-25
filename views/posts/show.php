<?php
  require('../../controllers/posts_controller.php');
  postShow();
  require('../../controllers/comments_controller.php');
  commentNew();

  echo "ようこそ" . $_SESSION['login']["name"];

  $_SESSION['id'] = $_REQUEST['id'];

  // post情報取得
  $stmt = $db->prepare('SELECT * FROM posts WHERE id = :id');
  $stmt->bindValue(':id', $_REQUEST['id'], PDO::PARAM_INT);
  $stmt->execute();
  $postdate = $stmt->fetch();

  // post情報を取得できていなければ投稿一覧画面へ遷移させる。
  if (!isset($postdate['title']) || $postdate['del_flg'] === true) {
    header('Location: index.php');
    exit();
  }

  // comment情報取得
  $stm = $db->prepare('SELECT * FROM comments WHERE postcode = :postcode');
  $stm->bindValue(':postcode', $_REQUEST['id'], PDO::PARAM_INT);
  $stm->execute();

  // urlのidに紐付いたpostのlike情報取得
  $st = $db->prepare('SELECT * FROM likes WHERE postcode = :postcode');
  $st->bindValue(':postcode', $_REQUEST['id'], PDO::PARAM_INT);
  $st->execute();

  // 繰り返し処理でひとつずつ取得
  while($likeDate = $st->fetch()) {
    // ログインしているユーザーが取得したlike情報に存在知る場合処理を実行
    // 配列arrayに名前を一つずつ格納
    if ($_SESSION['login']['name'] === $likeDate['name']) {
      $like = $likeDate;
    }
    $array[] = $likeDate['name'];
  }
  
  // ログインしているユーザーが取得したlike情報に存在するか
  $set = 0;
  if (!empty($array)) {
    if(in_array($_SESSION['login']['name'], $array)) {
      // echo "存在します";
    } else {
      // echo "存在しません";
      $set = 1;
    }
  }
?>

<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="UTF-8">
  <title>投稿詳細画面</title>
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
  <h1 align="center">投稿詳細画面</h1>

  <!-- 画像 -->
  <?php if (isset($postdate['image'])): ?>
    <div align="center">
      <img src='/images/<?php echo $postdate['image']; ?>'>
    </div>
  <?php endif; ?>
  <?php if (isset($postdate['image2'])): ?>
    <div align="center">
      <img src='/images/<?php echo $postdate['image2']; ?>'>
    </div>
  <?php endif; ?>
  <!-- /画像 -->

  <!-- 投稿情報 -->
  <h3 align="center">「<?php echo $postdate['title'] ?>」</h3>
  <p align="center"><?php echo $postdate['body'] ?></p>
  <p align="center"><?php echo $postdate['created_at'] ?></p>
  <p align="center">投稿者：<?php echo $postdate['name'] ?></p>
  <!-- /投稿情報 -->

  <!-- いいね -->
  <!-- </?php $createLike = 'http://localhost/views/posts/like_create.php?id=' . $postdate['id'];?>
  </?php $destroyLike = 'http://localhost/views/posts/like_destroy.php?id=' . $postdate['id'];?> -->
  <?php if ($postdate['name'] != $_SESSION['login']["name"]): ?>
    <?php if(empty($array) || $set === 1):?>
      <div align="center">
        <button  class="like">♡</button>
      </div>
    <?php endif; ?>
    <?php if(!empty($array) && $set === 0): ?>
      <?php if ($like['favo'] === "0"): ?>
        <div align="center">
          <button class="like">♡</button>
        </div>
      <?php endif; ?>
      <?php if ($like['favo'] === "1"): ?>
        <div align="center">
          <button class="unlike">❤️</button>
        </div>
      <?php endif; ?>
    <?php endif; ?>
  <?php endif; ?>
  <!-- /いいね -->

  <!-- <button class="aaa">aaa</button> -->

  <a href="index.php">投稿一覧画面へ戻る</a>

  <!-- 編集・削除ボタン -->
  <?php if ($_SESSION['login']['name'] === $postdate['name']):?>
    <?php $editUrl = 'http://localhost/views/posts/edit.php?id=' . $postdate['id'];?>
    <?php $destroyUrl = 'http://localhost/views/posts/destroy.php?id=' . $postdate['id'];?>
    <div align="center">
      <a href=<?php echo $editUrl;?>>編集</a>
      <a href=<?php echo $destroyUrl;?>>削除</a>
    </div>
  <?php endif; ?>
  <!-- /編集・削除ボタン -->

  <hr size='3' color="#a9a9a9" width="450" align="center">

  <!-- コメント -->
  <h2 align="center">コメント一覧</h2>
  <?php while($commentDate = $stm->fetch()): ?>
    <?php if ($commentDate['del_flg'] === NULL || $commentDate['del_flg'] === 0): ?>
      <?php
        // replyカウント情報取得
        $stmt = $db->prepare('SELECT count(id) FROM replies WHERE commentcode = :commentcode');
        $stmt->bindValue(':commentcode', $commentDate['id'], PDO::PARAM_INT);
        $stmt->execute();
        $replyCount = $stmt->fetch();
      ?>
      <p align="center"><?php print($commentDate['comment']); ?></p>
      <div align="center">
        <p>投稿者：<?php print($commentDate['name']); ?></p>
        <p><?php echo $replyCount["count(id)"]; ?>件の返信</p>
        <span><?php print($commentDate['created_at']); ?></span>
        <?php $replyUrl = 'http://localhost/views/replies/index.php?id=' . $commentDate['id'];?>
        <a href=<?php echo $replyUrl; ?>>返信する</a>
      </div>
      <?php if ($commentDate['name'] === $_SESSION['login']['name']): ?>
        <?php $commentEditUrl = 'http://localhost/views/comments/edit.php?id=' . $commentDate['id'];?>
        <?php $commentDestroyUrl = 'http://localhost/views/comments/destroy.php?id=' . $commentDate['id'];?>
        <div align="center">
          <a href=<?php echo $commentEditUrl;?>>編集</a>
          <a href=<?php echo $commentDestroyUrl;?>>削除</a>
        </div>
      <?php endif; ?>
      <hr size='1' color="#a9a9a9" width="450" align="center">
    <?php endif; ?>
  <?php endwhile; ?>
  <!-- /コメント -->

  <!-- コメントフォーム -->
  <div align="center">
    <form action="" method="POST">
      <p>コメント</p>
      <input id="formComment" type="text" name="comment">
      <input type="submit" value="コメントする">
      <p id="commentErr"></p>
    </form>
  </div>
  <!-- /コメントフォーム -->

  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script>
    $('button').click(function() {
      if ($('button').hasClass('like')) {
        $.ajax({
          url: 'like_create.php'
        })
        $('.like').text("❤️");
        $('button').toggleClass("like");
        $('button').toggleClass("unlike");
      } else if ($('button').hasClass('unlike')) {
        $.ajax({
          url: 'like_destroy.php'
        })
        $('.unlike').text("♡");
        $('button').toggleClass("like");
        $('button').toggleClass("unlike");
        }
    })
  </script>
</body>
</html>