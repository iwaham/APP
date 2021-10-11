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
$params = $post->edit($_GET['id']);
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
    <h1>投稿編集</h1>
    <form method="post" action="postUpdate.php">
      <?php foreach ($params['post'] as $post) : ?>
      <input type="hidden" name="id" value="<?php echo $post['id'] ?>">
      <div class="form-item">
        <span class="span">開始時間</span>
        <input type="datetime-local" name="start_time" required="required" class="input" value="<?php echo $post['start_time'] ?>"></input>
      </div>
      <div class="form-item">
        <span class="span">終了時間</span>
        <input type="datetime-local" name="end_time" required="required" class="input" value="<?php echo $post['end_time'] ?>"></input>
      </div>
      <div class="form-item">
        <span class="span">実施する部位</span>
        <select name="part_id" style="margin-bottom: 30px;">
          <option value="">選択してください</option>
          <?php foreach ($params['part'] as $part) : ?>
            <option value="<?= $part['id']; ?>">
              <?= $part['name']; ?>
            </option>
          <?php endforeach ?>
        </select>
      </div>
      <?php endforeach; ?>
      <div class="button-panel">
        <a href="" onclick="return confirm('この内容でよろしいですか？')"><input type="submit" class="button" title="Sign In" value="更新する"></input></a>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>

</html>