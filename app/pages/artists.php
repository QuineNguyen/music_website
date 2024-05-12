<?php require page('includes/header')?>
    <h3 class="section-title">Nghe nhạc</h3>

    <section class="content">
        <?php
            $rows = db_query("select * from artists order by id desc limit 24");
        ?>
        <div class="music-card-area">
            <?php if(!empty($rows)):?>
                <?php foreach($rows as $row):?>
                    <?php include page('includes/artist')?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

<?php require page("includes/footer")?>