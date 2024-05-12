<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $errors = [];
        $values = [];
        $values['email'] = trim($_POST['email']);
        $query = "select * from users where email = :email limit 1";
        $row = db_query_one($query,$values);

        if(!empty($row))
        {
            if(password_verify($_POST['password'], $row['password']))
            {
                authenticate($row);
                message("Đăng nhập thành công!!");
                redirect('admin');
            }
        }
        message("Sai email hoặc mật khẩu");
    }
?>
<?php require page('includes/header')?>
    
    <section class="content login-content">     
        <div class="login-holder">
            <h1>Âm nhạc dành cho bạn !</h1>
            <form class="login-form" method="post">
                <h2>Đăng nhập</h2>
                <label class="login-label">Email: </label>
                <br>
                <input class="my-1 form-control" type="email" name="email" placeholder="example@email.com">
                <br>
                <label class="login-label">Mật khẩu: </label>
                <br>
                <input class="my-1 form-control" type="password" name="password">
                <br>
                <button class="my-1 btn bg-blue login-btn">Đăng nhập</button>
            </form>
        </div>
    </section>

<?php require page('includes/footer')?>