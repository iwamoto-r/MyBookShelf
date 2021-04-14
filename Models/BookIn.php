<?php

// Models/Db.phpを呼び出し
require_once("Db.php");

// Dbクラスからメソッドの内容を引き継ぐ
// class クラス名 extends 継承元クラス名{処理}
class BookIn extends Db{

    // 登録(本の情報をDBに保存) insert
    public function insertBook($arr){
        $sql = "INSERT INTO users_books(user_id, isbn, title, author, publisher, pubdate, description, memo, created, modified) VALUES(:user_id, :isbn, :title, :author, :publisher, :pubdate, :description, :memo, :created, :modified)";
        $sth = $this->connect->prepare($sql);
        $params = array(
            ':user_id'=>$arr['user_id'],
            ':isbn'=>$arr['isbn'],
            ':title'=>$arr['title'],
            ':author'=>$arr['author'],
            ':publisher'=>$arr['publisher'],
            ':pubdate'=>$arr['pubdate'],
            ':description'=>$arr['description'],
            ':memo'=>$arr['memo'],
            ':created'=>date('Y-m-d H:i:s'),
            ':modified'=>date('Y-m-d H:i:s')
        );
        $sth->execute($params);
    }

    // 参照() select
    public function bookDetail($id){
        $sql = 'SELECT * FROM users_books WHERE id = :id';
        $sth = $this->connect->prepare($sql);
        $params = array(':id'=>$id);
        $sth->execute($params);
        $result = $sth->fetch();
        return $result;
    }

    // 編集() update
    public function editBook($arr){
        $sql = "UPDATE users_books SET memo = :memo WHERE id = :id";
        $sth = $this->connect->prepare($sql);
        $params = array(':id'=>$arr['id'], ':memo'=>$arr['memo']);
        $sth->execute($params);
    }
}
?>