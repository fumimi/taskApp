<?php

// Request.php


class Request {
    // POSTパラメータ
    private $post;
    // GETパラメータ
    private $query;

    // コンストラクタ@
    public function __construct() {
        $this->post = new Post();
        $this->query = new QueryString();
    }

    // POST変数取得
    public function getPost($key = null) {
        if (null == $key) {
            return $this->post->get();
        }
        if (false == $this->post->has($key)) {
            return null;
        }
        return $this->post->get($key);
    }

    // GET変数取得
    public function getQuery($key = null) {
        if (null == $key) {
            return $this->query->get();
        }
        if (false == $this->query->has($key)) {
            return null;
        }
        return $this->query->get($key);
    }
}

?>
