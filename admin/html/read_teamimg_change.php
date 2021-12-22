<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php
	include "inc/_head.html";
	include "inc/_script.html";
	include "dbconn.php";
	$no = $_GET['no'];
	$what = $_GET['what'];
	$team_result = mysqli_query($conn,"SELECT * FROM team WHERE no = '$no'");
	$team_row = mysqli_fetch_array($team_result);
	if($what == 'main'){
		$what_text = "메인";
		$imgs = $team_row['main_img'];
		$name = "main_img";
		$img_size = "width:100%;height:200px";
	}else if($what == 'logo'){
		$what_text = "로고";
		$imgs = $team_row['img'];
		$name = "img";
		$img_size = "width:200px;height:200px";
	}
	if($_POST['what_img']){
		$no = $_POST['no'];
		include "dbconn.php";
		if($_POST['what_img'] == 'img'){
			if($team_row['img']){
				if($team_row['img']){ unlink($team_row['img']); }
			}
		}else if($_POST['what_img'] == 'main_img'){
			if($team_row['main_img']){
				if($team_row['main_img']){ unlink($team_row['main_img']); }
			}
		}
		if($_FILES['img']['name'] != null){
			$_FILES['img']['name'] = date("YmdHis").'_'.$name.'_'.$_FILES['img']['name'];
			$img = $_FILES['img']['name'];
			if($_POST['what_img'] == 'img'){
				$target = 'images/team_logo/'.$img;
			}else if($_POST['what_img'] == 'main_img'){
				$target = 'images/team_main/'.$img;
			}
			$tmp_name = $_FILES['img']['tmp_name'];
			move_uploaded_file($tmp_name, $target);
		}else{
			$target = "";
		}
		if($_POST['what_img'] == 'img'){
			mysqli_query($conn,"UPDATE team SET img = '$target' WHERE no = '$no'");
		}else if($_POST['what_img'] == 'main_img'){
			mysqli_query($conn,"UPDATE team SET main_img = '$target' WHERE no = '$no'");
		}
		mysqli_close($conn);
		echo "<script>alert('변경이 완료 되었습니다. 새로 고침 또는 페이지 이동후 변경됩니다.');</script>";
		echo "<script>window.close();</script>";
	}
?>

	<script type="text/javascript">
	function imageURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function(e) {
				$('#replaceMe').attr('src', e.target.result)
			}

			reader.readAsDataURL(input.files[0]);
		}
	}
	function cancle(){
		window.close();
	}
	</script>
	<body style="margin: 30px 20px 0px 20px">
		<form name="edit_team_info" id="edit_team_info" action="read_teamimg_change.php"  enctype="multipart/form-data" method="post">
			<div class="row">
				<div class="col-md-2 form-group">
					<label for="img"><? echo $what_text;?> 사진 변경</label>
				</div>
				<div class="col-md-5 form-group">
				<? if ($imgs){?>
				<img src="<? echo $imgs;?>" id="replaceMe" style="<? echo $img_size;?>" class="img-thumbnail">
				<? } else { ?>
				<img src="images/none_team_img.png" id="replaceMe" style="<? echo $img_size;?>" class="img-thumbnail">
				<? } ?>
				</div>
				<div class="col-md-5 form-group">
					<input type="file" id="img" name="img" onchange="imageURL(this)" multiple accept='image/*'>
				</div>
			</div>
			<input type="hidden" name="what_img" value="<? echo $name;?>">
			<input type="hidden" name="no" value="<? echo $no;?>">
			<hr>
			<div class="row">
				<div class="col-md-6 form-group">
					<input type="submit" value="수정" class="btn btn-primary">
					<a class="btn btn-primary" href="javascript:;" onclick="cancle()" role="button">취소</a>
				</div>
			</div>
		</form>
	</body>
</html>