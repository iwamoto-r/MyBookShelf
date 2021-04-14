<?php
//HTMLの特殊文字をエスケープして結果を出力
function h($str){
    echo htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

//入力値に不正なデータがないかなどをチェックする関数
// function checkInput($var){
//   if(is_array($var)){
//     return array_map('checkInput', $var);
//   }else{
    //NULLバイト攻撃対策
    // if(preg_match('/\0/', $var)){
    //   die('不正な入力です。');
    // }
    //文字エンコードのチェック
    // if(!mb_check_encoding($var, 'UTF-8')){
    //   die('不正な入力です。');
    // }
    //改行、タブ以外の制御文字のチェック
//     if(preg_match('/\A[\r\n\t[:^cntrl:]]*\z/u', $var) === 0){
//       die('不正な入力です。制御文字は使用できません。');
//     }
//     return $var;
//   }
// }

//入力値に不正なデータがないかなどをチェックする関数
function checkInput($str){
    if(is_array($str)){
      return array_map('checkInput', $str);
    }else{
      //NULLバイト攻撃対策
      if(preg_match('/\0/', $str)){
        die('不正な入力です。');
      }
      //文字エンコードのチェック
      if(!mb_check_encoding($str, 'UTF-8')){
        die('不正な入力です。');
      }
      //改行、タブ以外の制御文字のチェック
      if(preg_match('/\A[\r\n\t[:^cntrl:]]*\z/u', $str) === 0){
        die('不正な入力です。制御文字は使用できません。');
      }
      return $str;
    }
  }

// URL の一時パスワードを作成
function get_url_password() {
  $token_legth = 16;//16*2=32byte
  $bytes = openssl_random_pseudo_bytes($token_legth);
  return hash('sha256', $bytes);
}