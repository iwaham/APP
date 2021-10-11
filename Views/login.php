<!--
管理ユーザ
メールアドレス：host@host.com
パスワード：host

一般ユーザ
メールアドレス：sample@sample.com
パスワード：sample
-->

<?php
session_start();

$err = $_SESSION;
$_SESSION = array();
session_destroy();

require_once(ROOT_PATH . 'Models/User.php');
$result = User::checkLogin();
if ($result) {
  header('Location: login.php');
  return;
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/base.css">
  <link rel="stylesheet" href="/css/top.css">
  <title>Eone</title>
</head>

<body>
  <div class="topLogo">
    <img src="/img/logo.png" width="300" height="150" alt="ロゴ">
  </div>
  <section>
    <div class="completeBox">
      <div class="completeMsg">
      </div>
    </div>
  </section>
  <div class="form-wrapper">
    <?php if (isset($login_err)) : ?>
      <p><?php echo $login_err; ?></p>
    <?php endif; ?>

    <?php if (isset($err['msg'])) : ?>
      <p><?php echo $err['msg']; ?></p>
    <?php endif; ?>
    <form action="loginConf.php" method="POST">
      <div class="form-item">
        <label for="email"></label>
        <input type="email" name="email" required="required" placeholder="Eメール"></input>
        <?php if (isset($err['email'])) : ?>
          <p><span><?php echo $err['email']; ?></span></p>
        <?php endif; ?>
      </div>
      <div class="form-item">
        <label for="password"></label>
        <input type="password" name="password" required="required" placeholder="パスワード"></input>
        <?php if (isset($err['password'])) : ?>
          <p><?php echo $err['password']; ?></p>
        <?php endif; ?>
      </div>
      <div class="button-panel">
        <button type="submit" class="button">ログイン</button>
      </div>
      <div class="button-panel">
        <a href="signup.php"><input type="button" class="button last" value="新規登録"></input></a>
      </div>
    </form>
      <p><a href="pwd_reset.php">パスワードをリセット</a></p>
    </div>
  </div>
</body>

</html>