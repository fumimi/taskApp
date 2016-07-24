<?php

// namespace LearningApp;

class ModelBase {

    protected $db;

    // インスタンスの生成時に自動的に接続される
    public function __construct(){
        $this->initDb();
    }

    //DB connect
    public function initDb(){
      try {
        // connect
        $this->db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
        if ($this->db == null){ print('接続に失敗しました。<br>'); }else{ print('接続に成功しました。<br>'); }
      } catch (PDOException $e) {
        // errer
        $e->getMessage();
        exit;
      }
    }

    // クエリ結果を取得
    public function query($sql, array $params = array()){

      $stmt = $this->db->prepare($sql);// 変化する部分のみを解析＆実行
      if ($params != null) {
          foreach ($params as $key => $val) {
              $stmt->bindValue(':' . $key, $val);// 値を割り当てる
          }
      }
      $stmt->execute();// execute メソッドを呼び出すとSQLが実行（この行はなぜ必要なの？？）
      $rows = $stmt->fetchAll();// 全ての結果行を含む配列を返す
      return $rows;

    }

    public $tableName;

    // INSERTを実行
    public function insert($data){
        $fields = array();
        $values = array();
        foreach ($data as $key => $val) {
            $fields[] = $key;
            $values[] = ':' . $key;
        }
        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            $this->tableName,
            implode(',', $fields),
            implode(',', $values)
        );
        $stmt = $this->db->prepare($sql);
        foreach ($data as $key => $val) {
            $stmt->bindValue(':' . $key, $val);
        }
        $res  = $stmt->execute();

        return $res;
    }

    // DELETEを実行
    public function delete($where, $params = null){
        $sql = sprintf("DELETE FROM %s", $this->name);
        if ($where != "") {
            $sql .= " WHERE " . $where;
        }
        $stmt = $this->db->prepare($sql);
        if ($params != null) {
            foreach ($params as $key => $val) {
                $stmt->bindValue(':' . $key, $val);
            }
        }
        $res = $stmt->execute();

        return $res;
    }

    // DB close
    public function closeDb(){
      $db = null;
      if ($db == null){ print('接続を切断しました。<br>'); }else{ print('接続を切断できませんでした。<br>'); }
    }

}

?>
