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
        <h3 style="background: linear-gradient(transparent 70%, #99ccff 0%);">新規登録画面</h3>
    </div>

    <div class="card" style="margin-top:30px;">
        <div class="card-body">
          <form action="confilm.php" method="post" name="inputForm">
            <!-- トークンの受け渡し -->
            <input type ="hidden" name ="token" value="<?php echo h($token);?>">
            <table class="table">
                <tr>
                    <td style="width:250px;">名前</td>
                    <td><input type="text" name="name" class="col-md-5" id="name" value="" maxlength="15" placeholder="user name"></td>
                </tr>
                <tr>
                    <td>メールアドレス</td>
                    <td><input type="email" class="col-md-8" name="mail" id="mail" placeholder="abcd@efg.com"></td>
                </tr>
                <tr>
                    <td>パスワード</td>
                    <td><input type="password" class="col-md-2" id="password" name="password" placeholder="abcd1234"></td>
                </tr>
            </table>

          </form>
        </div><!-- card-body -->
        <div class="card-footer">
            <p class="float-left"><a href="index.php">TOPへ戻る</a></p>
            <button type="button" class="btn btn-primary float-right" value="確認画面へ" name="signUpSubmit" id="signUpSubmit" style="display:inline-block;">確認</button>
        </div>
    </div>
</div>

<?php require "footer.php" ?>