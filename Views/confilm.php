<?php

//セッションを開始
session_start();

//エスケープ処理やデータチェックを行う関数のファイルの読み込み
require "functions.php";

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

//POSTされたデータを変数に格納
$name = isset( $_POST['name'] ) ? $_POST['name'] : NULL;
$mail = isset( $_POST['mail'] ) ? $_POST['mail'] : NULL;
$password = isset( $_POST['password'] ) ? $_POST['password'] : NULL;
?>

<?php require "head.php" ?>
<?php require "header.php" ?>
<div class="container">
    <div class="page-header">
        <h3 style="background: linear-gradient(transparent 70%, #99ccff 0%);">確認画面</h3>
    </div>

    <form action="complete.php" method="post">
        <div class="card" style="margin-top:30px;">
            <div class="card-body">

                <!-- 完了ページへ渡すトークン　-->
                <input type ="hidden" name ="token" value="<?php echo h($token);?>">
                <input type ="hidden" name ="name" value="<?php echo h($name);?>">
                <input type ="hidden" name ="mail" value="<?php echo h($mail);?>">
                <input type ="hidden" name ="password" value="<?php echo h($password);?>">

                <table class="table ">
                    <tr>
                        <td style="width:250px;">名前</td>
                        <td><?php echo h($name); ?></td>
                    </tr>
                    <tr>
                        <td>メールアドレス</td>
                        <td><?php echo h($mail); ?></td>
                    </tr>
                    <tr>
                        <td>パスワード</td>
                        <td><?php echo h($password); ?></td>
                    </tr>
                </table>
            </div><!-- card-body -->
            <div class="card-footer">
                <button type="button" class="btn btn-secondary float-left" value="登録画面へ戻る" id="submit_btn" onclick=history.back()>戻る</button>
                <input type="submit" value="登録" class="btn btn-primary float-right">
            </div>
        </div>
    </form>
</div>

<?php require "footer.php" ?>