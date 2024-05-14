<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=ucfirst($URL[0])?> - Music Website</title>
    <link rel="stylesheet" type="text/css" href="<?=ROOT?>/assets/css/style.css?123">
</head>
<body>
    <header>
        <div class="logo-holder">
            <a href="<?=ROOT?>"><img class="logo" src="<?=ROOT?>/assets/images/MainIcon.png" alt="logo"></a>
        </div>
        <div class="header-div">
            <div class="main-title">
                MARBLE MUSIC
                <div class="searching">
                    <form class="search-bar" action="<?=ROOT?>/search" style="display: flex; align-items: center;">
                        <div class="form-group">
                            <input class="search-field" type="text" placeholder="Tìm kiếm tên bài hát..." name="find">
                            <button class="btn">Tìm kiếm</button>             
                        </div>
                    </form>
                </div>  
            </div>
        </div>
        <div class="main-nav">
            <div class="nav-item"><a href="<?=ROOT?>">Trang chủ</a></div>
            <div class="nav-item"><a href="<?=ROOT?>/music">Bài hát</a></div>
            <div class="nav-item dropdown">
                <a href="#">Danh mục</a>
                <?php
                    $query = "select * from categories order by category asc";
                    $categories = db_query($query);
                ?>
                <div class="dropdown-list">
                    <?php if(!empty($categories)):?>
                        <?php foreach($categories as $cat):?>
                            <div class="nav-item2"><a href="<?=ROOT?>/category/<?=$cat['category']?>"><?=$cat['category']?></a></div>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>
            </div>
            <div class="nav-item"><a href="<?=ROOT?>/artists">Nghệ sĩ</a></div>
            <div class="nav-item dropdown">
                <a href="#">Xin chào, <?=user('username')?></a>
                <div class="dropdown-list hide">
                    <!-- <div class="nav-item""><a href="<?=ROOT?>/admin/users/edit/<?=user('id')?>">Thông tin</a></div> -->
                    <div class="nav-item"><a href="<?=ROOT?>/logout">Đăng xuất</a></div>
                </div>
            </div>
        </div>
    </header>
