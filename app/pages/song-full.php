<?php
    db_query("update songs set views = views + 1 where id = :id limit 1", ['id'=>$row['id']]);
?>
<!-- Music Card -->
<div class="music-card-full" style="max-width: 800px">
    <h2 class="card-title" style="text-align: center"><?=esc($row['title'])?></h2>
    <div class="card-subtitle" style="text-align: center; margin-bottom: 10px">Thể hiện bởi: <?=esc(get_artist($row['artist_id']))?></div>
    <div style="overflow: hidden; text-align: center">
        <a href="<?=ROOT?>/song/<?=$row['slug']?>"><img src="<?=ROOT?>/<?=$row['image']?>" style="border-radius: 10px; width: 280px; height: 320px"></a>
    </div>
    <div class="card-content">
        <audio controls style="width: 100%">
            <source src="<?=ROOT?>/<?=$row['file']?>" type="audio/mpeg">
        </audio>
        <div class="" style="text-align: center">Lượt nghe: <?=$row['views']?></div>
        <div class="" style="text-align: center">Phát hành: <?=get_date($row['date'])?></div>
        <div class="download-btn" style="text-align: center; margin-top: 20px">
            <a href="<?=ROOT?>/download/<?=$row['slug']?>">
                <button class="btn bg-purple" style="width: 100px;">Tải về</button>
            </a>
        </div>
        
    </div>
</div>
<!-- End Music Card --> 