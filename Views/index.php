<?php
session_start();

require_once(ROOT_PATH . 'Models/User.php');
$result = User::checkLogin();

$login_user = $_SESSION['login_user'];


if (!$login_user) {
  header('Location:login.php');
  exit();
}

require_once(ROOT_PATH . 'Controllers/PostController.php');
$post = new PostController();
$params = $post->index($login_user['id']);
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
      <h1>投稿一覧</h1>
    </div>
    <form action="search.php" method="post">
      <div class="input-group mb-3 serch">
        <input type="text" class="form-control" placeholder="ユーザ名もしくは実施部位を入力" aria-label="Recipient's username" aria-describedby="button-addon2" name="search_name">
        <button class="btn btn-outline-secondary" type="submit" id="button-addon2" name="submit">検索</button>
      </div>
    </form>
    <div class="mpContents">
      <div class="mpContent">
        <table class="table table-hover">
          <thead class="table-warning">
            <tr>
              <th scope="col">ユーザ名</th>
              <th scope="col">開始時間</th>
              <th scope="col">終了時間</th>
              <th scope="col">実施部位</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <?php foreach ($params['posts'] as $post) : ?>
            <tbody>
              <tr>
                <td><?= $post['nickname']  ?></td>
                <td><?= $post['start_time'] ?></td>
                <td><?= $post['end_time'] ?></td>
                <td><?php if ($post['part_id'] == 1) {
                      echo '胸';
                    } elseif ($post['part_id'] == 2) {
                      echo '背中';
                    } elseif ($post['part_id'] == 3) {
                      echo '肩';
                    } elseif ($post['part_id'] == 4) {
                      echo '腕';
                    } elseif ($post['part_id'] == 5) {
                      echo 'お腹';
                    } elseif ($post['part_id'] == 6) {
                      echo 'お尻';
                    } elseif ($post['part_id'] == 7) {
                      echo '脚';
                    }; ?></td>
                <td>
                  <?php if ($login_user['id'] == $post['user_id']) : ?>
                  <?php else : ?>
                    <?php if ($post['reserve_flg'] == 0) : ?>
                      <a href="show.php?id=<?= $post['id'] ?>">予約する</a>
                    <?php else : ?>
                      予約済
                    <?php endif; ?>
                  <?php endif; ?>
                </td>
              </tr>
            </tbody>
          <?php endforeach; ?>
        </table>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>

</html>