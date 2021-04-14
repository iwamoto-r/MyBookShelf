<?php
session_start();

//エスケープ処理やデータチェックを行う関数のファイルの読み込み
require "functions.php";

// ログアウト処理
if(isset($_GET['logout'])){
    // セッション情報を破棄する
    $_SESSION = array();
    session_destroy();
  }

// ログイン画面を経由しているかを確認する
if(!isset($_SESSION['User'])){
    header('Location: /myBookShelf/Views/index.php'); // headerとexitはセット
    exit;
  }


// config.phpとUser.phpを読み込み
require_once("../config/config.php");
require_once("../Models/BookIn.php");

try{

    // MySQLへの接続
    $user = new BookIn($host, $dbname, $user, $pass);
    $user->connectDB();

    if(isset($_GET['id'])){
        // 編集処理
        if($_POST){
            $user->editBook($_POST);
            $message = "編集が完了しました！";
        }
        // 参照処理
        $result['User'] = $user->bookDetail($_GET['id']);
    }

} catch (PDOException $e) { // PDOExceptionをキャッチする
    print "エラー!: " . $e->getMessage() . "<br/gt;";
    die();
}
?>
<!-- ライブラリなどの読み込みはこちら -->
<?php require "head.php" ?>
<?php require "header2.php" ?>

<div class="container">
    <div class="page-header">
        <h3 style="background: linear-gradient(transparent 70%, #e2d2ff 0%);">詳細</h3>
    </div>

    <form action="" method="post" name="">

    <p class="text-center text-danger"><?php if(isset($message)){echo $message;}?></p>

    <?php foreach ($result as $row): ?>

    <table class="table">
        <tr>
            <th style="width:250px;">書籍名：</th>
            <td><?=$row['TITLE'];?></td>
        </tr>
        <tr>
            <th>ISBN:</th>
            <td><?=$row['ISBN'];?></td>
        </tr>
        <tr>
            <th>出版社：</th>
            <td><?=$row['PUBLISHER'];?></td>
        </tr>
        <tr>
            <th>著者：</th>
            <td><?=$row['AUTHOR'];?></td>
        </tr>
        <tr>
            <th>出版日:</th>
            <td><?=$row['PUBDATE'];?></td>
        </tr>
        <tr>
            <th>詳細：</th>
            <td><?=$row['DESCRIPTION'];?></td>
        </tr>
        <tr>
            <th>メモ：</th>
            <td><textarea rows="3" class="form-control" id="memo" type="text" name="memo"><?=$row['MEMO'];?></textarea></td>
        </tr>
    </table>

    <?php endforeach; ?>

    <input type ="hidden" name="id" value="<?php if(isset($result['User'])) echo $result['User']['ID']?>">
    <button class="btn btn-info btn-lg btn-block" type="submit" formmethod="post">編集</button>
    </form>

    <p><a href="main.php">メインへ戻る</a></p>

</div>

<?php require "footer.php" ?>