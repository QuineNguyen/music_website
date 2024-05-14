<?php require page('includes/header')?>
    <h3 class="section-title">Kết quả tìm kiếm cho: <?=$_GET['find']?></h3>

    <section class="content">
        <?php
            $title = $_GET['find'] ?? null;
            if(!empty($title))
            {
                $title = "%$title%";
                $limit = 5;
                $offset = ($page - 1) * $limit;
                $query = "select * from songs where title like :title order by views desc limit $limit offset $offset";
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

    <div class="mx-2">
		<a href="<?=ROOT?>/music?page=<?=$prev_page?>">
			<button class="btn bg-orange" style="margin-bottom: 20px">Trang trước</button>
		</a>
		<a href="<?=ROOT?>/music?page=<?=$next_page?>">
			<button class="float-end btn bg-orange" style="margin-bottom: 20px">Trang kế tiếp</button>
		</a>
	</div>

<?php require page("includes/footer")?>