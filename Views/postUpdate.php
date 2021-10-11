<?php
session_start();
require_once(ROOT_PATH .'Models/User.php');

require_once(ROOT_PATH . 'Controllers/PostController.php');
$post = new PostController();
$params = $post->update();

$login_user = $_SESSION['login_user'];

if (empty($_SERVER["HTTP_REFERER"])) {
  header('Location:login.php');
  exit();
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
    <img src="/img/logo.png" width="300" height="150" alt="ロゴ" style="margin-top: 80px;">
  </div>
  <section>
    <div class="completeBox">
      <div class="completeMsg">
        <p>ご利用ありがとうございます。<br>投稿の更新が完了しました。</p>
        <a href="mypage.php?id=<?= $login_user['id'] ?>">マイページへ</a>
      </div>
    </div>
  </section>
</body>
</html>