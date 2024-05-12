<?php require page('includes/header')?>
    <center>
        <h3 class="section-title">Đang phát nhạc</h3>
    </center>
    <section class="content">
        <?php
            $slug = $URL[1] ?? null;
            $query = "select * from songs where slug = :slug limit 1";
            $row = db_query_one($query, ['slug' => $slug]);
        ?>
        <div class="music-card-area">
            <?php if(!empty($row)):?>
                <?php include page('song-full')?>
            <?php endif; ?>
        </div>
    </section>

<?php require page("includes/footer")?>