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

if(isset($_GET['id'])){
  $_SESSION['id'] = $_GET['id'];
}

try {

  // MySQLへの接続
  $user = new Owner($host, $dbname, $user, $pass);
  $user->connectDB();


  // 削除処理
  if(isset($_GET['del'])){
    $user->deleteRental($_GET['del']);
    $user->deleteBook($_GET['del']);
  }

  if(isset($_SESSION['id'])){
    // 参照処理
    $result = $user->userBooks($_SESSION['id']);
    print_r($result);
    print_r($_SESSION['id']);
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

<div class="container">

  <p><a href="ownerMain.php">会員検索に戻る</a></p>

  <table class="table">
    <tr >
      <th class="text-center">タイトル</th>
      <!-- <th></th> -->
      <!-- <th class="text-center">作者</th> -->
      <!-- <th class="text-center">発売日</th> -->
      <th class="text-center">貸し借り</th>
      <th></th>
    </tr>
    <?php foreach($result as $row): ?>
    <tr>
    <input type="hidden" id="hiddenTitle" value="<?=$row['title'];?>">
      <td class="text-center" width="31.5%"><?=$row['title'];?></td>
      <!-- <td class="text-center" width="3.5%"><a href="book_details2.php?id=<?=$row['books_id'];?>" class="text-success small">詳細</a></td> -->
      <!-- <td class="text-center" width="45%">
        <form action="book_author.php" name="authorForm" id="authorForm">
          <?=$row['author'];?><input type="submit" value="<?=$row['author'];?>" id="author_submit_btn" name="author_submit_btn" onclick="checkText()">
          <input type="hidden" name="author" id="author" value="<?=$row['author'];?>">
        </form>
      </td> -->
      <!-- <td class="text-center" width="10%"><?=substr($row['pubdate'], 0, 10);?></td> -->
      <td class="text-center" width="65%">
        <form method="POST">
          <input type="hidden" name="itemId" value="<?=$row['books_id'];?>">
          <input type="hidden" name="isbn" value="<?=$row['isbn'];?>">
          <input type="hidden" name="ownerId" value="<?=$_SESSION['User']['ID'];?>">
          <input type="hidden" name="rentalId" value="<?=$row['rental_id'];?>">
          <select class="" id="rental" name="rentalFlg">
            <option value="0" name="flg0" <?php if($row['rental_flg'] == 0){echo "selected";} ?>>所持</option>
            <option value="1" name="flg1" <?php if($row['rental_flg'] == 1){echo "selected";} ?>>貸し出し中</option>
          </select>
          <input type="date" name="rentEndDay"value="<?php if($row['rental_flg'] == 1){echo substr($row['lent_end_day'], 0, 10);} ?>">
          <input type="submit" value="登録">
        </form>
      </td>
      <td class="text-center" width="3.5%"><a href="?del=<?=$row['books_id']; ?>" onClick = "if(!confirm('削除しますがよろしいでしょうか？')) return false;" class="text-danger small">削除</a></td>
    </tr>
    <?php endforeach; ?>
  </table>
</div>

<script>
$('[name=author_submit_btn]').each(function(i,elem){
  var authorElem = $(elem).val().split('／');
  console.log(authorElem[0]);
  $(elem).val(authorElem[0]);
});
</script>

<?php require "footer.php" ?>