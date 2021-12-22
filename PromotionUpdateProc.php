<?
	include("header/header.html");
	$no = $_GET['no'];
	include "dbconn.php";
	if(!$_GET['edit']){
		$promotion_result = mysqli_query($conn,"SELECT user_manager_promotion.*,manager_name,user_manager.no as manager_no FROM user_manager JOIN user_manager_promotion WHERE user_manager.user='$manager_no' AND user_manager.no = user_manager_promotion.user_manager AND user_manager_promotion.no = $no");
		$promotion_row = mysqli_fetch_array($promotion_result);
	}else{
		$contents = $_GET['contents'];
		mysqli_query($conn,"UPDATE user_manager_promotion SET  contents = '$contents', edit_info = '수정 됨' WHERE no = '$no'");
		mysqli_close($conn);
		echo "<script>alert('수정이 완료되었습니다.');</script>";
		echo "<script>opener.parent.location.replace('create_promotion.html');</script>";
		echo "<script>window.close();</script>";
	}
	
?>
<body onload="edit_contents()">
    <div class="sufee-login d-flex align-content-center flex-wrap;">
        <div class="container" style="padding:20px">
            <div class="login-content">
                <div class="login-form">
					<h3>실시간 용병경기 수정</h3>
                    <form action="PromotionUpdateProc.php" method="get">
                        <input type="hidden" name="edit" value="1">
						<input type="hidden" name="no" value="<?=$no?>">
						  <div class="form-group">
							<label for="message-title" class="col-form-label">제목</label>
							<input class="form-control" type="text" value="<?=$promotion_row['manager_name']?>" disabled>
						  </div>
						  <div class="form-group">
							<label for="message-text" class="col-form-label">내용</label>
							<textarea class="form-control" name="contents" id="contents" rows="15" id="message-text"><?=$promotion_row['contents']?></textarea>
						  </div>
						  <div class="text-right" style="border-top:1px solid #d7d7d7;padding-top:10px">
							<button type="button" class="btn btn-secondary" onclick="cancle()">취소</button>
							<button type="submit" class="btn btn-primary" style="background-color:#5093ff;border:0px;" onclick="insert()">수정</button>
						  </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
	<script>
		function cancle(){
			window.close();
		}
		function edit_contents(){
			var str = document.getElementById("contents").textContent;
			str = str.replace(/<br>/g, "\r\n");
			document.getElementById("contents").value = str;
		}
		function insert(){
			var str = document.getElementById("contents").value;
			str = str.replace(/(?:\r\n|\r|\n)/g, '<br>');
			document.getElementById("contents").value = str;
			if(doubleSubmitCheck()) return;
		}
		var doubleSubmitFlag = false;
		function doubleSubmitCheck(){
			if(doubleSubmitFlag){
				return doubleSubmitFlag;
			}else{
				doubleSubmitFlag = true;
				return false;
			}
		}
	</script>
</body>
</html>
