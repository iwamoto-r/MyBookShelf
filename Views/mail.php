<?php

//セッションを開始
session_start();

//エスケープ処理やデータチェックを行う関数のファイルの読み込み
require "functions.php";

//トークンの生成
if (!isset($_SESSION['token'])){
	//セッション変数にトークンを代入
	$_SESSION['token'] = sha1(uniqid(mt_rand(),TRUE));
}
//トークンを変数に代入
$token = $_SESSION['token'];

?>
<?php require "head.php" ?>
<?php require "header.php" ?>

<div class="container">
    <div class="page-header">
        <h3 style="background: linear-gradient(transparent 70%, #FFC778 0%);">パスワード再設定画面</h3>
    </div>

    <div class="card" style="margin-top:30px;">
        <div class="card-body">
            <form action="mail_send.php" method="post" name="inputForm">
            <!-- トークンの受け渡し -->
            <input type ="hidden" name ="token" value="<?php echo $_SESSION['token'];?>">
                <p>ご登録されているメールアドレス宛に送信を行い確認作業を行います</p>
                <input type="email" class="col-md-6" name="mail" id="mail" maxlength="100" placeholder="abcd@efg.com">
                <button type="button" class="btn" name="mailSubmit" id="mailSubmit" style="margin-left:30px;width:100px;background-color:#FFC778;">送信</button>
            </form>
        </div><!-- card-body -->
        <div class="card-footer">
            <p><a href="index.php">TOPへ戻る</a></p>
        </div>
    </div>
</div>

<?php require "footer.php" ?>