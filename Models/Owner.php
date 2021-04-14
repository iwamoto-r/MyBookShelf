<?php

// Models/Db.phpを呼び出し
require_once("Db.php");

// Dbクラスからメソッドの内容を引き継ぐ
// class クラス名 extends 継承元クラス名{処理}
class Owner extends Db{


    // 参照(管理画面(owner.php)用、ユーザ一覧取得) select
    public function findUser(){
        $sql = "SELECT * FROM users";
        $sth = $this->connect->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll();
        return $result;
    }

    // 参照(管理画面(owner.php)用、ユーザ一覧取得) select
    public function findUserOne($userMail){
        $sql = "SELECT * FROM users WHERE mail = :mail AND role = 0";
        $sth = $this->connect->prepare($sql);
        $params = array(':mail'=>$userMail);
        $sth->execute($params);
        $result = $sth->fetch();
        return $result;
    }

    // 削除(ユーザが登録している本の一括削除) delete
    public function deleteBooks($id = null){
        if(isset($id)){
            $sql = "DELETE FROM users_books WHERE user_id = :user_id";
            $sth = $this->connect->prepare($sql);
            $params = array(':user_id'=>$id);
            $sth->execute($params);
        }
    }

    // 削除(ユーザの貸し借り状況一括削除) delete
    public function deleteRentals($id = null){
        if(isset($id)){
            $sql = "DELETE FROM rental_items WHERE owner_id = :owner_id";
            $sth = $this->connect->prepare($sql);
            $params = array(':owner_id'=>$id);
            $sth->execute($params);
        }
    }

    // 削除 delete
    public function delete($id = null){
        if(isset($id)){
            $sql = "DELETE FROM users WHERE id = :id";
            $sth = $this->connect->prepare($sql);
            $params = array(':id'=>$id);
            $sth->execute($params);
        }
    }

    // 参照(ユーザーが登録した本の情報を取得) select
    public function userBooks($id){
        $sql = "SELECT distinct ";
        $sql .= "users.id AS user_id, ";
        $sql .= "users.name, ";
        $sql .= "users_books.id AS books_id, ";
        $sql .= "users_books.title, ";
        $sql .= "users_books.author, ";
        $sql .= "users_books.pubdate, ";
        $sql .= "users_books.isbn, ";
        $sql .= "rental_items.rental_flg, ";
        $sql .= "rental_items.lent_end_day, ";
        $sql .= "rental_items.id AS rental_id ";
        $sql .= "FROM users ";
        $sql .= "LEFT JOIN users_books ON users.id = users_books.user_id ";
        $sql .= "LEFT JOIN rental_items ON rental_items.item_id = users_books.id ";
        $sql .= "WHERE users.id = :id ";
        $sql .= "ORDER BY users_books.title DESC";
        $sth = $this->connect->prepare($sql);
        $params = array(':id'=>$id);
        $sth->execute($params);
        $result = $sth->fetchAll();
        return $result;
    }

    // 削除(登録書籍) delete
    public function deleteBook($id = null){
        if(isset($id)){
            $sql = "DELETE FROM users_books WHERE id = :id";
            $sth = $this->connect->prepare($sql);
            $params = array(':id'=>$id);
            $sth->execute($params);
        }
        }

    // 削除(貸し借り) delete
    public function deleteRental($id = null){
        if(isset($id)){
            $sql = "DELETE FROM rental_items WHERE item_id = :item_id";
            $sth = $this->connect->prepare($sql);
            $params = array(':item_id'=>$id);
            $sth->execute($params);
        }
    }

}

?>