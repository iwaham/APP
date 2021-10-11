<?php
require_once(ROOT_PATH . '/database.php');
require_once(ROOT_PATH . '/Models/Db.php');

class User extends Db
{

  public function __construct($dbh = null)
  {
    parent::__construct($dbh);
  }

  public static function createUser($userData)
  {
    $result = false;

    $dbh = new PDO(
      'mysql:dbname=' . DB_NAME .
        ';host=' . DB_HOST,
      DB_USER,
      DB_PASSWD
    );

    $sql = 'INSERT INTO users (email, password, nickname, part_id) VALUES (:email, :password, :nickname, :part_id)';
    $sth = $dbh->prepare($sql);

    $pass_hash = password_hash($userData['password'], PASSWORD_DEFAULT);

    $sth->bindParam(':email', $userData['email'], PDO::PARAM_STR);
    $sth->bindParam(':password', $pass_hash, PDO::PARAM_STR);
    $sth->bindParam(':nickname', $userData['nickname'], PDO::PARAM_STR);
    $sth->bindParam(':part_id', $userData['part_id'], PDO::PARAM_INT);

    $result = $sth->execute();
    return $result;
  }

  public static function login($email, $password)
  {
    $result = false;
    $user = self::getUserByEmail($email);
    if (!$user) {
      $_SESSION['msg'] = 'メールアドレスが一致しません。';
      return $result;
    }

    if (password_verify($password, $user['password'])) {
      session_regenerate_id(true);
      $_SESSION['login_user'] = $user;
      $result = true;
      return $result;
    } else {
      $_SESSION['msg'] = 'パスワードが一致しません。';
      return $result;
    }
  }

  public static function getUserByEmail($email)
  {
    $dbh = new PDO(
      'mysql:dbname=' . DB_NAME .
        ';host=' . DB_HOST,
      DB_USER,
      DB_PASSWD
    );

    $sql = 'SELECT * FROM users WHERE email = :email';
    $sth = $dbh->prepare($sql);
    $sth->bindParam(':email', $email, PDO::PARAM_STR);

    try {
      $sth->execute();
      $user = $sth->fetch();
      return $user;
    } catch (\Exception $e) {
      return false;
    }
  }

  public static function checkLogin()
  {
    $result = false;

    if (isset($_SESSION['login_user']) && $_SESSION['login_user']['id'] > 0) {
      return $result = true;
    }
    return $result;
  }

  public static function logout()
  {
    $_SESSION = array();
    session_destroy();
  }
}
