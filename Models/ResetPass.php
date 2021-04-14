<?php

// Models/Db.phpを呼び出し
require_once("Db.php");

// Dbクラスからメソッドの内容を引き継ぐ
// class クラス名 extends 継承元クラス名{処理}
class ResetPass extends Db{

    // 参照(メールアドレスに一致する情報を取得) select
    public function findMail($mail){
        $sql = 'SELECT * FROM users WHERE mail = :mail';
        $sth = $this->connect->prepare($sql);
        $params = array(':mail'=>$mail);
        $sth->execute($params);
        $result = $sth->fetch();
        return $result;
    }

    // 編集(パスワード変更) edit
    public function editPassword($arr){
        $sql = "UPDATE users SET password = :password, modified = :modified WHERE mail = :mail";
        $sth = $this->connect->prepare($sql);
        $params = array(
            ':mail'=>$arr['mail'],
            ':password'=>password_hash($arr['password'], PASSWORD_DEFAULT),
            // ':password'=>$arr['password'],
            ':modified'=>date('Y-m-d H:i:s')
        );
        $sth->execute($params);
    }

}

?>