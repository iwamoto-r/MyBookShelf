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
        header('location: index.php');
        exit();
	}
} else {
	//トークンが存在しない場合(ダイレクトアクセス時)リダイレクト
    header('location: index.php');
    exit();
}

// config.phpとUser.phpを読み込み
require_once("../config/config.php");
require_once("../Models/User.php");

try {
	$user = new User($host, $dbname, $user, $pass);
	$user->connectDb();

	// 登録処理
	if(isset($_POST)){
        $result = $user->selectMails($_POST);
        if($result > 0){
            $messageMail = "メールアドレスが重複しています。<br>";
            $messageMail .= "新しいメールアドレスで登録しなおしてください。";
        }else{
            $message = $user->validate($_POST);
            if(empty($message['name']) && empty($message['mail']) && empty($message['password'])){
                $user->add($_POST);
                $messageMail = "登録が完了しました。";
            }
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

            <p class="text-danger text-center"><?php if(isset($messageMail)){echo $messageMail;}?></p>
            <p class="text-danger text-center"><?php if(isset($message['name'])){echo h($message['name']);}?></p>
            <p class="text-danger text-center"><?php if(isset($messageMail['mail'])){echo h($messageMail['mail']);}?></p>
            <p class="text-danger text-center"><?php if(isset($messageMail['password'])){echo h($messageMail['password']);}?></p>


        </div>
        <div class="card-footer">
            <p class="float-left"><a href="index.php">TOPへ戻る</a></p>
        </div>
    </div>
</div>


<?php require "footer.php" ?>