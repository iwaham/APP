<?php
session_start();
require_once(ROOT_PATH . 'Models/User.php');

$err = [];

if (!$email = filter_input(INPUT_POST, 'email')) {
  $err[] = 'メールアドレスを入力してください。';
}
$password = filter_input(INPUT_POST, 'password');
if (!preg_match("/\A[a-z\d]{4,10}+\z/i", $password)) {
  $err[] = 'パスワードは英数字4文字以上100文字以下にしてください。';
}

if (count($err) === 0) {
  $hasCreated = User::createUser($_POST);

  if (!$hasCreated) {
    $err[] = '登録に失敗しました';
  }
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
        <?php if (count($err) > 0) : ?>
          <?php foreach ($err as $e) : ?>
            <p><?php echo $e ?></p>
          <?php endforeach ?>
        <?php else : ?>
          <p>ご利用ありがとうございます。<br>登録が完了しました。</p>
        <?php endif ?>
        <a href="login.php">ログインする</a>
      </div>
    </div>
  </section>
</body>
</html>