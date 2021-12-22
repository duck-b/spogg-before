<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php
	include "inc/_head.html";
	include "inc/_script.html";
	$id = $_GET['id'];

    if(!$id){
		$contents = "아이디를 입력하세요.";
    }else{
        include "dbconn.php";
  
		$result_check_id = mysqli_query($conn, "SELECT * FROM user where id='$id'");
		$num_record = mysqli_num_rows($result_check_id);
		if ($num_record){ 
			$contents = "아이디가 존재합니다. 다른 아이디를 사용하세요."; 
		}else{ 
			$contents = "사용 가능한 아이디입니다."; 
			$check_id = "check_id";
		}
		mysqli_close($conn);
    }
?>

	<script type="text/javascript">
	
	function sendTxt(){
		window.opener.document.user_form.id.value = document.check_id_form.check_id.value;
		window.opener.document.user_form.checkid.value = "check_id";
		window.opener.document.user_form.id.readOnly = true;
		self.close();
	}
	function cancle(){
		window.opener.document.user_form.id.value = "";
		window.opener.document.user_form.checkid.value = "";
		window.close();
	}
	</script>
	<body>
	<form name="check_id_form" style="text-align: center;margin-top:5%">
		<p style="font-size:150%"><? echo $contents; ?></p><br>
		<? if($check_id){?>
		<input type="hidden" id="check_id" value="<? echo $id; ?>">
		<div class="col-md-6">
			<input class="btn btn-primary" style="width:60%" type="button" onclick="sendTxt()" value="사용하기"><br><br>
		</div>
		<div class="col-md-6">
			<input class="btn btn-primary" style="width:60%" type="button" onclick="cancle()" value="취소">
		</div>
		<? } else{ ?>
		<div class="col-md-6">
			<input class="btn btn-primary" style="width:60%" type="button" onclick="cancle()" value="취소">
		</div>
		<? } ?>
	</form>
	</body>
</html>