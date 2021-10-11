<?php
require_once(ROOT_PATH .'/Models/Post.php');

class PostController {
  private $request;
  private $Post;

  public function __construct() {
    $this->request['get'] = $_GET;
    $this->request['post'] = $_POST;

    $this->Post = new Post();
  }

  public function part() {
    $part_all = $this->Post->partAll();
    $params = [
      'part' => $part_all
    ];
    return $params;
  }

  public function complete() {
    $insert = $this->Post->insert($this->request['post']);
    $params = [
      'insert' => $insert
    ];
    return $params;
  }

  public function mypage($user_id) {
    $posts = $this->Post->findAll($user_id);
    $reserves = $this->Post->findReserve($user_id);
    $params = [
      'posts' => $posts,
      'reserves' => $reserves,
    ];
    // var_dump($params['posts']);
    return $params;
  }

  public function findName() {
    $post_user = $this->Post->findName();
    $param = [
      'post_user' => $post_user
    ];
    return $param;
  }

  public function edit($id) {
    $post = $this->Post->findById($id);
    $part_all = $this->Post->partAll();
    $params = [
      'post' => $post,
      'part' => $part_all
    ];
    return $params;
  }

  public function update() {
    $this->Post->postUpdate($this->request["post"]);
  }

  public function delete() {
    $delete = $this->Post->postDelete();
    $params = ['delete' => $delete];
    return $params;
  }

  public function index() {
    $posts = $this->Post->postAll();
    $params = [
      'posts' => $posts,
    ];
    return $params;
  }

  public function search($search_name) {
    $search = $this->Post->search($search_name);
    $params = [
      'search' => $search,
    ];
    return $params;
  }

  public function show() {
    $post = $this->Post->findByPostId();
    $params = [
      'post' => $post
    ];
    return $params;
  }

  public function reserve($post_id, $user_id) {
    $reserve = $this->Post->reserve($post_id, $user_id);
    $flg = $this->Post->flgUpdate($post_id);
    $params = [
      'reserve' => $reserve,
      'flg' => $flg
    ];
    return $params;
  }

  public function cancel() {
    $delete = $this->Post->reserveDelete();
    $cancel = $this->Post->cancel();
    $params = [
      'delete' => $delete,
      'cancel' => $cancel
    ];
    return $params;
  }
}
?>