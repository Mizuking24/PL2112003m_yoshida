<?php
  require("../../../controllers/users_controller.php");
  sessionControl();
?>

<!DOCTYPE html>
<html lang="jp">
  <head>
    <meta charset="UTF-8">
    <title>ログイン</title>
  </head>
  <body>
    <header></header>
    <main>
      <h1>ログイン</h1>
      <hr>
      <form action="" method="POST">
        <div class="form">
          <p>UserName :</p>
          <input id="formName" type="text" name="userName">
          <p id="nameError"></p>
        </div>
        <div class="form">
          <p>password :</p>
          <input id="formPass" type="text" name="password">
          <p id="passError"></p>
        </div>
        <input id="subId" type="submit" value="ログイン" onclick="sub()">
      </form>
    </main>
    <footer></footer>
    <script type="text/javascript" src="session.js"></script>
  </body>
</html>