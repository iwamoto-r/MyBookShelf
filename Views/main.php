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

try {

  // MySQLへの接続
  $user = new User($host, $dbname, $user, $pass);
  $user->connectDB();

  // 削除処理
  if(isset($_GET['del'])){
    $user->deleteRental($_GET['del']);
    $user->delete($_GET['del']);
  }

  // 登録処理(貸し借り)
  if(isset($_POST['rentalFlg'])){
    $str = $user->rentalSelect($_POST);
    if($str == null){
      $user->rentalInsert($_POST);
    }else{
      $user->rentalEdit($_POST);
    }

  }

  // 参照処理(ユーザーが登録した本の情報を取得)
  if(isset($_SESSION['User'])){
     $result = $user->findBuyHistory($_SESSION['User']['ID']);
  }

  //接続を閉じる
  $sth = null;
  $user = null;

} catch (PDOException $e) { // PDOExceptionをキャッチする
  print "エラー!: " . $e->getMessage() . "<br/gt;";
  die();
}

?>
<?php require "head.php" ?>
<?php require "header2.php" ?>
  <div class="container">
    <div class="page-header">
        <h3 style="background: linear-gradient(transparent 70%, #e2d2ff 0%);"><?php echo $_SESSION['User']['NAME']; ?>さんの本棚</h3>
    </div>

    <div class="float-right"><a href="book_details.php">新規書籍登録はこちら</a></div>

    <table class="table">
      <tr >
        <th class="text-center">タイトル</th>
        <th></th>
        <th class="text-center">作者</th>
        <th class="text-center">発売日</th>
        <th class="text-center">貸し借り</th>
        <th></th>
      </tr>
      <?php foreach($result as $row): ?>
      <tr>
      <input type="hidden" id="hiddenTitle" value="<?=$row['title'];?>">
        <td class="text-center" width="18%"><?=$row['title'];?></td>
        <td class="text-center" width="3.5%"><a href="book_details2.php?id=<?=$row['books_id'];?>" class="text-success small">詳細</a></td>
        <td class="text-center" width="45%">
          <form action="book_author.php" name="authorForm" id="authorForm">
            <?=$row['author'];?><input type="submit" value="<?=$row['author'];?>" id="author_submit_btn" name="author_submit_btn" onclick="checkText()">
            <input type="hidden" name="author" id="author" value="<?=$row['author'];?>">
          </form>
        </td>
        <td class="text-center" width="10%"><?=substr($row['pubdate'], 0, 10);?></td>
        <td class="text-center" width="20%">
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


  function checkText(){
    var test = $('#author').val();
    console.log(test);
    var elem = test.split('／');
    console.log(elem[0]);
    $('#author').val(elem[0]);
    console.log($('#author').val());

    var authorForm = $('form').attr('name');
    console.log(authorForm);
    document.authorForm.submit();
  }

  $('#hiddenTitle').val();
        if($('#hiddenTitle').val() == ""){
          $('td').css('visibility','hidden');
        }
</script>

<?php require "footer.php" ?>