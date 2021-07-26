<?php require_once 'db.inc.php' ?>
<?php session_start() ?>
<?php require_once 'tpl/head.inc.php' ?>

<!-- 註冊欄位 -->
<div class="row">
    <form class="row g-3" id="myForm">
        <div class="col-md-6">
            <label for="inputEmail4" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" placeholder="請填寫 E-mail">
        </div>
        <div class="col-md-6">
            <label for="inputPassword4" class="form-label">密碼</label>
            <input type="password" class="form-control" id="pwd" placeholder="請輸入密碼">
        </div>
        <div class="col-md-6">
            <label for="inputEmail4" class="form-label">姓名</label>
            <input type="text" class="form-control" id="name" placeholder="請輸入姓名">
        </div>
        <div class="col-md-6">
            <label for="inputPassword4" class="form-label">生日</label>
            <input type="text" class="form-control" id="birthdate" placeholder="請填寫生日">
        </div>
        <div class="col-12">
            <label for="inputAddress" class="form-label">地址</label>
            <input type="text" class="form-control" id="address" placeholder="請填寫地址">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary" id="btn_register">註冊</button>
        </div>
    </form>
</div>
</div>

    
<?php require_once 'tpl/foot.inc.php' ?> 