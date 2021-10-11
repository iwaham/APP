<?php
session_start();
require_once(ROOT_PATH .'Models/User.php');

require_once(ROOT_PATH . 'Controllers/PostController.php');
$post = new PostController();

$login_user = $_SESSION['login_user'];
$params = $post->cancel();

if (!$login_user) {
  header('Location:login.php');
  exit();
 }
 var_dump($_GET['id']);
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
        <p>キャンセルが完了しました。<br>またのご利用をお待ちしております。</p>
        <a href="mypage.php?id=<?= $login_user['id'] ?>">マイページへ</a>
      </div>
    </div>
  </section>
</body>
</html>