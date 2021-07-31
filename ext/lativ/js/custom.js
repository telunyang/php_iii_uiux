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
            }, 1000);
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
        console.log(obj);
    }, 'json');
});

//增加商品數量
$('button#btn_plus').click(function(event){
    let input_qty = $('input#qty');
    input_qty.val( parseInt(input_qty.val()) + 1 );
});

//減少商品數量
$('button#btn_minus').click(function(event){
    let input_qty = $('input#qty');
    if( parseInt(input_qty.val()) - 1 < 1 ) return false;
    input_qty.val( parseInt(input_qty.val()) - 1 );
});

//增加商品數量(購物車)
$('button.btn_plus').click(function(event){
    //計算數量
    let btn = $(this);
    let index = btn.attr('data-index');
    let prod_price = btn.attr('data-prod-price');
    let input_qty = $(`input.qty[data-index="${index}"]`);
    input_qty.val( parseInt(input_qty.val()) + 1 );

    //修改商品金額
    $(`span[data-index="${index}"]`).text( input_qty.val() * prod_price );

    //更新總計
    let total = 0;
    $(`input.qty`).each(function(index, element){
        total += ( parseInt($(element).val()) * parseInt($(element).attr('data-prod-price')) );
    });
    $('span#total').text(total);
});

//減少商品數量(購物車)
$('button.btn_minus').click(function(event){
    let btn = $(this);
    let index = btn.attr('data-index');
    let prod_price = btn.attr('data-prod-price');
    let input_qty = $(`input.qty[data-index="${index}"]`);
    if( parseInt(input_qty.val()) - 1 < 1 ) return false;
    input_qty.val( parseInt(input_qty.val()) - 1 );

    //修改商品金額
    $(`span[data-index="${index}"]`).text( input_qty.val() * prod_price );

    //更新總計
    let total = 0;
    $(`input.qty`).each(function(index, element){
        total += ( parseInt($(element).val()) * parseInt($(element).attr('data-prod-price')) );
    });
    $('span#total').text(total);
});

//商品詳細頁面照片 zoom in / out
$('button#zoom').click(function(event){
    $('a[data-lightbox="roadtrip"]').eq(0).click();
});

//加入商品至購物車
$('button#btn_set_cart').click(function(event){
    //取得 button 的 jQuery 物件
    let btn = $(this);

    //送出 post 請求，加入購物車
    let objProduct = {
        prod_id: btn.attr('data-prod-id'),
        prod_name: btn.attr('data-prod-name'),
        prod_thumbnail: btn.attr('data-prod-thumbnail'),
        prod_price: btn.attr('data-prod-price'),
        prod_color: $('select#prod_color > option:selected').val(),
        prod_qty: $('input#qty').val()
    };
    $.post("setCart.php", objProduct, function(obj){
        if(obj['success']){
            //成功訊息
            alert('加入購物車成功');

            //將網頁上的購物車商品數量更新
            $('span#count_products').text(obj['count_products']);
        }
        console.log(obj);
    }, 'json');
});

//刪除購物車內商品
$('a.delete').click(function(event){
    //避免元素的預設事件被觸發
    event.preventDefault();

    //取得選定刪除的購物車索引
    let index = $(this).attr('data-index');

    $.get("deleteItem.php", {index: index}, function(obj){
        if(obj['success']){
            location.reload();
        } else {
            alert(`${obj['info']}`);
        }
        console.log(obj);
    }, 'json');
});

//確認優惠代碼是否可以使用
$('a#check_coupon_code').click(function(event){
    //避免元素的預設事件被觸發
    event.preventDefault();

    //取得優惠代碼
    let code = $('input[name="coupon_code"]').val();

    //如果代碼為空，就不往下執行
    if(code == '') {
        alert('請輸入優惠代碼');
        return false;
    }

    $.post("getCoupon.php", {code: code}, function(obj){
        if(obj['success']){
            alert(`${obj['info']}`);
        } else {
            alert(`${obj['info']}`);
        }
        console.log(obj);
    }, 'json');
});

//商品追蹤
$('button#btn_follow').click(function(event){
    //避免元素的預設事件被觸發
    event.preventDefault();

    //取得 button 的 jQuery 物件
    let btn = $(this);

    //送出 post 請求，加入購物車
    let objProduct = {
        prod_id: btn.attr('data-prod-id'),
    };
    $.post("insertProductsFollow.php", objProduct, function(obj){
        if(obj['success']){
            //成功訊息
            alert('商品追蹤成功');
        } else {
            alert(`${obj['info']}`);
        }
        console.log(obj);
    }, 'json');
});