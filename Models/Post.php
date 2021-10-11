<?php
require_once(ROOT_PATH .'Models/Db.php');

class Post extends Db {
  public function __construct($dbh = null) {
    parent::__construct($dbh);
  }

  // 新規投稿
  public function insert():Array {

    $sql = 'INSERT INTO post(start_time, end_time, part_id, user_id)
            VALUES(:start_time, :end_time, :part_id, :user_id)';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':start_time', $_POST['start_time'], PDO::PARAM_STR);
    $sth->bindParam(':end_time', $_POST['end_time'], PDO::PARAM_STR);
    $sth->bindParam(':part_id', $_POST['part_id'], PDO::PARAM_INT);
    $sth->bindParam(':user_id', $_POST['user_id'], PDO::PARAM_INT);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // 実施部位取得
  public function partAll():Array {
    $sql = 'SELECT * FROM part';
    $sth = $this->dbh->prepare($sql);
    $sth->execute();
    $result = $sth ->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // マイページ一覧表示時投稿取得
  public function findAll($user_id):Array {
    $sql = 'SELECT p.*, p.id, u.nickname FROM post AS p
            INNER JOIN users u ON p.user_id = u.id
            WHERE p.user_id = :user_id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // マイページ予約一覧
  public function findReserve($user_id):Array {
    $sql = 'SELECT r.*, p.*, u.nickname, r.id FROM reserve AS r
            INNER JOIN post p ON r.post_id = p.id
            INNER JOIN users u ON r.user_id = u.id
            WHERE r.user_id = :user_id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // ユーザー名取得
  public function findName():Array {
    $sql = 'SELECT u.nickname FROM users AS u
            INNER JOIN post AS p
            ON u.id = p.user_id';
    $sth = $this->dbh->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // 投稿編集時id取得
  public function findById($id):Array {
    $sql = 'SELECT * FROM post
            WHERE id = :id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // 投稿編集
  public function postUpdate() {
    $sql = 'UPDATE post
            SET id = :id, start_time = :start_time, end_time = :end_time, part_id = :part_id
            WHERE id = :id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $_POST['id'], PDO::PARAM_STR);
    $sth->bindParam(':start_time', $_POST['start_time'],PDO::PARAM_STR);
    $sth->bindParam(':end_time', $_POST['end_time'],PDO::PARAM_STR);
    $sth->bindParam(':part_id', $_POST['part_id'],PDO::PARAM_STR);
    $sth ->execute();
  }

  // 投稿削除
  public function postDelete():Array {
    $sql = 'DELETE FROM post WHERE id = :id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $_GET['id'], PDO::PARAM_STR);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // 予約一覧表示時投稿内容取得
  public function postAll():Array {
    $sql = 'SELECT *, u.nickname, p.part_id, p.id FROM post AS p
            INNER JOIN users u ON p.user_id = u.id';
    $sth = $this->dbh->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // 検索
  public function search($search_name):Array {
    $sql = "SELECT p.*, u.nickname, pa.name
            FROM post AS p
            INNER JOIN users AS u ON p.user_id = u.id
            INNER JOIN part AS pa ON p.part_id = pa.id
            WHERE (u.nickname LIKE '%$search_name%' OR pa.name LIKE '%$search_name%')
            ORDER BY id DESC";
    $sth = $this->dbh->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // 予約詳細表示
  public function findByPostId():Array {
    $sql = 'SELECT *, u.nickname, p.part_id, p.id FROM post AS p
            INNER JOIN users u ON p.user_id = u.id
            WHERE p.id = :id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // 予約情報挿入
  public function reserve($post_id, $user_id) {
    $sql = 'INSERT INTO reserve(post_id, user_id)
            VALUES(:post_id, :user_id)';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':post_id', $post_id, PDO::PARAM_STR);
    $sth->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $sth->execute();
  }

  // reserve_flg更新
  public function flgUpdate($post_id) {
    $sql = 'UPDATE post
            SET reserve_flg = 1
            WHERE id = :id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $post_id, PDO::PARAM_INT);
    $sth->execute();
  }

  // 予約キャンセル
  public function cancel() {
    $sql = 'UPDATE post
            SET reserve_flg = 0
            WHERE id = :id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $_GET['pid'], PDO::PARAM_INT);
    $sth->execute();
  }
  // 予約キャンセル
  public function reserveDelete():Array {
    $sql = 'DELETE FROM reserve WHERE id = :id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $_GET['id'], PDO::PARAM_STR);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  // いいね
  public function like() {
    $sql = 'UPDATE reserve
            SET like_flg = 0
            WHERE id = :id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $sth->execute();
  }

  // public function findByUserId($id):Array {
  //   $sql = 'SELECT * FROM users
  //           WHERE id = :id';
  //   $sth = $this->dbh->prepare($sql);
  //   $sth->bindParam(':id', $id, PDO::PARAM_INT);
  //   $sth->execute();
  //   $result = $sth->fetchAll(PDO::FETCH_ASSOC);
  //   return $result;
  // }

}