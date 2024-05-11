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
<?php require page('includes/login-header')?>;
    
    <section class="content">
        <div class="login-holder">
            <?php if(message()):?>
                <div class="alert"><?=message('', true)?></div>
            <?php endif;?>
            <form method="POST">
                <center><img src="<?=ROOT?>/assets/images/logo.jpg" style="width: 150px; border-radius: 50%; border: solid thin #ccc"></center>
                <h2>Đăng nhập admin</h2>
                <input value="<?=set_value('email')?>" class="my-1 form-control" type="email" name="email" placeholder="Email">
                <input value="<?=set_value('password')?>" class="my-1 form-control" type="password" name="password" placeholder="Mật khẩu">
                <button class="my-1 btn bg-blue">Đăng nhập</button>
            </form>
        </div>
    </section>

<?php require page('includes/login-footer')?>;