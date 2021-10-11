<?php
session_start();

require_once(ROOT_PATH . 'Controllers/PostController.php');
$post = new PostController();
$params = $post->part();

require_once(ROOT_PATH . 'Models/User.php');
$result = User::checkLogin();
if ($result) {
  header('Location: login.php');
  return;
}

$login_err = isset($_SESSION['login_err']) ? $_SESSION['login_err'] : null;
unset($_SESSION['login_err']);
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
  <div class="topLogo resister">
    <img src="/img/logo.png" width="200" height="100" alt="ロゴ">
  </div>
  <div class="form-wrapper">
    <h1>新規登録</h1>
    <?php if (isset($login_err)) : ?>
      <p><?php echo $login_err; ?></p>
    <?php endif; ?>
    <form action="complete.php" method="POST">
      <div class="form-item">
        <label for="nickname">ニックネーム</label>
        <input type="text" name="nickname" required="required" class="input"></input>
      </div>
      <div class="form-item">
        <label for="email">Eメール</label>
        <input type="email" name="email" required="required" class="input"></input>
      </div>
      <div class="form-item">
        <label for="email">パスワード</label>
        <input type="password" name="password" required="required" class="input"></input>
      </div>
      <!-- <div class="form-item">
        <span class="span">生年月日</span>
        <input type="date" name="password" required="required" class="input"></input>
      </div>
      <div class="form-item">
        <span class="span">性別</span>
        <select name="性別">
        <option value="">選択してください</option>
        <option value="男">男</option>
        <option value="女">女</option>
        <option value="その他">その他</option>
        </select>
      </div>
      <div class="form-item">
        <label for="part_id">得意な部位</label>
        <select name="part_id" style="margin-bottom: 30px;">
          <option value="">選択してください</option>
          <?php foreach ($params['part'] as $part) : ?>
            <option value="<?= $part['id']; ?>">
              <?= $part['name']; ?>
            </option>
          <?php endforeach ?>
        </select>
      </div> -->
      <div class="button-panel">
        <button type="submit" class="button last" onclick="return confirm('この内容でよろしいですか？')">登録する</button>
      </div>
    </form>
  </div>
</body>

</html>