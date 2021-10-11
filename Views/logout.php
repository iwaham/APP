<?php
session_start();
require_once(ROOT_PATH . 'Models/User.php');

User::logout();

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
    <img src="/img/logo.png" width="300" height="150" alt="ロゴ" style="margin-top: 80px;">
  </div>
  <section>
    <div class="completeBox">
      <div class="completeMsg">
        <p>ご利用ありがとうございます。<br>ログアウトしました。</p>
        <a href="login.php">ログインする</a>
      </div>
    </div>
  </section>
</body>
</html>