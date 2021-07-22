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