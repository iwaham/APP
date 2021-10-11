<?php
    session_start();
    
    //CSRF トークン
    function get_csrf_token() {
        $token_legth = 16;//16*2=32byte
        $bytes = openssl_random_pseudo_bytes($token_legth);
        return bin2hex($bytes);
       }
    $_SESSION['token']  = get_csrf_token();
?>

<!doctype html>
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
        <form action="pwd_reset_mail.php" method="POST">
            <img class="mb-4" src="/../img/logo.png" alt="" width="300" height="150">
            <h1 class="h3 mb-5 fw-normal">パスワード再設定</h1>

            <?php
            if(!empty($_SESSION['error_status'])) {
                if ($_SESSION['error_status'] == 1) {
                    echo "<p style='color:red;'>パスワードをリセットしてください。</p>";
                }
                if ($_SESSION['error_status'] == 2) {
                    echo "<p style='color:red;'>入力内容に誤りがあります。</p>";
                }
                if ($_SESSION['error_status'] == 3) {
                    echo "<p style='color:red;'>不正なリクエストです。</p>";
                }
                if ($_SESSION['error_status'] == 4) {
                    echo '<p style="color:red;">タイムアウトか不正なURLです。</p>';
                }
                //エラー情報のリセット
                $_SESSION['error_status'] = 0;
            }
            ?>

            <p>登録されたメールアドレスを入力し、「送信」ボタンを押してください。<br>
            パスワード再設定用のURLを登録メールアドレスに送信します。</p>

            <div class="row g-3 align-items-center mt-4 mb-5">
                <div class="col-auto">
                    <label for="email" class="col-form-label">ご登録のメールアドレス</label>
                </div>
                <div class="col-md">
                    <input type="text" name="email" id="email" class="form-control" aria-describedby="emailHelpInline">
                </div>

            </div>

            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token']  , ENT_QUOTES, "UTF-8") ?>">
         
            <button class="btn btn-lg btn-secondary outline pw" type="submit">送 信</button>
            <button class="btn btn-lg btn-secondary outline ms-4 pw"><a href="login.php">戻 る</a></button>

        </form>
    </main>
    
</body>
</html>
