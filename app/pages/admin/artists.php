<?php 


	if($action == 'add')
	{

		if($_SERVER['REQUEST_METHOD'] == "POST")
		{

			$errors = [];

			//data validation
			if(empty($_POST['name']))
			{
				$errors['name'] = "Bắt buộc có tên nghệ sĩ";
			}else
			if(!preg_match("/^[\p{L}\s]+$/u", $_POST['name'])){
				$errors['name'] = "Tên nghệ sĩ chỉ chứa ký tự & dấu cách";
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
					
					$destination = $folder. $_FILES['image']['name'];

					move_uploaded_file($_FILES['image']['tmp_name'], $destination);

				}else{
					$errors['name'] = "Ảnh không hợp lệ. Những định dạng ảnh được chấp nhận: ". implode(",", $allowed);
				}
				

			}else{
				$errors['name'] = "Bắt buộc có ảnh";
			}
 
			if(empty($errors))
			{

				$values = [];
				$values['name'] = trim($_POST['name']);
				$values['bio'] = trim($_POST['bio']);
				$values['image'] 	= $destination;
				$values['user_id'] 	= user('id');

				$query = "insert into artists (name,image,user_id,bio) values (:name,:image,:user_id,:bio)";
				db_query($query,$values);

				message("Tạo thông tin nghệ sĩ thành công");
				redirect('admin/artists');
			}
		}
	}else
	if($action == 'edit')
	{

		$query = "select * from artists where id = :id limit 1";
  		$row = db_query_one($query,['id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		{

			$errors = [];

			//data validation
			if(empty($_POST['name']))
			{
				$errors['name'] = "Bắt buộc có tên nghệ sĩ";
			}else
			if(!preg_match("/^[\p{L}\s]+$/u", $_POST['name'])){
				$errors['name'] = "Tên nghệ sĩ chỉ chứa ký tự & dấu cách";
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
					
					$destination = $folder. $_FILES['image']['name'];

					move_uploaded_file($_FILES['image']['tmp_name'], $destination);
					
					//delete old file
					if(file_exists($row['image']))
					{
						unlink($row['image']);
					}

				}else{
					$errors['name'] = "Ảnh không hợp lệ. Những định dạng ảnh được chấp nhận: ". implode(",", $allowed);
				}

			}

			if(empty($errors))
			{

				$values = [];
				$values['name'] = trim($_POST['name']);
				$values['bio'] = trim($_POST['bio']);
				$values['user_id'] 	= user('id');
				$values['id'] 		= $id;

				$query = "update artists set name = :name,bio = :bio,user_id =:user_id where id = :id limit 1";
				
				if(!empty($destination)){
					$query = "update artists set name = :name,bio = :bio,user_id =:user_id, image = :image where id = :id limit 1";
					$values['image'] 	= $destination;
				}

				db_query($query,$values);

				message("Cập nhật thông tin nghệ sĩ thành công");
				redirect('admin/artists');
			}
		}
	}else
	if($action == 'delete')
	{

		$query = "select * from artists where id = :id limit 1";
  		$row = db_query_one($query,['id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		{

			$errors = [];
 
			if(empty($errors))
			{
 
				$values = [];
				$values['id'] 		= $id;

				$query = "delete from artists where id = :id limit 1";
				db_query($query,$values);

				//delete image
				if(file_exists($row['image']))
				{
					unlink($row['image']);
				}

				message("Xóa thông tin nghệ sĩ thành công");
				redirect('admin/artists');
			}
		}
	}
	

?>

<?php require page('includes/admin-header')?>

	<section class="admin-content" style="min-height: 200px;">
  
  		<?php if($action == 'add'):?>
  			
  			<div style="max-width: 500px;margin: auto;">
	  			<form method="post" enctype="multipart/form-data">

	  				<h3>Thêm thông tin nghệ sĩ</h3>

	  				<input class="form-control my-1" value="<?=set_value('name')?>" type="text" name="name" placeholder="Tên nghệ sĩ">
	  				<?php if(!empty($errors['name'])):?>
	  					<small class="error"><?=$errors['name']?></small>
	  				<?php endif;?>
 
 					<label>Ảnh đính kèm:</label>
					<div class="form-control my-1">
						<input type="file" name="image" style="margin-left: 10px">
					</div>

	  				<label>Giới thiệu về nghệ sĩ:</label>
	  				<textarea rows="10" class="form-control my-1" name="bio"><?=set_value('bio')?></textarea>

	  				<?php if(!empty($errors['image'])):?>
	  					<small class="error"><?=$errors['image']?></small>
	  				<?php endif;?>
 
	  				<button class="btn bg-orange">Lưu</button>
	  				<a href="<?=ROOT?>/admin/artists">
	  					<button type="button" class="float-end btn">Quay lại</button>
	  				</a>
	  			</form>
	  		</div>

  		<?php elseif($action == 'edit'):?>
 
  			<div style="max-width: 500px;margin: auto;">
	  			<form method="post" enctype="multipart/form-data">
	  				<h3>Cập nhật thông tin nghệ sĩ</h3>

	  				<?php if(!empty($row)):?>

	  				<input class="form-control my-1" value="<?=set_value('name',$row['name'])?>" type="text" name="name" placeholder="Tên nghệ sĩ">
	  				<?php if(!empty($errors['name'])):?>
	  					<small class="error"><?=$errors['name']?></small>
	  				<?php endif;?>

	  				<div style="display: flex; justify-content: center">
						<img src="<?=ROOT?>/<?=$row['image']?>" style="width:200px;height: 200px;object-fit: cover;">
					</div>
	  				<div class="my-1">Ảnh đính kèm:</div>
	  				<div class="form-control my-1">
						<input type="file" name="image" style="margin-left: 10px">
					</div>

	  				<label>Giới thiệu về nghệ sĩ:</label>
	  				<textarea rows="10" class="form-control my-1" name="bio" style="border-radius: 10px"><?=set_value('bio',$row['bio'])?></textarea>

	  				<button class="btn bg-orange">Lưu</button>
	  				<a href="<?=ROOT?>/admin/artists">
	  					<button type="button" class="float-end btn">Quay lại</button>
	  				</a>

	  				<?php else:?>
	  					<div class="alert">Không tìm thấy bản ghi</div>
	  					<a href="<?=ROOT?>/admin/artists">
		  					<button type="button" class="float-end btn">Quay lại</button>
		  				</a>
	  				<?php endif;?>

	  			</form>
	  		</div>

  		<?php elseif($action == 'delete'):?>

  			<div style="max-width: 500px;margin: auto;">
	  			<form method="post">
	  				<h3>Xóa thông tin nghệ sĩ</h3>

	  				<?php if(!empty($row)):?>

	  				<div class="form-control my-1" ><?=set_value('name',$row['name'])?></div>
	  				<?php if(!empty($errors['name'])):?>
	  					<small class="error"><?=$errors['name']?></small>
	  				<?php endif;?>

	  				<button class="btn bg-red">Xóa</button>
	  				<a href="<?=ROOT?>/admin/artists">
	  					<button type="button" class="float-end btn">Quay lại</button>
	  				</a>

	  				<?php else:?>
	  					<div class="alert">Không tìm thấy bản ghi</div>
	  					<a href="<?=ROOT?>/admin/artists">
		  					<button type="button" class="float-end btn">Quay lại</button>
		  				</a>
	  				<?php endif;?>

	  			</form>
	  		</div>

  		<?php else:?>

  			<?php 
				$limit = 5;
				$offset = ($page - 1) * $limit;
  				$query = "select * from artists order by id desc limit $limit offset $offset";
  				$rows = db_query($query);

  			?>
  			<h3>Danh sách nghệ sĩ
  				<a href="<?=ROOT?>/admin/artists/add">
  					<button class="float-end btn bg-purple">Thêm nghệ sĩ mới</button>
  				</a>
  			</h3>

  			<table class="table">
  				
  				<tr>
  					<th>ID</th>
  					<th>Nghệ sĩ</th>
  					<th>Ảnh</th>
  					<th>Thao tác</th>
   				</tr>

  				<?php if(!empty($rows)):?>
	  				<?php foreach($rows as $row):?>
		  				<tr>
		  					<td><?=$row['id']?></td>
		  					<td><?=$row['name']?></td>
		  					<td>
		  						<a href="<?=ROOT?>/artist/<?=$row['id']?>">
		  						<img src="<?=ROOT?>/<?=$row['image']?>" style="width:100px;height: 100px;object-fit: cover;">
		  						</a>
		  					</td>
		  					<td>
		  						<a href="<?=ROOT?>/admin/artists/edit/<?=$row['id']?>">
		  							<img class="bi" src="<?=ROOT?>/assets/icons/pencil-square.svg">
		  						</a>
		  						<a href="<?=ROOT?>/admin/artists/delete/<?=$row['id']?>">
		  							<img class="bi" src="<?=ROOT?>/assets/icons/trash3.svg">
		  						</a>
		  					</td>
		  				</tr>
	  				<?php endforeach;?>
  				<?php endif;?>

				</table>
				<div class="mx-2">
					<a href="<?=ROOT?>/admin/songs?page=<?=$prev_page?>">
						<button class="btn bg-orange" style="margin: 20px">Trang trước</button>
					</a>
					<a href="<?=ROOT?>/admin/songs?page=<?=$next_page?>">
						<button class="float-end btn bg-orange" style="margin: 20px">Trang kế tiếp</button>
					</a>
				</div>
  		<?php endif;?>

	</section>

<?php require page('includes/admin-footer')?>