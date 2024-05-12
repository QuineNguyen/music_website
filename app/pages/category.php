<?php require page('includes/header')?>
    <h3 class="section-title">Danh mục</h3>

    <section class="content">
        <?php
            $category = $URL[1] ?? null;
            $query = "select * from songs where category_id in (select id from categories where category = :category) order by views desc limit 24";
            $rows = db_query($query, ['category'=>$category]);
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