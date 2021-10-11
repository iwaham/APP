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
$params = $post->show();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/base.css">
  <link rel="stylesheet" href="/css/mypage.css">
  <title>Eone</title>
</head>

<body>
  <?php include('header.php'); ?>
  <div class="mpBox">
    <div class="upper">
      <h1>予約確認</h1>
    </div>
    <div class="mpContents">
      <div class="mpContent">
        <table class="table table-hover">
          <thead class="table-warning">
            <tr>
              <th scope="col">ユーザ名</th>
              <th scope="col">開始時間</th>
              <th scope="col">終了時間</th>
              <th scope="col">実施部位</th>
            </tr>
          </thead>
          <?php foreach ($params['post'] as $post) : ?>
          <tbody>
            <tr>
              <td scope="col"><?= $post['nickname']  ?></td>
              <td scope="col"><?= $post['start_time'] ?></td>
              <td scope="col"><?= $post['end_time'] ?></td>
              <td scope="col"><?php if ($post['part_id'] == 1) { echo '胸';} elseif ($post['part_id'] == 2) { echo '背中';} elseif ($post['part_id'] == 3) { echo '肩';} elseif ($post['part_id'] == 4) { echo '腕';} elseif ($post['part_id'] == 5) { echo 'お腹';} elseif ($post['part_id'] == 6) { echo 'お尻';} elseif ($post['part_id'] == 7) { echo '脚';}; ?></td>
            </tr>
          </tbody>
        </table>
        <div class="button-panel">
          <form action="reserve.php" method="post">
            <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
            <input type="submit" class="button" title="reserve" value="予約する" onclick="return confirm('この内容で予約しますか？')"></input>
            <?php if($login_user['role'] == 1) : ?>
            <div >
              <a href="postDelete.php?id=<?= $post['id'] ?>" onclick="return confirm('このユーザの投稿を削除しますか？')"><input type="button" class="button last delBtn" title="reserve" value="削除する" ></input></a>
            </div>
            <?php endif ;?>
          </form>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>

</html>