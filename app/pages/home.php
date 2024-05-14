<?php require page('includes/header')?>
    <section>
        <img class="alanwalker" src="<?=ROOT?>/assets/images/umf-bg.jpg">
    </section>

    <h3 class="section-title">Xu hướng</h3>

    <section class="content">
        <?php
            $limit = 5;
            $offset = ($page - 1) * $limit;
            $rows = db_query("select * from songs order by id desc limit $limit offset $offset");
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

    <div class="mx-2">
		<a href="<?=ROOT?>/?page=<?=$prev_page?>">
			<button class="btn bg-orange" style="margin-bottom: 20px">Trang trước</button>
		</a>
		<a href="<?=ROOT?>/?page=<?=$next_page?>">
			<button class="float-end btn bg-orange" style="margin-bottom: 20px">Trang kế tiếp</button>
		</a>
	</div>

<?php require page("includes/footer")?>