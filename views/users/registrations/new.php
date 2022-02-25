<?php
  require("../../../controllers/users_controller.php");
  registrationControlNew();
?>

<!DOCTYPE html>
<html lang="jp">
  <head>
    <meta charset="UTF-8">
    <title>新規会員登録</title>
  </head>
  <body>
    <header></header>
    <main>
      <h1>新規会員登録</h1>
      <hr>
      <form action="" method="POST">
        <div class="form">
          <p>UserName :</p>
          <input id="formName" type="text" name="userName">
          <p id="nameError"></p>
        </div>

        <div class="form">
          <p>email :</p>
          <input id="formEmail" type="text" name="email">
          <p id="emailError"></p>
        </div>

        <div class="form">
          <p>password :</p>
          <input id="formPass" type="text" name="password">
          <p id="passError"></p>
        </div>
        <input id="subId" type="submit" value="確認画面へ" onclick="sub()">
      </form>
    </main>
    <footer></footer>
    <script type="text/javascript" src="register.js"></script>
  </body>
</html>