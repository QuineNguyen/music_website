<?php require page('includes/header')?>
    <?php
        $category = $URL[1] ?? null;
    ?>
    <h3 class="section-title">Danh mục: <?=$category?></h3>

    <section class="content">
        <?php
            $category = $URL[1] ?? null;
            $limit = 5;
            $offset = ($page - 1) * $limit;
            $query = "select * from songs where category_id in (select id from categories where category = :category) order by views desc limit $limit offset $offset";
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

    <div class="mx-2">
		<a href="<?=ROOT?>/category/<?=$category?>?page=<?=$prev_page?>">
			<button class="btn bg-orange" style="margin-bottom: 20px">Trang trước</button>
		</a>
		<a href="<?=ROOT?>/category/<?=$category?>?page=<?=$next_page?>">
			<button class="float-end btn bg-orange" style="margin-bottom: 20px">Trang kế tiếp</button>
		</a>
	</div>

<?php require page("includes/footer")?>