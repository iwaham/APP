<?php

  session_start();
  require_once(ROOT_PATH .'database.php');
  require_once(ROOT_PATH .'Models/Db.php');

  $email = $_POST['email'];
  $token = $_POST['token'];
  // CSRFチェック
  if ($_SESSION['token'] != $token) {
    $_SESSION['error_status'] = 3;
    header('Location: pwd_reset.php');
    exit();
  }
  try {
    // DB接続
    $dbh = new PDO(
        'mysql:dbname='.DB_NAME.
        ';host='.DB_HOST, DB_USER, DB_PASSWD
    );
    //プレースホルダで SQL 作成
    $sql = "SELECT * FROM users WHERE email = ?;";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $email, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // IDが存在しない
    if (empty($row)) {
      $_SESSION['error_status'] = 2;
      header('Location: pwd_reset.php');
      exit();
    }
    //リセット処理  
    $mail = $row['email'];
    //URLパスワードを作成
    function get_url_password() {
      $token_legth = 16;//16*2=32byte
      $bytes = openssl_random_pseudo_bytes($token_legth);
      return hash('sha256', $bytes);
    }
    $url_pass = get_url_password();
    //プレースホルダで SQL 作成
    $sql = "UPDATE users SET reset = 1, temp_pass = ?, temp_limit_time = ? WHERE email = ?;";
    $stmt = $dbh->prepare($sql);
    // トランザクションの開始
    $dbh->beginTransaction();
    try {
      $stmt->bindValue(1, $url_pass, PDO::PARAM_STR);
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
  //メール送信
  //メールヘッダーインジェクション対策
  $mail = str_replace(array('\r\n','\r','\n'), '', $mail);
  $msg = '以下のアドレスからパスワードのリセットを行ってください。' . PHP_EOL;
  $msg .=  'アドレスの有効時間は１０分間です。' . PHP_EOL . PHP_EOL;
  $msg .= 'http://localhost/pwd_reset_url.php?' . $url_pass;
  mb_send_mail($mail, 'パスワードの再設定', $msg, ' From : ');
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
            <h1 class="h3 mb-3 fw-normal">メールを送信しました</h1>
            <p>受信されたメールの案内にしたがってパスワードの再設定をお願いします。</p>

            <button class="col-auto btn btn-lg btn-secondary outline mt-3 pw"><a href="login.php">ログイン画面へ</a></button>

        </form>

    </main>

</body>
</html>