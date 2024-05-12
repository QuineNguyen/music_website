<?php 


	if($action == 'add')
	{

		if($_SERVER['REQUEST_METHOD'] == "POST")
		{

			$errors = [];

			//data validation
			if(empty($_POST['title']))
			{
				$errors['title'] = "Bắt buộc có tên bài hát";
			}else
			if(!preg_match("/^[\p{L}\d\s \.\&\-]+$/u", $_POST['title'])){
				$errors['title'] = "Tên bài hát chỉ chứa ký tự & dấu cách";
			}

			if(empty($_POST['category_id']))
			{
				$errors['category_id'] = "Bắt buộc có danh mục";
			}

			if(empty($_POST['artist_id']))
			{
				$errors['artist_id'] = "Bắt buộc có nghệ sĩ";
			}
			//image
			if(!empty($_FILES['image']['name']))
			{

				$folder = "uploads/";
				if(!file_exists($folder))
				{
					mkdir($folder,0777,true);
					file_put_contents($folder."index.php", "");
				}

				$allowed = ['image/jpeg','image/png', 'image/jpg'];
				if($_FILES['image']['error'] == 0 && in_array($_FILES['image']['type'], $allowed))
				{
					
					$destination_image = $folder. $_FILES['image']['name'];

					move_uploaded_file($_FILES['image']['tmp_name'], $destination_image);

				}else{
					$errors['image'] = "Ảnh không hợp lệ. Những định dạng ảnh được chấp nhận: ". implode(",", $allowed);
				}
				

			}else{
				$errors['image'] = "Bắt buộc có ảnh";
			}

			//audio file
			if(!empty($_FILES['file']['name']))
			{

				$folder = "uploads/";
				if(!file_exists($folder))
				{
					mkdir($folder,0777,true);
					file_put_contents($folder."index.php", "");
				}

				$allowed = ['audio/mpeg'];
				if($_FILES['file']['error'] == 0 && in_array($_FILES['file']['type'], $allowed))
				{
					
					$destination_file = $folder. $_FILES['file']['name'];

					move_uploaded_file($_FILES['file']['tmp_name'], $destination_file);

				}else{
					$errors['file'] = "File không hợp lệ. Những định dạng file được chấp nhận: ". implode(",", $allowed);
				}
				

			}else{
				$errors['file'] = "Bắt buộc có file audio";
			}
 
			if(empty($errors))
			{

				$values = [];
				$values['title'] 	= trim($_POST['title']);
				$values['category_id'] 	= trim($_POST['category_id']);
				$values['artist_id'] 	= trim($_POST['artist_id']);
				$values['image'] 	= $destination_image;
				$values['file'] 	= $destination_file;
				$values['user_id'] 	= user('id');
				$values['date']     = date("Y-m-d H:i:s");
				$values['views']    = 0;
				$values['slug']    	= str_to_url($values['title']);

				$query = "insert into songs (title,image,file,user_id,category_id,artist_id,date,views,slug) values (:title,:image,:file,:user_id,:category_id,:artist_id,:date,:views,:slug)";
				db_query($query,$values);

				message("Thêm bài hát thành công");
				redirect('admin/songs');
			}
		}
	}else
	if($action == 'edit')
	{

		$query = "select * from songs where id = :id limit 1";
  		$row = db_query_one($query,['id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		{

			//data validation
			if(empty($_POST['title']))
			{
				$errors['title'] = "Bắt buộc có tên bài hát";
			}else
			if(!preg_match("/^[\p{L}\d\s \.\&\-]+$/u", $_POST['title'])){
				$errors['title'] = "Tên bài hát chỉ chứa ký tự & dấu cách";
			}

			if(empty($_POST['category_id']))
			{
				$errors['category_id'] = "Bắt buộc có danh mục";
			}

			if(empty($_POST['artist_id']))
			{
				$errors['artist_id'] = "Bắt buộc có nghệ sĩ";
			}

 			//image
			if(!empty($_FILES['image']['name']))
			{

				$folder = "uploads/";
				if(!file_exists($folder))
				{
					mkdir($folder,0777,true);
					file_put_contents($folder."index.php", "");
				}

				$allowed = ['image/jpeg','image/png', 'image/jpg'];
				if($_FILES['image']['error'] == 0 && in_array($_FILES['image']['type'], $allowed))
				{
					
					$destination_image = $folder. $_FILES['image']['name'];

					move_uploaded_file($_FILES['image']['tmp_name'], $destination_image);
					
					//delete old image
					if(file_exists($row['image']))
					{
						unlink($row['image']);
					}


				}else{
					$errors['image'] = "Ảnh không hợp lệ. Những định dạng ảnh được chấp nhận: ". implode(",", $allowed);
				}

			}

			//audio file
			if(!empty($_FILES['file']['name']))
			{

				$folder = "uploads/";
				if(!file_exists($folder))
				{
					mkdir($folder,0777,true);
					file_put_contents($folder."index.php", "");
				}

				$allowed = ['audio/mpeg'];
				if($_FILES['file']['error'] == 0 && in_array($_FILES['file']['type'], $allowed))
				{
					
					$destination_file = $folder. $_FILES['file']['name'];

					move_uploaded_file($_FILES['file']['tmp_name'], $destination_file);

					//delete old audio file
					if(file_exists($row['file']))
					{
						unlink($row['file']);
					}

				}else{
					$errors['name'] = "File không hợp lệ. Những định dạng file được chấp nhận: ". implode(",", $allowed);
				}
				

			}

			if(empty($errors))
			{

				$values = [];
				$values['title'] 	= trim($_POST['title']);
				$values['category_id'] 	= trim($_POST['category_id']);
				$values['artist_id'] 	= trim($_POST['artist_id']);
				$values['user_id'] 	= user('id');
				$values['id'] 		= $id;

				$query = "update songs set title = :title,user_id = :user_id,category_id = :category_id,artist_id = :artist_id";
				
				if(!empty($destination_image)){
					$query .= ", image = :image";
					$values['image'] 	= $destination_image;
				}

				if(!empty($destination_file)){
					$query .= ", file = :file";
					$values['file'] 	= $destination_file;
				}

				$query .= " where id = :id limit 1";
				db_query($query,$values);

				message("Cập nhật bài hát thành công");
				redirect('admin/songs');
			}
		}
	}else
	if($action == 'delete')
	{

		$query = "select * from songs where id = :id limit 1";
  		$row = db_query_one($query,['id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		{

			$errors = [];
 
			if(empty($errors))
			{
 
				$values = [];
				$values['id'] 		= $id;

				$query = "delete from songs where id = :id limit 1";
				db_query($query,$values);

				//delete old image
				if(file_exists($row['image']))
				{
					unlink($row['image']);
				}

				//delete old audio file
				if(file_exists($row['file']))
				{
					unlink($row['file']);
				}

				message("Xóa bài hát thành công");
				redirect('admin/songs');
			}
		}
	}
	

?>

<?php require page('includes/admin-header')?>

	<section class="admin-content" style="min-height: 200px;">
  
  		<?php if($action == 'add'):?>
  			
  			<div style="max-width: 500px;margin: auto;">
	  			<form method="post" enctype="multipart/form-data">

	  				<h3>Thêm bài hát</h3>

	  				<input name="title" class="form-control my-1" value="<?=set_value('title')?>" type="text" title="title" placeholder="Tên bài hát">
	  				<?php if(!empty($errors['title'])):?>
	  					<small class="error"><?=$errors['title']?></small>
	  				<?php endif;?>

					<?php
						$query = "select * from categories order by category asc";
						$categories = db_query($query);
					?>
					<select name="category_id" class="form-control my-1">
                        <option value="">--Chọn danh mục--</option>
						<?php if(!empty($categories)):?>
							<?php foreach($categories as $cat):?>
								<option <?=set_select('category_id', $cat['id'])?> value="<?=$cat['id']?>"><?=$cat['category']?></option>
							<?php endforeach;?>
						<?php endif;?>
                    </select>
                    <?php if(!empty($errors['category_id'])):?>
                        <small class="error"><?=$errors['category_id']?></small>
                    <?php endif;?>

					<?php
						$query = "select * from artists order by name asc";
						$artists = db_query($query);
					?>
					<select name="artist_id" class="form-control my-1">
                        <option value="">--Chọn nghệ sĩ--</option>
						<?php if(!empty($artists)):?>
							<?php foreach($artists as $cat):?>
								<option <?=set_select('artist_id', $cat['id'])?> value="<?=$cat['id']?>"><?=$cat['name']?></option>
							<?php endforeach;?>
						<?php endif;?>
                    </select>
                    <?php if(!empty($errors['artist_id'])):?>
                        <small class="error"><?=$errors['artist_id']?></small>
                    <?php endif;?>

					<div class="my-1">Ảnh đính kèm:</div>
					<div class="form-control my-1">
						<input type="file" name="image" style="margin-left: 10px">
						<?php if(!empty($errors['image'])):?>
							<small class="error"><?=$errors['image']?></small>
						<?php endif;?>
					</div>

					<div class="my-1">Audio đính kèm:</div>
					<div class="form-control my-1">
						<input type="file" name="file" style="margin-left: 10px">
						<?php if(!empty($errors['file'])):?>
							<small class="error"><?=$errors['file']?></small>
						<?php endif;?>
					</div>
 
	  				<button class="btn bg-orange">Lưu</button>
	  				<a href="<?=ROOT?>/admin/songs">
	  					<button type="button" class="float-end btn">Quay lại</button>
	  				</a>
	  			</form>
	  		</div>

  		<?php elseif($action == 'edit'):?>
 
  			<div style="max-width: 500px;margin: auto;">
	  			<form method="post" enctype="multipart/form-data">
	  				<h3>Cập nhật bài hát</h3>

	  				<?php if(!empty($row)):?>
					
					<input name="title" class="form-control my-1" value="<?=set_value('title', $row['title'])?>" type="text" title="title" placeholder="Tên bài hát">
	  				<?php if(!empty($errors['title'])):?>
	  					<small class="error"><?=$errors['title']?></small>
	  				<?php endif;?>

					<?php
						$query = "select * from categories order by category asc";
						$categories = db_query($query);
					?>
					<select name="category_id" class="form-control my-1">
                        <option value="">--Chọn danh mục--</option>
						<?php if(!empty($categories)):?>
							<?php foreach($categories as $cat):?>
								<option <?=set_select('category_id', $cat['id'])?> value="<?=$cat['id']?>"><?=$cat['category']?></option>
							<?php endforeach;?>
						<?php endif;?>
                    </select>
                    <?php if(!empty($errors['category_id'])):?>
                        <small class="error"><?=$errors['category_id']?></small>
                    <?php endif;?>

					<?php
						$query = "select * from artists order by name asc";
						$artists = db_query($query);
					?>
					<select name="artist_id" class="form-control my-1">
                        <option value="">--Chọn nghệ sĩ--</option>
						<?php if(!empty($artists)):?>
							<?php foreach($artists as $cat):?>
								<option <?=set_select('artist_id', $cat['id'])?> value="<?=$cat['id']?>"><?=$cat['name']?></option>
							<?php endforeach;?>
						<?php endif;?>
                    </select>
                    <?php if(!empty($errors['artist_id'])):?>
                        <small class="error"><?=$errors['artist_id']?></small>
                    <?php endif;?>

					<div style="display: flex; justify-content: center">
						<img src="<?=ROOT?>/<?=$row['image']?>" style="width:200px;height: 200px;object-fit: cover;">
					</div>
					<div class="my-1">Ảnh đính kèm:</div>
					<div class="form-control my-1">
						<input type="file" name="image" style="margin-left: 10px">
						<?php if(!empty($errors['image'])):?>
							<small class="error"><?=$errors['image']?></small>
						<?php endif;?>
					</div>

					<div class="my-1">Audio đính kèm:</div>
					<div class="form-control my-1">
						<input type="file" name="file" style="margin-left: 10px">
						<?php if(!empty($errors['file'])):?>
							<small class="error"><?=$errors['file']?></small>
						<?php endif;?>
					</div>

	  				<button class="btn bg-orange">Lưu</button>
	  				<a href="<?=ROOT?>/admin/songs">
	  					<button type="button" class="float-end btn">Quay lại</button>
	  				</a>

	  				<?php else:?>
	  					<div class="alert">Không tìm thấy bản ghi</div>
	  					<a href="<?=ROOT?>/admin/songs">
		  					<button type="button" class="float-end btn">Quay lại</button>
		  				</a>
	  				<?php endif;?>

	  			</form>
	  		</div>

  		<?php elseif($action == 'delete'):?>

  			<div style="max-width: 500px;margin: auto;">
	  			<form method="post">
	  				<h3>Xóa bài hát</h3>

	  				<?php if(!empty($row)):?>

	  				<div class="form-control my-1" ><?=set_value('title',$row['title'])?></div>
	  				<?php if(!empty($errors['title'])):?>
	  					<small class="error"><?=$errors['title']?></small>
	  				<?php endif;?>

	  				<button class="btn bg-red">Xóa</button>
	  				<a href="<?=ROOT?>/admin/songs">
	  					<button type="button" class="float-end btn">Quay lại</button>
	  				</a>

	  				<?php else:?>
	  					<div class="alert">Không tìm thấy bản ghi</div>
	  					<a href="<?=ROOT?>/admin/songs">
		  					<button type="button" class="float-end btn">Quay lại</button>
		  				</a>
	  				<?php endif;?>

	  			</form>
	  		</div>

  		<?php else:?>

  			<?php 
				$limit = 5;
				$offset = ($page - 1) * $limit;
  				$query = "select * from songs order by id desc limit $limit offset $offset";
  				$rows = db_query($query);

  			?>
  			<h3>Danh sách bài hát
  				<a href="<?=ROOT?>/admin/songs/add">
  					<button class="float-end btn bg-purple">Thêm bài hát mới</button>
  				</a>
  			</h3>

  			<table class="table">
  				
  				<tr>
  					<th>ID</th>
  					<th>Tên</th>
  					<th>Ảnh</th>
  					<th>Danh mục</th>
  					<th>Nghệ sĩ</th>
  					<th>Audio</th>
  					<th>Thao tác</th>
   				</tr>

  				<?php if(!empty($rows)):?>
	  				<?php foreach($rows as $row):?>
		  				<tr>
		  					<td><?=$row['id']?></td>
		  					<td><?=$row['title']?></td>
		  					<td><img src="<?=ROOT?>/<?=$row['image']?>" style="width:100px;height: 100px;object-fit: cover;"></td>
		  					<td><?=get_category($row['category_id'])?></td>
		  					<td><?=get_artist($row['artist_id'])?></td>
							<td>
								<audio controls>
									<source src="<?=ROOT?>/<?=$row['file']?>" type="audio/mpeg">
								</audio>
							</td>
		  					<td>
		  						<a href="<?=ROOT?>/admin/songs/edit/<?=$row['id']?>">
		  							<img class="bi" src="<?=ROOT?>/assets/icons/pencil-square.svg">
		  						</a>
		  						<a href="<?=ROOT?>/admin/songs/delete/<?=$row['id']?>">
		  							<img class="bi" src="<?=ROOT?>/assets/icons/trash3.svg">
		  						</a>
		  					</td>
		  				</tr>
	  				<?php endforeach;?>
  				<?php endif;?>

  			</table>
  		<?php endif;?>

	<div class="mx-2">
		<a href="<?=ROOT?>/admin/songs?page=<?=$prev_page?>">
			<button class="btn bg-orange" style="margin: 20px">Trang trước</button>
		</a>
		<a href="<?=ROOT?>/admin/songs?page=<?=$next_page?>">
			<button class="float-end btn bg-orange" style="margin: 20px">Trang kế tiếp</button>
		</a>
	</div>

	</section>

<?php require page('includes/admin-footer')?>