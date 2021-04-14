<?php
session_start();

// config.phpとUser.phpを読み込み
require_once("../config/config.php");
require_once("../Models/Owner.php");


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

try {

  // MySQLへの接続
  $user = new Owner($host, $dbname, $user, $pass);
  $user->connectDB();

  // 削除処理
  if(isset($_GET['del'])){
    $user->deleteRentals($_GET['del']);
    $user->deleteBooks($_GET['del']);
    $user->delete($_GET['del']);
  }

  // 参照処理(検索したユーザの情報)
  if($_POST){
    $result = $user->findUserOne($_POST["userMail"]);
    print_r($result);
  }

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

  <div class=container>

      <div style="width: 100%; height:30px;">
        <button type="submit" form="selectUser" class="btn btn-warning float-right">ユーザ検索</button>
        <form action="" method="post" id="selectUser">
          <input  class="float-right" id="userMail" type="text" name="userMail" value="" autofocus>
        </form>
      </div>

    <table class="table">
      <tr>
        <th>アカウント名</th>
        <th>メールアドレス</th>
        <th>作成日</th>
        <th></th>
      </tr>
      <tr>
      <input id="hiddenMail" type="hidden" value="<?php if(isset($result['NAME'])){echo $result['NAME'];} ?>">

        <td><a href="ownerDetails.php?id=<?=$result['ID'];?>"><?php if(isset($result['NAME'])){echo $result['NAME'];} ?></a></td>
        <td><?php if(isset($result['MAIL'])){echo $result['MAIL'];} ?></td>
        <td><?php if(isset($result['CREATED'])){echo $result['CREATED'];} ?></td>

        <td><a href="?del=<?=$result['ID']; ?>" onClick = "if(!confirm('削除しますがよろしいでしょうか？')) return false;">削除</a></td>
      </tr>
    </table>
  </div>

  <script>
    $('#hiddenMail').val();
        if($('#hiddenMail').val() == ""){
          $('td').css('visibility','hidden');
        }
  </script>

<?php require "footer.php" ?>