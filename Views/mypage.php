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
$params = $post->mypage($login_user['id']);
if (isset($_POST['reserve_id'])) {
  $reserve = $_POST['reserve_id'];
}
$today = date('Y-m-d H:i:s');
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
  <script src="https://kit.fontawesome.com/cf920a310b.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <!-- <script>
        var login_user = <?php echo $login_user['id']; ?>;
        var reserve_id = 14;

        $(document).on('click','.like_btn',function(e){
            e.stopPropagation();
            var $this = $(this),
                user_id = login_user;
                reserve_id = reserve_id;
            $.ajax({
                type: 'POST',
                url: 'ajax_like_process.php',
                dataType: 'text',
                data: { user_id: user_id,
                        reserve_id: reserve_id}
            }).done(function(data){
                //location.reload();
                console.log('成功');
            }).fail(function() {
                //location.reload();
                console.log("XMLHttpRequest : " + XMLHttpRequest.status);
                console.log("textStatus     : " + textStatus);
                console.log("errorThrown    : " + errorThrown.message);
            });
        });
  </script> -->
  <title>Eone</title>
</head>

<body>
  <?php include('header.php'); ?>
  <div class="mpBox">
    <div class="upper">
      <h1>マイページ</h1>
      <!-- <a href="userEdit.php?id=<?= $login_user['id'] ?>">
        <p>プロフィールを編集する</p>
      </a> -->
    </div>
    <div class="mpContents">
      <p>投稿一覧</p>
      <div class="mpContent">
        <table class="table table-hover">
          <thead class="table-dark">
            <tr>
              <th scope="col">開始時間</th>
              <th scope="col">終了時間</th>
              <th scope="col">実施部位</th>
              <th scope="col">予約</th>
              <th scope="col"></th>
              <th scope="col"></th>
            </tr>
          </thead>
            <?php foreach ($params['posts'] as $post) : ?>
            <tbody>
              <tr>
                <td><?= $post['start_time'] ?></td>
                <td><?= $post['end_time'] ?></td>
                <td><?php if ($post['part_id'] == 1) { echo '胸';} elseif ($post['part_id'] == 2) { echo '背中';} elseif ($post['part_id'] == 3) { echo '肩';} elseif ($post['part_id'] == 4) { echo '腕';} elseif ($post['part_id'] == 5) { echo 'お腹';} elseif ($post['part_id'] == 6) { echo 'お尻';} elseif ($post['part_id'] == 7) { echo '脚';}; ?></td>
                <td><?php if ($post['reserve_flg'] == 0) { echo '未予約'; } else { echo '予約';};?></td>
                <td><a class="show" href="postEdit.php?id=<?= $post['id'] ?>">編集</a></td>
                <td><a class="show" href="postDelete.php?id=<?= $post['id'] ?>" onclick="return confirm('本当に削除しますか？')">削除</a></td>
              </tr>
            </tbody>
            <?php endforeach; ?>
        </table>
      </div>
    </div>
    <div class="mpContents">
      <p>予約一覧</p>
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
          <?php foreach ($params['reserves'] as $reserve) : ?>
            <?php if ($reserve['reserve_flg'] == 1 && $today < $reserve['start_time']) : ?>
              <tbody>
                <tr>
                  <td><?= $reserve['nickname'] ?></td>
                  <td><?= $reserve['start_time'] ?></td>
                  <td><?= $reserve['end_time'] ?></td>
                  <td><?php if ($reserve['part_id'] == 1) { echo '胸';} elseif ($reserve['part_id'] == 2) { echo '背中';} elseif ($reserve['part_id'] == 3) { echo '肩';} elseif ($reserve['part_id'] == 4) { echo '腕';} elseif ($reserve['part_id'] == 5) { echo 'お腹';} elseif ($reserve['part_id'] == 6) { echo 'お尻';} elseif ($reserve['part_id'] == 7) { echo '脚';}; ?></td>
                  <td><a class="show" href="cancel.php?id=<?= $reserve['id'] ?>&pid=<?= $reserve['post_id'] ?>" onclick="return confirm('本当にキャンセルしますか？')">キャンセル</a></td>
                </tr>
              </tbody>
            <?php endif ;?>
          <?php endforeach; ?>
        </table>
      </div>
    </div>
    <div class="mpContents">
      <p>終了した予約</p>
      <div class="mpContent">
        <table class="table table-hover">
          <thead class="table-secondary">
            <tr>
              <th scope="col">ユーザ名</th>
              <th scope="col">開始時間</th>
              <th scope="col">終了時間</th>
              <th scope="col">実施部位</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <?php foreach ($params['reserves'] as $reserve) : ?>
            <?php if ($reserve['reserve_flg'] == 1 && $today > $reserve['end_time']) : ?>
              <tbody>
                <tr>
                  <td><?= $reserve['nickname'] ?></td>
                  <td><?= $reserve['start_time'] ?></td>
                  <td><?= $reserve['end_time'] ?></td>
                  <td><?php if ($reserve['part_id'] == 1) { echo '胸';} elseif ($reserve['part_id'] == 2) { echo '背中';} elseif ($reserve['part_id'] == 3) { echo '肩';} elseif ($reserve['part_id'] == 4) { echo '腕';} elseif ($reserve['part_id'] == 5) { echo 'お腹';} elseif ($reserve['part_id'] == 6) { echo 'お尻';} elseif ($reserve['part_id'] == 7) { echo '脚';}; ?></td>
                </tr>
              </tbody>
            <?php endif ;?>
          <?php endforeach; ?>
        </table>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>

</html>