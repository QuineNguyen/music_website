<?php require page('includes/header')?>
    <section>
        <img class="alanwalker" src="<?=ROOT?>/assets/images/AlanWalker.jpg">
    </section>

    <h3 class="section-title">Xu hướng</h3>

    <section class="content">
        <?php
            $rows = db_query("select * from songs order by id desc limit 16");
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