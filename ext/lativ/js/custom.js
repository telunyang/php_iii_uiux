//選擇生日
$("input#birthdate").datepicker({
    dateFormat: "yy-mm-dd"
});

//註冊
$('button#btn_register').click(function(event){
    //避免元素的預設事件被觸發
    event.preventDefault();

    //各自將 input 帶入變數中
    let input_email = $('input#email');
    let input_pwd = $('input#pwd');
    let input_name = $('input#name')
    let input_birthdate = $('input#birthdate');
    let input_address = $('input#address');

    //判斷 email 是否符合自訂格式
    let re = /\S+@\S+(\.\S+)+/;
    if( !re.test(input_email.val()) ){
        input_email
        .addClass("border border-danger border-2")
        .tooltip({
            title: '請填寫完整的 E-mail',
            placement: 'top'
        })
        .tooltip('show');

        return false;
    } else {
        input_email
        .removeClass("border border-danger border-2")
        .tooltip()
        .tooltip('dispose');
    }

    //檢查 密碼 是否輸入
    if( input_pwd.val() == '' ) {
        alert('請輸入密碼');
        return false;
    }

    //檢查 姓名 是否輸入
    if( input_name.val() == '' ) {
        alert('請輸入姓名');
        return false;
    }

    //檢查 生日 是否輸入
    if( input_birthdate.val() == '' ) {
        alert('請輸入生日');
        return false;
    }

    //檢查 地址 是否輸入
    if( input_address.val() == '' ) {
        alert('請輸入地址');
        return false;
    }

    // //將所有欄位的值整合在陣列中，
    // let arrValue = [input_pwd.val(), input_name.val(), input_birthdate.val(), input_address.val()];

    // //判斷其它欄位是否填寫完成
    // if(arrValue.indexOf('') > -1){
    //     alert('請正確填寫欄位');
    //     return false;
    // }

    //送出 post 請求，註冊帳號
    let objUser = {
        email: input_email.val(),
        pwd: input_pwd.val(),
        name: input_name.val(),
        birthdate: input_birthdate.val(),
        address: input_address.val()
    };
    $.post("insertUser.php", objUser, function(obj){
        if(obj['success']){
            //關閉 modal
            $('div#exampleModal').hide();

            //成功訊息
            alert('註冊成功');
            
            //當成功訊息執行同時，等數秒後，執行自訂程式
            setTimeout(function(){
                location.reload();
            }, 3000);
        } else {
            alert(`${obj['info']}`);
        }
        console.log(obj);
    }, 'json')
});

//登入
$('button#btn_login').click(function(event){
    //避免元素的預設事件被觸發
    event.preventDefault();

    //各自將 input 帶入變數中
    let input_email = $('input#email_login');
    let input_pwd = $('input#pwd_login');

    //檢查 email 是否輸入
    if( input_email.val() == '' ) {
        alert('請輸入 E-mail');
        return false;
    }

    //檢查 密碼 是否輸入
    if( input_pwd.val() == '' ) {
        alert('請輸入密碼');
        return false;
    }

    //送出 post 請求，註冊帳號
    let objUser = {
        email: input_email.val(),
        pwd: input_pwd.val()
    };
    $.post("login.php", objUser, function(obj){
        if(obj['success']){
            //關閉 modal
            $('div#exampleModalLogin').hide();

            //成功訊息
            alert('登入成功');
            
            //當成功訊息執行同時，等數秒後，執行自訂程式
            setTimeout(function(){
                location.reload();
            }, 3000);
        } else {
            alert(`${obj['info']}`);
        }
        console.log(obj);
    }, 'json')
});

//登出
$('a#logout').click(function(event){
    //避免元素的預設事件被觸發
    event.preventDefault();

    $.get('logout.php', function(obj){
        if(obj['success']){
            alert('登出成功');

            setTimeout(function(){
                location.href = 'index.php';
            }, 1000);
        }
    });
});

//增加商品數量
$(document).on('click', 'button#btn_plus', function(event){
    let input_qty = $('input#qty');
    input_qty.val( parseInt(input_qty.val()) + 1 );
});

//減少商品數量
$(document).on('click', 'button#btn_minus', function(event){
    let input_qty = $('input#qty');
    if( parseInt(input_qty.val()) - 1 < 1 ) return false;
    input_qty.val( parseInt(input_qty.val()) - 1 );
});

//商品詳細頁面照片 zoom in / out
$(document).on('click', 'button#zoom', function(event){
    $('a[data-lightbox="roadtrip"]').eq(0).click();
});