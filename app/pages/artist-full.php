<!-- Music Card -->
<div class="music-card-full" style="width: 400px;">
    <h2 class="card-title" style="text-align: center"><?=esc($row['name'])?></h2>
    <div style="overflow: hidden; text-align: center">
        <img src="<?=ROOT?>/<?=$row['image']?>" style="border-radius: 10px; width: 320px; height: 320px"></a>
    </div>
    <div class="card-content">
        <div><?=esc($row['bio'])?></div>
        <div class="content-title" style="text-align: center; margin-top: 20px">Bài hát của nghệ sĩ:</div>
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