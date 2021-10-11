<?php
  session_start();

  require_once(ROOT_PATH .'database.php');
  require_once(ROOT_PATH .'Models/Db.php');
  $email = $_SESSION['email'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];
  $token = $_POST['token'];
  //CSRF エラー
  if ($token != $_SESSION['token']) {
     $_SESSION['error_status'] = 2;
     header('Location: login.php');
     exit();
  }
  //パスワード不一致
  if ($password != $confirm_password) {
    $_SESSION['error_status'] = 1;
    header('Location: pwd_reset_url.php?' . $_SESSION['url_pass']);
    exit();
  }
  //パスワード更新
  try {
    // DB接続
    $dbh = new PDO(
        'mysql:dbname='.DB_NAME.
        ';host='.DB_HOST, DB_USER, DB_PASSWD
    );
    $sql = "SELECT * FROM users WHERE email = ? AND reset = 1;";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $email, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (empty($row)) {
      $_SESSION['error_status'] = 3;
      header('Location: pwd_reset.php');
      exit();
    }
    $mail = $row['email'];
    //プレースホルダで SQL 作成
    $sql = "UPDATE users SET reset = 0, is_user = 1, password = ?, last_change_pass_time = ? WHERE email = ?;";
    $stmt = $dbh->prepare($sql);
    // パスワードハッシュ化
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // トランザクションの開始
    $dbh->beginTransaction();
    try {
      $stmt->bindValue(1, $hashed_password, PDO::PARAM_STR);
      $stmt->bindValue(2, date('Y-m-d H:i:s'), PDO::PARAM_STR);
      $stmt->bindValue(3, $email, PDO::PARAM_STR);
      $stmt->execute();
      // コミット
      $dbh->commit();
    } catch (PDOException $e) {
      // ロールバック
      $dbh->rollBack();
      throw $e;
    }
  } catch (PDOException $e) {
    die($e->getMessage());
  }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.79.0">
    <title>Eone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/base.css">
    <link rel="stylesheet" href="/css/top.css">
</head>
<body class="text-center">
    
    <main class="form-signup d-flex justify-content-center">

        <form action="" method="POST">
            <img class="mb-4" src="/../img/logo.png" alt="" width="300" height="150">
            <h1 class="h3 mb-3 fw-normal">パスワードの再設定が完了しました。</h1>
            <p>ログインページからログインしてください。</p>

            <button class="col-auto btn btn-lg btn-secondary outline pw"><a href="login.php">ログイン</a></button>

        </form>

    </main>

</body>
</html>