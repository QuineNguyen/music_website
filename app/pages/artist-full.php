<!-- Music Card -->
<div class="music-card-full" style="max-width: 800px">
    <h2 class="card-title"><?=esc($row['name'])?></h2>
    <div style="overflow: hidden";>
        <img src="<?=ROOT?>/<?=$row['image']?>"></a>
    </div>
    <div class="card-content">
        <div><?=esc($row['bio'])?></div>
        <div>Bài hát của nghệ sĩ:</div>
        <div style="display: flex; flex-wrap: wrap; justify-content: center">
            <?php
                $query = "select * from songs where artist_id = :artist_id order by views desc limit 20";
                $songs = db_query($query, ['artist_id' => $row['id']]);
            ?>
            <div class="music-card-area">
                <?php if(!empty($songs)):?>
                    <?php foreach($songs as $row):?>
                        <?php include page('includes/song')?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- End Music Card --> 