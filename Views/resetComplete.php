<?php

//セッションを開始
session_start();

//エスケープ処理やデータチェックを行う関数のファイルの読み込み
require "functions.php";

//固定トークンの確認
if (isset($_POST['token'], $_SESSION['token'])){
	$token = $_POST['token'];
	if ($token !== $_SESSION['token']){
		// トークンが一致しない場合リダイレクト
        header('Location: /myBookShelf/Views/index.php');
        exit();
	}
} else {
	// トークンが存在しない場合(ダイレクトアクセス時)リダイレクト
    header('Location: /myBookShelf/Views/index.php');
    exit();
}

// config.phpとUser.phpを読み込み
require_once("../config/config.php");
require_once("../Models/ResetPass.php");

try {
	$user = new ResetPass($host, $dbname, $user, $pass);
	$user->connectDb();

    if(!empty($_POST)){
        if($_POST['password'] == $_POST['confirm_password']){
            $user->editPassword($_POST);
            $message = "パスワードを変更しました。";
        }else{
            header('Location: /myBookShelf/Views/repass.php');
            exit();
            }
    }

  } catch (PDOException $e) {
  exit('データベースに接続できませんでした。' . $e->getMessage());
  }

  session_destroy();

?>
<?php require "head.php" ?>
<?php require "header.php" ?>
<div class="container">
    <div class="card">
        <div class="card-body">

            <p class="text-center"><?php if(isset($message)){echo h($message);}?></p>

        </div>
        <div class="card-footer">
            <p class="float-left"><a href="index.php">TOPへ戻る</a></p>
        </div>
    </div>
</div>


<?php require "footer.php" ?>