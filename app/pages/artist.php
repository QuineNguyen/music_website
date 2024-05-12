<?php require page('includes/header')?>
    <center>
        <h3 class="section-title">Thông tin về nghệ sĩ</h3>
    </center>
    <section class="content">
        <?php
            $id = $URL[1] ?? null;
            $query = "select * from artists where id = :id limit 1";
            $row = db_query_one($query, ['id' => $id]);
        ?>
        <div class="music-card-area">
            <?php if(!empty($row)):?>
                <?php include page('artist-full')?>
            <?php endif; ?>
        </div>
    </section>

<?php require page("includes/footer")?>