<?php
session_start();

// config.phpとUser.phpを読み込み
require_once("../config/config.php");
require_once("../Models/User.php");

try {

    // MySQLへの接続
    $user = new User($host, $dbname, $user, $pass);
    $user->connectDB();

    if($_POST){
        if($result = $user->login($_POST)){
            if(password_verify($_POST['password'], $result['PASSWORD']) === true){
                $_SESSION['User'] = $result;
                if($_SESSION['User']['ROLE'] == 1){
                    header('Location: ownerMain.php');
                    exit;
                }elseif($_SESSION['User']['ROLE'] == 0){
                    header('Location: main.php');
                    exit;
                }else{
                    $message = "*ログインできませんでした";
                }
            }else{
                $message = "*メールアドレス、もしくはパスワードが違います。";
            }
        }else{
            $message = "*メールアドレス、もしくはパスワードが違います。";
        }
    }

    // 接続を閉じる
    $sth = null;
    $user = null;

    }
    catch (PDOException $e) { // PDOExceptionをキャッチする
        print "エラー!: " . $e->getMessage() . "<br/gt;";
        die();
}
?>
<!-- ライブラリなどの読み込みはこちら -->
<?php require "head.php" ?>
<?php require "header.php" ?>

<div class="container">
    <div class="page-header">
        <h3 style="background: linear-gradient(transparent 70%, #99ccff 0%);">ログインページ</h3>
    </div>
    <div class="errorMessage">
        <p class="text-danger text-center"><?php if(isset($message)){echo $message;}?></p></p>
    </div>
    <div style="margin-top:30px;">
        <form action="" method="post" name="inputForm" onSubmit="return check()">
            <table class="table">
                <tr>
                    <th style="width:250px;">メールアドレス</th>
                    <td><input type="email" class="col-md-8" name="mail" id="mail" maxlength="100" placeholder="abcd@efg.com"></td>
                </tr>
                <tr>
                    <th>パスワード</th>
                    <td><input type="password" class="col-md-2" id="password" name="password" maxlength="8" placeholder="abcd1234"></td>
                </tr>
            </table>
        </form>
    </div>

    <!-- ↓このボタンはformの中に限らず、好きな箇所に配置してOK -->

    <button type="button" class="btn btn-primary float-right" name="submit_btn" id="submit_btn">ログイン</button>


    <p><a href="signup.php">アカウント新規作成</a></p>
    <p><a href="mail.php">パスワードを忘れた方はこちら</a></p>


</div>
<!-- 後乗せjsはfooterの中 -->
<?php require "footer.php" ?>