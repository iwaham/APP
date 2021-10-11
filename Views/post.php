<?php
session_start();
require_once(ROOT_PATH .'Models/User.php');

require_once(ROOT_PATH . 'Controllers/PostController.php');
$post = new PostController();
$params = $post->part();

$login_user = $_SESSION['login_user'];

if (!$login_user) {
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/base.css">
  <link rel="stylesheet" href="/css/form.css">
  <title>Eone</title>
</head>

<body>
  <?php include('header.php'); ?>
  <div class="form-wrapper">
    <h1>新規投稿</h1>
    <form method="post" action="postComplete.php">
      <input type="hidden" name="user_id" required="required" class="input" value="<?php echo $login_user['id'] ?>"></input>
      <div class="form-item">
        <label for="start_time">開始時間</label>
        <input type="datetime-local" name="start_time" required="required" class="input" value=""></input>
      </div>
      <div class="form-item">
        <label for="end_time">終了時間</label>
        <input type="datetime-local" name="end_time" required="required" class="input" value=""></input>
      </div>
      <div class="form-item">
        <label for="part_id">実施部位</label>
        <select name="part_id" style="margin-bottom: 30px;">
          <option value="">選択してください</option>
          <?php foreach ($params['part'] as $part) : ?>
            <option value="<?= $part['id']; ?>">
              <?= $part['name']; ?>
            </option>
          <?php endforeach ?>
        </select>
      </div>
      <div class="button-panel">
        <button type="submit" class="button last" value="投稿する" onclick="return confirm('この内容でよろしいですか？')">投稿する</button>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>

</html>