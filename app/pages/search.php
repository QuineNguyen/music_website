<?php require page('includes/header')?>
    <h3 class="section-title">Kết quả tìm kiếm cho: <?=$_GET['find']?></h3>

    <section class="content">
        <?php
            $title = $_GET['find'] ?? null;
            if(!empty($title))
            {
                $title = "%$title%";
                $query = "select * from songs where title like :title order by views desc limit 24";
                $rows = db_query($query, ['title'=>$title]);
            }
        ?>
        <div class="music-card-area">
            <?php if(!empty($rows)):?>
                <?php foreach($rows as $row):?>
                    <?php include page('includes/song')?>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="m-2">Không tìm thấy bài hát</div>
            <?php endif; ?>
        </div>
    </section>

<?php require page("includes/footer")?>