<?php
$param = $post->findName();
?>

<header>
    <div class="logo">
        <img src="/img/logo_negate.png" width="180" height="60" alt="ロゴ">
    </div>
    <nav class="pc-nav">
        <ul>
            <li><a href="mypage.php?id=<?= $login_user['id'] ?>"><?php echo $login_user['nickname'] ?>さん</a></li>
            <li><a href="post.php">新規投稿</a></li>
            <li><a href="index.php">予約する</a></li>
            <li><a href="logout.php" onclick="return confirm('ログアウトしますか？')">ログアウト</a></li>
        </ul>
    </nav>
</header>