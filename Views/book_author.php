<?php
session_start();

// config.phpとUser.phpを読み込み
require_once("../config/config.php");
require_once("../Models/User.php");


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
$author = $_GET['author'];

try {

  // MySQLへの接続
  $user = new User($host, $dbname, $user, $pass);
  $user->connectDB();

  //接続を閉じる
  $sth = null;
  $user = null;

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
          <h3 style="background: linear-gradient(transparent 70%, #e2d2ff 0%);">作者既刊情報一覧</h3>
      </div>

      <p><a href="main.php">メインへ戻る</a></p>

      <input class='input bg-white mb16' type='hidden' id='$q' />

      <div id='$results'></div>

    </div>

    <script>
        var author ='<?php echo $author; ?>';
        console.log(author);
    </script>
    <script src="js/googleapi.js"></script>

<?php require "footer.php" ?>