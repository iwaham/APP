<?php
session_start();
require_once(ROOT_PATH . 'Models/User.php');

$err = [];

if (!$email = filter_input(INPUT_POST, 'email')) {
  $err['email'] = 'メールアドレスを入力してください。';
}
if (!$password = filter_input(INPUT_POST, 'password')) {
  $err['password'] = 'パスワードを入力してください。';
}


if (count($err) > 0) {
  $_SESSION = $err;
  header('Location: login.php');
  return;
}

$result = User::login($email, $password);
if (!$result) {
  header('Location: login.php');
  return;
}

$login_user = $_SESSION['login_user'];
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
        <p>ログイン完了<br>ログインしました。</p>
        <a href="mypage.php?id=<?= $login_user['id'] ?>">マイページへ</a>
      </div>
    </div>
  </section>
</body>
</html>