</div>

    <!-- 浮動視窗 -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">註冊帳號</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
        </div>
    </div>

    <!-- 登入視窗 -->
    <div class="modal fade" id="exampleModalLogin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">登入</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3" id="myForm_login">
                        <div class="col-md-12">
                            <label for="inputEmail4" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email_login" placeholder="請填寫 E-mail">
                        </div>
                        <div class="col-md-12">
                            <label for="inputPassword4" class="form-label">密碼</label>
                            <input type="password" class="form-control" id="pwd_login" placeholder="請輸入密碼">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary" id="btn_login">送出</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    

    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- jQuery UI -->
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- awesome js -->
    <script src="js/awesome.all.min.js"></script>

    <!-- lightbox: https://lokeshdhakar.com/projects/lightbox2/ -->
    <script src="js/lightbox.min.js"></script>

    <!-- 自訂 js -->
    <script src="js/custom.js"></script>
</body>
</html>