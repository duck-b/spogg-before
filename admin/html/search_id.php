<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php
	include "inc/_head.html";
	include "inc/_script.html";
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	
	if($name != null && $phone != null && $email != null){
		include "dbconn.php";
		$search_id_count_result = mysqli_query($conn, "SELECT COUNT(*) as count FROM user WHERE name = '$name' AND phone = '$phone' AND email = '$email'");
		$search_id_count_row = mysqli_fetch_array($search_id_count_result);
		if($search_id_count_row['count'] >= 1){
			$search_id_result = mysqli_query($conn, "SELECT * FROM user WHERE name= '$name' AND phone = '$phone' AND email = '$email'");
			$contents = "<p>".$name."님의 ID</p>";
			while($search_id_row = mysqli_fetch_array($search_id_result)){
				$contents = $contents."<table style='text-align:center;width:100%'>
					<tr>
						<td style='width:50%;vertical-align:middle'>".$search_id_row['id']."</td>
						<td style='width:50%;vertical-align:middle'><a class='btn btn-primary' style='width:100%' role='button' href='search_pw.php?id=".$search_id_row['id']."'>PW 찾기</a></td>
					</tr>
				</table>";
			}
			$contents = $contents."<hr><div class='row'>
				<div class='col-12'>
					<input class='btn btn-primary' style='width:100%' type='button' onclick='cancle()' value='취소'>
				</div>
			</div>";
		}else{
			$contents = "<p>일치하는 정보가 없습니다</p>
				<div class='row'>
					<div class='col-6'>
						<input type='submit' value='재입력' class='btn btn-primary' style='width:100%'>
					</div>
					<div class='col-6'>
						<input class='btn btn-primary' style='width:100%' type='button' onclick='cancle()' value='취소'>
					</div>
				</div>";
			$contents = $name."(이름)/".$phone."(번호)/".$email."(이메일)";
		}
		mysqli_close($conn);
	}
?>

	<script type="text/javascript">
		function cancle(){
			window.close();
		}
	</script>
	<body>
	<form name="search_id_form" style="text-align: center;margin:5%" action="search_id.php" method="post">
		<h3>ID 찾기</h3>
		<? if(!$contents){?>
		<p>가입시 정보를 입력해 주세요</p>
		<div class="row">
			<div class="col-2 form-group">
				<label for="name">이름</label>
			</div>
			<div class="col-10 form-group">
				<input type="text" name="name" id="name" class="form-control " placeholder="이름 입력" required>
			</div>
		</div>
		<div class="row">
			<div class="col-2 form-group">
				<label for="phone">연락처</label>
			</div>
			<div class="col-10 form-group">
				<input type="tel" name="phone" id="phone" class="form-control " placeholder="ex)010-1234-5678" pattern="(010)-\d{3,4}-\d{4}" required>
			</div>
		</div>	
		<div class="row">
			<div class="col-2 form-group">
				<label for="email">E-mail</label>
			</div>
			<div class="col-10 form-group">
				<input type="email" name="email" id="email" class="form-control " placeholder="test@example.com" pattern="[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$" required>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-6">
				<input type="submit" value="찾기" class="btn btn-primary" style="width:100%">
			</div>
			<div class="col-6">
				<input class="btn btn-primary" style="width:100%" type="button" onclick="cancle()" value="취소">
			</div>
		</div>
		<? } else {?>
		<?=$contents?>
		<? } ?>
	</form>
	</body>
</html>