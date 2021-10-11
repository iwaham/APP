<?php
  session_start();
  require_once(ROOT_PATH .'database.php');
  require_once(ROOT_PATH .'Models/Db.php');

  //URLからパラメータ取得
  $url_pass = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
  //CSRF
  function get_csrf_token() {
    $token_legth = 16;//16*2=32byte
    $bytes = openssl_random_pseudo_bytes($token_legth);
    return bin2hex($bytes);
   }
  $_SESSION['token'] = get_csrf_token();
  //ユーザー正式登録
  try {
    // DB接続
    $dbh = new PDO(
        'mysql:dbname='.DB_NAME.
        ';host='.DB_HOST, DB_USER, DB_PASSWD
    );
    //10分前の時刻を取得
    $datetime = new DateTime('- 10 min');
    //プレースホルダで SQL 作成
    $sql = "SELECT * FROM users WHERE temp_pass = ? AND temp_limit_time >= ?;";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $url_pass, PDO::PARAM_STR);
    $stmt->bindValue(2, $datetime->format('Y-m-d H:i:s'), PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //URLが不正か期限切れ
    if (empty($row)) {
      $_SESSION['error_status'] = 4;
      header('Location: pwd_reset.php');
      exit();
    }
    $_SESSION['id'] = $row['id'];
    $_SESSION['email'] = $row['email'];
    $_SESSION['url_pass'] = $url_pass; // エラー制御のため格納
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
    
    <main class="form-pwd d-flex justify-content-center">

        <form action="pwd_reset_comp.php" method="POST">
            <img class="mb-4" src="/../img/logo.png" alt="" width="300" height="150">
            <h1 class="h3 mb-3 fw-normal">パスワード再設定</h1>

            <div class="row g-3 align-items-center mb-4">
                <div class="col-auto">
                    <label for="password" class="col-form-label">新しいパスワード</label>
                </div>
                <div class="col-auto">
                    <input type="password" name="password" id="password" class="form-control" aria-describedby="passwordHelpInline">
                </div>
                <div class="col-auto">
                    <span id="passwordHelpInline" class="form-text">4字以上10字以内</span>
                </div>
            </div>

            <div class="row g-3 align-items-center mb-4">
                <div class="col-auto">
                    <label for="confirm_password" class="col-form-label">パスワード確認　</label>
                </div>
                <div class="col-auto">
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" aria-describedby="passwordHelpInline">
                </div>
                <div class="col-auto">
                    <span id="passwordHelpInline" class="form-text"></span>
                </div>
            </div>

            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token']  , ENT_QUOTES, "UTF-8") ?>">
            <button class="col-auto btn btn-lg btn-secondary outline pw" type="submit">登　録</button>

        </form>

    </main>

</body>
</html>