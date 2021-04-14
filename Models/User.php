<?php

// Models/Db.phpを呼び出し
require_once("Db.php");

// Dbクラスからメソッドの内容を引き継ぐ
// class クラス名 extends 継承元クラス名{処理}
class User extends Db{

    // ログイン処理
    public function login($arr){
        $sql = 'SELECT * FROM users WHERE mail = :mail LIMIT 1';
        $sth = $this->connect->prepare($sql);
        $params = array(':mail'=>$arr['mail']);
        $sth->execute($params);
        $result =$sth->fetch();
        return $result;
    }


    // 参照
    public function selectMails($arr){
        $sql = 'SELECT * FROM users WHERE mail = :mail limit 1';
        $sth = $this->connect->prepare($sql);
        $params = array(':mail'=>$arr['mail']);
        $sth->execute($params);
        $result =$sth->fetch();
        return $result;
    }

    // 参照(ユーザーが登録した本の情報を取得) select
    public function findBuyHistory($id){
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

    // 登録(新規会員登録) insert
    public function add($arr){
        $sql = "INSERT INTO users(name, mail, password, role, created) VALUES(:name, :mail, :password, :role, :created)";
        $sth = $this->connect->prepare($sql);
        $params = array(
            ':name'=>$arr['name'],
            ':mail'=>$arr['mail'],
            ':password'=>password_hash($arr['password'], PASSWORD_DEFAULT),
            ':role'=>0,
            ':created'=>date('Y-m-d H:i:s')
        );
        $sth->execute($params);
    }

    // 参照(貸し借り)
    public function rentalSelect($arr){
        $sql = "SELECT * from rental_items where owner_id = :owner_id AND item_id = :item_id";
        $sth = $this->connect->prepare($sql);
        $params = array(
            ':owner_id'=>$arr['ownerId'],
            ':item_id'=>$arr['itemId']
        );
        $sth->execute($params);
        $result = $sth->fetch();
        return $result;

    }


    // 登録(貸し借り) insert
    public function rentalInsert($arr){
        $sql = "INSERT INTO rental_items(owner_id, item_id, isbn, lent_start_day, lent_end_day, rental_flg, created) VALUES(:owner_id, :item_id, :isbn, :lent_start_day, :lent_end_day, :rental_flg, :created)";
        $sth = $this->connect->prepare($sql);
        $params = array(
            ':owner_id'=>$arr['ownerId'],
            ':item_id'=>$arr['itemId'],
            ':isbn'=>$arr['isbn'],
            ':lent_start_day'=>date('Y-m-d H:i:s'),
            ':lent_end_day'=>$arr['rentEndDay'],
            ':rental_flg'=>$arr['rentalFlg'],
            ':created'=>date('Y-m-d H:i:s')
        );
        $sth->execute($params);
    }

    // 編集(貸し借り) update
    public function rentalEdit($arr){
        $sql = "UPDATE rental_items SET lent_end_day = :lent_end_day, rental_flg = :rental_flg, modified = :modified WHERE id = :id";
        $sth = $this->connect->prepare($sql);
        $params = array(
            ':id'=>$arr['rentalId'],
            ':lent_end_day'=>$arr['rentEndDay'],
            ':rental_flg'=>$arr['rentalFlg'],
            ':modified'=>date('Y-m-d H:i:s')
        );
        $sth->execute($params);
    }


    // 削除(登録書籍) delete
    public function delete($id = null){
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

    // 入力チェック validate
    public function validate($arr){
        $message = array();

        // 名前
        if(empty($arr['name'])){
            $message['name'] = '名前を入力してください';
        }
        else if (preg_match( '/\A[[:^cntrl:]]{1,15}\z/u', $arr['name'] ) == 0 ) {
            $message['name'] = '名前は15文字以内でお願いします。';
        }
        // メールアドレス
        if(empty($arr['mail'])){
            $message['mail'] = 'アドレスを入力してください';
        }
        else { //メールアドレスを正規表現でチェック
            $pattern = '/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/uiD';
            if (!preg_match($pattern, $arr['mail']) ) {
              $message['mail'] = 'メールアドレスの形式が正しくありません。';
            }
        }
        // 問い合わせ内容
        if(empty($arr['password'])){
            $message['password'] = 'パスワードを内容を入力してください';
        }
        else if (preg_match( '/\A[\r\n\t[:^cntrl:]]{1,10}\z/u', $arr['password'] ) == 0 ) {
            $message['password'] = 'パスワードは10文字以内でお願いします。';
        }

        return $message;
    }
}
?>