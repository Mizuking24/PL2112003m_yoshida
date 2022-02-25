<?php
  function db_connection() {
    global $db, $e;
    try {
      $db = new PDO(
        'mysql:dbname=LP2112003m_yoshida;host=localhost;charset=utf8mb4',
        'root',
        'root',
        [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          ]
        );
        // usersテーブル作成
        // $sql = <<<EOM
        //   CREATE TABLE LP2112003m_yoshida.users (
        //     id CHAR(10) NOT NULL PRIMARY KEY,
        //     name VARCHAR(255) NOT NULL,
        //     email VARCHAR(255) NOT NULL,
        //     password VARCHAR(255) NOT NULL,
        //     created_at TIMESTAMP NULL,
        //     update_at TIMESTAMP NULL
        //   );
        //   EOM;
        //   $stmt = $db->prepare($sql);
        //   $stmt->execute();

        // postsテーブル作成
        // $sql = <<<EOM
        //   CREATE TABLE LP2112003m_yoshida.posts (
        //     id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        //     title VARCHAR(255) NOT NULL,
        //     body VARCHAR(255) NOT NULL,
        //     name VARCHAR(255) NOT NULL,
        //     del_flag BOOL
        //     created_at TIMESTAMP NULL,
        //     update_at TIMESTAMP NULL
        //   );
        //   EOM;
        //   $stmt = $db->prepare($sql);
        //   $stmt->execute();

        // postsテーブルにdel_flgカラムを追加
        // $s = $db->prepare('ALTER TABLE posts ADD del_flg BIT NULL');
        // $s->execute();

        // postsテーブルにimageカラムを追加
        // $s = $db->prepare('ALTER TABLE posts ADD image2 BLOB NULL');
        // $s->execute();

        // commentsテーブル作成
        // $sql = <<<EOM
        //   CREATE TABLE LP2112003m_yoshida.comments (
        //     id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        //     name VARCHAR(255) NOT NULL,
        //     comment VARCHAR(255) NOT NULL,
        //     postcode INT NOT NULL,
        //     created_at TIMESTAMP NULL,
        //     update_at TIMESTAMP NULL
        //   );
        //  EOM;
        //  $stmt = $db->prepare($sql);
        //  $stmt->execute();

        // commentsテーブルにdel_flgカラムを追加
        // $s = $db->prepare('ALTER TABLE comments ADD del_flg BIT NULL');
        // $s->execute();

        // repliesテーブル作成
        // $sql = <<<EOM
        //   CREATE TABLE LP2112003m_yoshida.replies (
        //     id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        //     name VARCHAR(255) NOT NULL,
        //     reply VARCHAR(255) NOT NULL,
        //     commentcode INT NOT NULL,
        //     created_at TIMESTAMP NULL,
        //     update_at TIMESTAMP NULL,
        //     del_flg BIT NULL
        //   );
        //  EOM;
        //  $stmt = $db->prepare($sql);
        //  $stmt->execute();

        // likesテーブル作成
        // $sql = <<<EOM
        //   CREATE TABLE LP2112003m_yoshida.likes (
        //     id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        //     favo BIT(1) NOT NULL DEFAULT b'0'
        //     name VARCHAR(255) NOT NULL,
        //     postcode INT NOT NULL,
        //     created_at TIMESTAMP NULL,
        //     update_at TIMESTAMP NULL
        //   );
        //  EOM;
        //  $stmt = $db->prepare($sql);
        //  $stmt->execute();

    } catch (PDOException $e) {
        //エラー発生時
        echo $e->getMessage();
        exit;
    }
  }
?>