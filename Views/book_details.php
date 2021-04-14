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

$userId = $_SESSION['User']['ID'];

try{

    // MySQLへの接続
    $user = new BookIn($host, $dbname, $user, $pass);
    $user->connectDB();

    if($_POST){
      if(!empty($_POST['title'])){
        $user->insertBook($_POST);
        $message = "登録が完了しました！";
      }else{
        $message = "ISBNコードを入力してください。";
      }
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
          <h3 style="background: linear-gradient(transparent 70%, #e2d2ff 0%);">本の新規登録</h3>
      </div>
    <div style="width: 100%; height:30px;">
        <button id="getBookInfo" class="btn btn-warning float-right">書籍情報取得</button>
        <input  class="float-right" id="isbn13" type="text" name="isbn13" value="" autofocus>
    </div>

    <p class="text-center text-danger"><?php if(isset($message)){echo $message;}?></p>


    <form action="" method="post" name="">

    <table class="table">
    <tr class="row"><p id="thumbnail" class="text-center"></p></tr>
    <tr>
      <th class="text-center">書籍名</th>
      <td><input id="title" type="text" name="title" value="" readonly></td>
    </tr>
    <tr>
      <th class="text-center">ISBN</th>
      <td><input id="isbn" type="text" name="isbn" value="" readonly></td>
    </tr>
    <tr>
      <th class="text-center">出版社</th>
      <td><input id="publisher" type="text" name="publisher" value="" readonly></td>
    </tr>
    <tr>
      <th class="text-center">著者</th>
      <td><input id="author" type="text" name="author" value="" readonly></td>
    </tr>
    <tr>
      <th class="text-center">出版日</th>
      <td><input id="pubdate" type="text"  name="pubdate" value="" readonly></td>
    </tr>
    <tr>
      <th class="text-center">サムネイルURI</th>
      <td><input id="cover" type="text" name="cover" value=""readonly></td>
    </tr>
    <tr>
      <th class="text-center">詳細</th>
      <td><textarea rows="3" class="form-control" id="description" type="text" name="description" value="" readonly></textarea></td>
    </tr>
    <tr>
      <th class="text-center">メモ</th>
      <td><textarea rows="3" class="form-control" id="memo" type="text" name="memo" value="" ></textarea></td>
    </tr>
    </table>

    <input type="hidden" name="user_id" value="<?php if(isset($_SESSION['User'])) echo h($userId); ?>">
    <button class="btn btn-info btn-lg btn-block" type="submit" formmethod="post">登録</button>
    </form>

    <p><a href="main.php">メインへ戻る</a></p>

    </div>


    <script>
    jQuery(function(){
      jQuery('#getBookInfo').on('click', function(){
        var script = $('<script>').attr({
          'type': 'text/javascript',
          'src': 'js/main.js'
        });
      $('body')[0].appendChild(script[0]);
      });
    });
    </script>

<?php require "footer.php" ?>