<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php
	include "inc/_head.html";
	include "inc/_script.html";
	$id = $_GET['id'];
	include "dbconn.php";
	if($id){
		if($_GET['pw_answer'] != null && $_GET['pw_question'] != null){
			$check_id_row = 1;
			$pw_question = $_GET['pw_question'];
			$pw_answer = $_GET['pw_answer'];
			$change_pw_result = mysqli_query($conn, "SELECT * FROM user WHERE id= '$id' AND pw_question = '$pw_question' AND pw_answer = '$pw_answer'");
			$change_pw = mysqli_fetch_array($change_pw_result);
		} else {
			$check_id_result = mysqli_query($conn, "SELECT * FROM user WHERE id= '$id'");
			$check_id_row = mysqli_fetch_array($check_id_result);
		}
		if($_GET['pwd'] != null && $_GET['pwd_s'] != null){
			$pwd = $_GET['pwd'];
			$pwd_s = $_GET['pwd_s'];
			$hash = password_hash($pwd, PASSWORD_DEFAULT);
			mysqli_query($conn,"UPDATE user SET  pw = '$hash' WHERE id = '$id'");
			echo "<script>alert('비밀번호가 변경되었습니다. 로그인을 해주세요');</script>";
			echo "<script>window.close();</script>";
		}
	}
	mysqli_close($conn);
?>

	<script type="text/javascript">
	function cancle(){
		window.close();
	}
	</script>
	<body>
	<form name="serach_pw_form" style="text-align: center;margin:5%" action="search_pw.php" method="get">
		<? if(!$id){?>
		<h3>PW 찾기</h3>
		<p>ID를 입력해 주세요</p>
		<div class="row">
			<div class="col-2 form-group">
				<label for="id">ID</label>
			</div>
			<div class="col-10 form-group">
				<input type="text" name="id" id="id" class="form-control " placeholder="ID를 입력해 주세요" required>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-6">
				<input type="submit" value="확인" class="btn btn-primary" style="width:100%">
			</div>
			<div class="col-6">
				<input class="btn btn-primary" style="width:100%" type="button" onclick="cancle()" value="취소">
			</div>
		</div>
		<? } else { ?>
			<? if($check_id_row){?>
				<?if($_GET['pw_answer'] != null && $_GET['pw_question'] != null){?>
					<? if($change_pw){?>
		<h3>PW 변경</h3>
		<p>변경하실 비밀번호를 입력해 주세요</p>
		<input type="hidden" value="<?=$id?>" name="id">
		<div class="row">
			<div class="col-2 form-group">
				<label for="pw">PW</label>
			</div>
			<div class="col-10 form-group">
				<input type="password" name="pw" id="pw" class="form-control " pattern="^.*(?=^.{8,15}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&+=]).*$" placeholder="특수문자 / 문자 / 숫자 모두 포함 형태의 8~15자리 이내" required>
			</div>
		</div>
		<div class="row">
			<div class="col-2 form-group">
				<label for="pw_s">확인</label>
			</div>
			<div class="col-10 form-group">
				<input type="password" name="pw_s" id="pw_s" class="form-control " pattern="^.*(?=^.{8,15}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&+=]).*$" placeholder="비밀번호 확인" required>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-6">
				<input type="submit" value="변경" class="btn btn-primary" style="width:100%">
			</div>
			<div class="col-6">
				<input class="btn btn-primary" style="width:100%" type="button" onclick="cancle()" value="취소">
			</div>
		</div>
					<?} else {?>
		<h3 style="color:red">※ 오류</h3>
		<p>질문 또는 답이 일치하지 않습니다</p>
		<input type="hidden" value="<?=$id?>" name="id">
		<div class="row">
			<div class="col-2 form-group">
				<label for="pw_question">질문</label>
			</div>
			<div class="col-10 form-group">
				<select class="custom-select" id="pw_question" name="pw_question">
					<option value="0" selected>선택해 주세요</option>
					<option value="1">가장 좋아하는 야구 선수 이름은?</option>
					<option value="2">가장 좋아하는 야구 선수 팀은?</option>
					<option value="3">가장 아끼는 야구 장비는?</option>
					<option value="4">처음 야구를 접한 시기는?</option>
					<option value="5">처음 야구를 가르쳐준 사람은?</option>
					<option value="6">처음 야구 경기를 한 구장은?</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-2 form-group">
				<label for="pw_answer">답</label>
			</div>
			<div class="col-10 form-group">
				<input type="text" name="pw_answer" id="pw_answer" class="form-control " placeholder="PW 찾기 질문에 대한 답" required>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-6">
				<input type="submit" value="확인" class="btn btn-primary" style="width:100%">
			</div>
			<div class="col-6">
				<input class="btn btn-primary" style="width:100%" type="button" onclick="cancle()" value="취소">
			</div>
		</div>
					<? } ?>
				<? } else { ?>
		<h3>PW 찾기</h3>
		<p>PW 찾기 질문을 선택하고 답변을 해주세요</p>
		<input type="hidden" value="<?=$id?>" name="id">
		<div class="row">
			<div class="col-2 form-group">
				<label for="pw_question">질문</label>
			</div>
			<div class="col-10 form-group">
				<select class="custom-select" id="pw_question" name="pw_question">
					<option value="0" selected>선택해 주세요</option>
					<option value="1">가장 좋아하는 야구 선수 이름은?</option>
					<option value="2">가장 좋아하는 야구 선수 팀은?</option>
					<option value="3">가장 아끼는 야구 장비는?</option>
					<option value="4">처음 야구를 접한 시기는?</option>
					<option value="5">처음 야구를 가르쳐준 사람은?</option>
					<option value="6">처음 야구 경기를 한 구장은?</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-2 form-group">
				<label for="pw_answer">답</label>
			</div>
			<div class="col-10 form-group">
				<input type="text" name="pw_answer" id="pw_answer" class="form-control " placeholder="PW 찾기 질문에 대한 답" required>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-6">
				<input type="submit" value="확인" class="btn btn-primary" style="width:100%">
			</div>
			<div class="col-6">
				<input class="btn btn-primary" style="width:100%" type="button" onclick="cancle()" value="취소">
			</div>
		</div>
				<? } ?>
			<? } else {?>
		<h3 style="color:red">※ 오류</h3>
		<p>일치하는 ID가 없습니다</p>
		<hr>
		<div class="row">
			<div class="col-6">
				<input type="submit" value="재입력" class="btn btn-primary" style="width:100%">
			</div>
			<div class="col-6">
				<input class="btn btn-primary" style="width:100%" type="button" onclick="cancle()" value="취소">
			</div>
		</div>
			<? } ?>
		<? } ?>
	</form>
	</body>
</html>