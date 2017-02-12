﻿<?php
  // echo __DIR__."<br>";				// C:\Bitnami\wampstack-5.6.28-1\apache2\htdocs\appbrd
  // echo __FILE__."<BR>";				// C:\Bitnami\wampstack-5.6.28-1\apache2\htdocs\appbrd\index.php
  // echo dirname(__FILE__)."<BR>";	// C:\Bitnami\wampstack-5.6.28-1\apache2\htdocs\appbrd
  require(__DIR__."/config/config.php");
  require(__DIR__."/lib/db.php");
  $conn = db_init($config["host"], $config["duser"], $config["dpw"], $config["dname"]);
  
  
  $Gget_ID = isset($_GET["id"]) ? $_GET["id"] : "-5";
  echo "[]Gget_ID=";  var_dump($Gget_ID);
	
  $crrPage = isset($_GET["bgnpage"]) && $_GET["bgnpage"]!==0? $_GET["bgnpage"] : 0;
  echo ",bgnpage=".$crrPage;
  
  
  
  $Gget_again = isset($_GET["again"]) ? $_GET["again"] : "";
  $G_table_appitems = "appitems";
  $Gget_loginID = isset($_GET['loginID']) ? $_GET['loginID'] : "";
  
  
  
  $LIMIT_PER_PAGE = 4; // from nav.php
  
  
  $sql_id = "id";
  $isLogined = isset($_SESSION['isLogined']) ? $_SESSION['isLogined'] : false;
  
?>



<div>
	<?php
		if($Gget_again == -1) {
		  echo "<a class='error_red'>[X] Two passwords are different. Again please.</a><br>";
		} else if($Gget_again == -2) {
		echo "<a class='error_red'>[X] The ID [".$Gget_loginID."] already taken. Register again, please.</a><br>";
		}
	?>
    <!-- <form class="" action="register_process.php" method="post"> -->
    <form class="" name="registerForm">
	  <label for="form-title"><h3>회원 가입</h3></label>
      <div class="form-group">
        <label for="form-loginID">아이디:</label>
        <!-- <input type="text" class="form-control" name="loginID" id="form-loginID" placeholder="prefered ID" onblur="onblur_event()" required> -->
		<input type="text" class="form-control" name="loginID" id="form-loginID" placeholder="prefered ID" required>
      </div>
	  
      <div class="form-group">
        <label for="form-nameNic">별명:</label>
        <input type="text" class="form-control" name="nameNic" id="form-nameNic" placeholder="prefered nic name" required>
      </div>
	  
      <div class="form-group">
        <label for="form-loginPW">암호:</label>
        <input type="password" class="form-control" name="loginPW" id="form-loginPW" value="" required>
      </div>
	  <div class="form-group">
        <label for="form-loginPWcf">암호 학인:</label>
        <input type="password" class="form-control" name="loginPWcf" id="form-loginPWcf" value="" required>
      </div>
	  
      <!-- <input type="hidden" role="uploadcare-uploader" /> -->
      <!-- <input type="submit" value="확인" name="login" class="btn btn-success"> -->
      <input type="button" value="확인" class="btn btn-success" onClick="submitRegisterForm();">
	  <input type="button" value="취소" class="btn btn-success" onClick="returnBackTheArticle2in(<?php echo $Gget_ID?>, <?php echo $crrPage ?>);">
	  
	  <!-- <a href="./register.php" class="btn btn-info">회원가입</a> -->
    </form>
</div>

<script type="text/javascript">

function submitRegisterForm(){
	// alert("submitLoginForm()");
	var queryString = $("form[name=registerForm]").serialize();
	
	txloginID = document.getElementById("form-loginID").value;
	txnameNic = document.getElementById("form-nameNic").value;
	txloginPW = document.getElementById("form-loginPW").value;
	txloginPWcf = document.getElementById("form-loginPWcf").value;
	
	// alert(txloginID +" | " +txnameNic +" | " +txloginPW +" | " +txloginPWcf);
	
	if(txloginID  ==="" || txloginID===null) { alert("Require ID"); return; }
	if(txnameNic  ==="" || txnameNic===null) { alert("Require 별명"); return; }
	if(txloginPW  ==="" || txloginPW===null) { alert("Require 암호"); return; }
	if(txloginPWcf==="" || txloginPWcf===null) { alert("Require 암호 학인"); return; }
	
	// alert("submitLoginForm( " +queryString +" )");
	$.ajax({
		type: 'POST',
		url: './register_process.php',
		data: queryString,
		dataType : 'text',
		error : function() {
		  alert('Fail!!');
		},
		success: function(data) {
			//$('header').load("./part/header.php");
			$('article').html(data);
			refreshHeader();
		}
	});
}


	function onblur_event(){
		alert("빈공간은 사용할 수 없습니다.");
	}
</script>