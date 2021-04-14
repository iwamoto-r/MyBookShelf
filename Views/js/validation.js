
// index.php
$('#submit_btn').on('click',function(){
    // 変数作成
    var errMsg = null;
    var mailMsg = null;
    var passMsg = null;
    var nameMsg = null;
    var mailVal = $('#mail').val();
    var passVal = $('#password').val();
    var reg = /^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]{1,}\.[A-Za-z0-9]{1,}$/;


    // アドレスチェック
    if(mailVal == '' || !reg.test(mailVal)){
        mailMsg = "アドレスが未入力か、使用できない文字が入っているか、形式が間違っています。";
    }

    // パスワードチェック
    if(passVal == '' || passVal.length < 4 || !passVal.match(/^[A-Za-z0-9]*$/)){
        passMsg = "パスワードは半角英数字 4～8 文字で入力してください。";
    }

    if(errMsg == null && passMsg == null && mailMsg == null && nameMsg == null){
        inputForm.submit();
    } else if(mailMsg != null){
        alert(mailMsg);
    } else if(passMsg != null){
        alert(passMsg);
    }
});


// signuo.php
$('#signUpSubmit').on('click',function(){
    // 変数作成
    var errMsg = null;
    var mailMsg = null;
    var passMsg = null;
    var nameMsg = null;
    var mailVal = $('#mail').val();
    var passVal = $('#password').val();
    var nameVal = $('#name').val()
    var reg = /^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]{1,}\.[A-Za-z0-9]{1,}$/;

    // 名前チェック(エラー出てる)
    if(nameVal == ''){
        nameMsg = "名前は15文字以内で入力してください。";
    } else if (nameVal.length < 2){
        nameMsg = "名前は2文字～15文字以内で入力してください。";
    }

    // アドレスチェック
    if(mailVal == '' || !reg.test(mailVal)){
        mailMsg = "アドレスが未入力か、使用できない文字が入っているか、形式が間違っています。";
    }

    // パスワードチェック
    if(passVal == '' || passVal.length < 4 || !passVal.match(/^[A-Za-z0-9]*$/)){
        passMsg = "パスワードは半角英数字 4～8 文字で入力してください。";
    }

    if(errMsg == null && passMsg == null && mailMsg == null && nameMsg == null){
        inputForm.submit();
    } else if(nameMsg != null){
        alert(nameMsg);
    } else if(mailMsg != null){
        alert(mailMsg);
    } else if(passMsg != null){
        alert(passMsg);
    }
});

// mail.php
$('#mailSubmit').on('click',function(){
    // アドレスチェック
    var mailMsg = null;
    var mailVal = $('#mail').val();
    var reg = /^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]{1,}\.[A-Za-z0-9]{1,}$/;
    if(mailVal == '' || !reg.test(mailVal)){
        mailMsg = "アドレスが未入力か、使用できない文字が入っているか、形式が間違っています。";
    }

    if(mailMsg == null){
        inputForm.submit();
    } else if(mailMsg != null){
        alert(mailMsg);
    }
});

// repass.php
$('#passSubmit').on('click',function(){
    // 変数作成
    var passMsg = null;
    var passVal = $('#password').val();null;
    var passSetMsg = null;
    var passSetVal = $('#confirm_password').val();null;

    // パスワードチェック
    if(passVal == '' || passVal.length < 4 || !passVal.match(/^[A-Za-z0-9]*$/)){
        passMsg = "パスワードは半角英数字 4～8 文字で入力してください。";
    }

    // パスワードチェック
    if(passSetVal == '' || passSetVal.length < 4 || !passSetVal.match(/^[A-Za-z0-9]*$/)){
        passSetMsg = "パスワードは半角英数字 4～8 文字で入力してください。";
    }

    if(passMsg == null || passSetMsg == null){
        inputForm.submit();
    } else if(passMsg != null){
        alert(passMsg);
    } else if(passSetMsg != null){
        alert(passSetMsg);
    }
});


