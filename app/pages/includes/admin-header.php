<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Nghe Nhạc</title>
    <link rel="stylesheet" type="text/css" href="<?=ROOT?>/assets/css/style.css?2324">
</head>
<body>
    <style>
        header a {
            color: white;
        }
        .dropdown-list {
            background-color: #444;
        }
    </style>
    <header style="background-color: #3e344e; color: white;">
        <div class="logo-holder">
            <a href="<?=ROOT?>/admin"><img class="logo" src="<?=ROOT?>/assets/images/MainIcon.png" alt="logo"></a>
        </div>
        <div class="header-div">
            <div class="main-title">
                <h2>Trang Chủ Admin</h2>
                <div class="socials">
                    
                </div>
            </div>
            <div class="main-nav">
                <div class="nav-item"><a href="<?=ROOT?>/admin">Trang chủ</a></div>
                <div class="nav-item"><a href="<?=ROOT?>/admin/users">Tài khoản</a></div>
                <div class="nav-item"><a href="<?=ROOT?>/admin/songs">Bài hát</a></div>
                <div class="nav-item"><a href="<?=ROOT?>/admin/categories">Danh mục</a></div>
                <div class="nav-item"><a href="<?=ROOT?>/admin/artists">Nghệ sĩ</a></div>
                <div class="nav-item dropdown">
                    <a href="#">Xin chào, <?=user('username')?></a>
                    <div class="dropdown-list">
                        <div class="nav-item"><a href="<?=ROOT?>/profile" style="color: white">Về chúng tôi</a></div>
                        <div class="nav-item"><a href="<?=ROOT?>/logout" style="color: white">Đăng xuất</a></div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <?php if(message()):?>
        <div class="alert"><?=message('', true)?></div>
    <?php endif;?>