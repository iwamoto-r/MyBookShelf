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
            <form action="resetComplete.php" method="post" name="inputForm">
                <!-- トークンの受け渡し -->
                <input type ="hidden" name ="token" value="<?php echo h($token);?>">
                <table class="table">
                    <tr>
                        <td>メールアドレス</td>
                        <td><input type="email" name="mail"　class="col-md-10" placeholder="abcd@efg.com"></td>
                    </tr>
                    <tr>
                        <td>新パスワード(半角英数字)</td>
                        <td><input type="password" class="col-md-4" name="password" id="password" placeholder="abcd1234"></td>
                    </tr>
                    <tr>
                        <td>新パスワード(確認)</td>
                        <td><input type="password" class="col-md-4" name="confirm_password" id="confirm_password" placeholder="abcd1234"></td>
                    </tr>
                </table>
            </form>
        </div><!-- card-body -->
        <div class="card-footer">
            <p class="float-left"><a href="index.php">TOPへ戻る</a></p>
            <button type="button" class="btn btn-primary float-right" name="passSubmit" id="passSubmit" style="display:inline-block;">登録</button>
        </div>
    </div>
</div>

<?php require "footer.php" ?>