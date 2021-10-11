<?php
session_start();

require_once(ROOT_PATH . 'Models/User.php');
$result = User::checkLogin();

$login_user = $_SESSION['login_user'];


if (!$login_user) {
  header('Location:login.php');
  exit();
 }

require_once(ROOT_PATH .'Controllers/PostController.php');
$post = new PostController();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/base.css">
  <link rel="stylesheet" href="/css/form.css">
  <title>Eone</title>
</head>

<body>
  <?php include('header.php'); ?>
  <div class="form-wrapper">
    <h1 style="padding:30px 0;">プロフィール編集</h1>
    <form method="post" action="userUpdate.php">
      <?php foreach ($params['user'] as $user) : ?>
      <div class="form-item">
        <label for="nickname">ニックネーム<span class="required">*</span></label>
        <input type="text" name="nickname" required="required" class="input" value="<?php echo $user['nickname']; ?>"></input>
      </div>
      <div class="form-item">
        <label for="email">Eメール<span class="required">*</span></label>
        <input type="email" name="email" required="required" class="input" value="<?php echo $user['email']; ?>"></input>
      </div>
      <div class="form-item">
        <label for="email">パスワード<span class="required">*</span></label>
        <input type="password" name="password" required="required" class="input" value="<?php $user['password']; ?>"></input>
      </div>
      <?php endforeach; ?>
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
        <span class="span">得意な部位</span>
        <select name="得意な部位" style="margin-bottom: 30px;">
          <option value="">選択してください</option>
          <option value="胸">胸</option>
          <option value="背中">背中</option>
          <option value="肩">肩</option>
          <option value="腕">腕</option>
          <option value="お腹">お腹</option>
          <option value="お尻">お尻</option>
          <option value="脚">脚</option>
        </select>
      </div> -->
      <div class="button-panel">
        <a href="#" onclick="return confirm('この内容でよろしいですか？')"><input type="button" class="button last" title="Sign Up" value="更新する"></input></a>
      </div>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>

</html>