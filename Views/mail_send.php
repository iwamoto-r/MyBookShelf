<?php

//セッションを開始
session_start();

//固定トークンの確認
if (isset($_POST['token'], $_SESSION['token'])){
	$token = $_POST['token'];
	if ($token !== $_SESSION['token']){
		//トークンが一致しない場合リダイレクト
        header('location: index.php');
        exit();
	}
} else {
	//トークンが存在しない場合(ダイレクトアクセス時)リダイレクト
    header('location: index.php');
    exit();
}

//エスケープ処理やデータチェックを行う関数のファイルの読み込み
require "functions.php";

// config.phpとUser.phpを読み込み
require_once("../config/config.php");
require_once("../Models/ResetPass.php");

define('SERVER', 'localhost');

try {

    // MySQLへの接続
    $user = new ResetPass($host, $dbname, $user, $pass);
    $user->connectDB();

    if(!empty($_POST)){
        $result = $user->findMail($_POST['mail']);
        if($_POST['mail'] == $result['MAIL']){
            // 言語の設定
            mb_language("japanese");
            // 内部エンコーディングの設定
            mb_internal_encoding("utf-8");
            // メール作成
            $url = "http://" . SERVER . "/myBookShelf/Views/repass.php?";
            $mail = str_replace(array('\r\n','\r','\n'), '', $_POST['mail']);
            $title = "パスワードリセット";
            $msg = "以下のアドレスからパスワードリセットを行ってください。" . PHP_EOL;
            $msg .= $url;
            $option = "From: mybookshelf_test@yahoo.co.jp";
            if(mb_send_mail($mail , $title , $msg , $option)){
                $sendMessage = "メールが送信されました。";
            } else {
                $sendMessage = "メールが送信されました。<br>";
                $sendMessage .= "届かない場合、もう一度送信しなおしてください";
            }
        }else{
            $_SESSION['errorMail'] = "メールが送信されました。<br>届かない場合、もう一度送信しなおしてください。";
            header('Location: /myBookShelf/Views/mail.php'); // headerとexitはセット
            exit;
        }
    }

    // 接続を閉じる
    $sth = null;
    $user = null;

    }
    catch (PDOException $e) { // PDOExceptionをキャッチする
        print "エラー!: " . $e->getMessage() . "<br/gt;";
        die();
}

?>
<?php require "head.php" ?>
<?php require "header.php" ?>
<div class="container">
    <div class="card">
        <div class="card-body">

            <p class="text-center"><?php if(isset($sendMessage)){echo $sendMessage;}?></p>

        </div>
        <div class="card-footer">
            <p class="float-left"><a href="index.php">TOPへ戻る</a></p>
        </div>
    </div>
</div>


<?php require "footer.php" ?>