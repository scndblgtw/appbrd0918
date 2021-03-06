﻿<?php
  // echo __DIR__."<br>";				// C:\Bitnami\wampstack-5.6.28-1\apache2\htdocs\appbrd
  // echo __FILE__."<BR>";				// C:\Bitnami\wampstack-5.6.28-1\apache2\htdocs\appbrd\index.php
  // echo dirname(__FILE__)."<BR>";	// C:\Bitnami\wampstack-5.6.28-1\apache2\htdocs\appbrd
  require(__DIR__."/config/config.php");// require("./config/config.php");
  require(__DIR__."/lib/db.php");// require("lib/db.php");

  
  $conn = db_init($config["host"], $config["duser"], $config["dpw"], $config["dname"]);
    
  
  
  $Gget_ID = isset($_GET["id"]) ? $_GET["id"] : "-5";
  if(GLOBAL_TST) {	echo "[]Gget_ID=";  var_dump($Gget_ID);	}
  
  $G_table_appitems = "appitems";
  $G_table_users = "users";
  
  $LIMIT_PER_PAGE = 10; // from nav.php
	
	
  $sql_id = "id";

  
  // ini_set("session.cache_expire", 60); 
  // ini_set("session.gc_maxlifetime", 90);
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <!-- TW-Bootstrap -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

  <link rel="stylesheet" type="text/css" href="./style.css">

  <!-- Bootstrap -->
  <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
  
	
	<script>
	function refreshNavMy(nextHori){
		$.ajax({
			type: 'GET',
			url: "part/nav.php?bgnpage=" +nextHori,
			dataType : 'text',
			error : function() {
			alert('Loading article failed!');
			},
			success: function(data) {
				$('nav#mymy').html(data);
			}
		});
	}
	</script>

</head>
<body id="target">		
			
	  
    <div class="container-fluid">      
	  <header class="row">
		  <script type="text/javascript">
		  $(function(){
			$.ajax({
				type: 'GET',
				<?php echo "url: 'part/header.php'"?>,
				dataType : 'text',
				error : function() {
				  alert('Loading HEADER failed!');
				},
				success: function(data) {
				  $('header').html(data);
				}
			});
		  })
		  </script>
	  </header>


      <!-- Start. row 4 TW-Bootstrap -->
      <div class="row">
		
		<div class="col-md-9">
          <article>		  
			<script>
			$(function(){
				$.ajax({
					type: 'GET',
					<?php echo "url: 'part/article.php?{$sql_id}={$Gget_ID}'"?>,
					dataType : 'text',
					error : function() {
					  alert('Loading article failed!');
					},
					success: function(data) {
						$('article').html(data);
					}
				});
			})
			</script>
          </article>
        </div>
		

	  
		<nav class="col-md-3" id="mymy">			
			<script>
			refreshNavMy();
			</script>
		</nav>
		
      </div>
    </div>


	<!-- <script src="./script/jsIndex.js"></script> -->
	<script src="./lib/jsIndex.js"></script>

	<script> 
		function refreshHeader(){
			$('header').load('part/header.php?id=<?php echo $Gget_ID ?>');	// load()으로 작동. //html()는 반응 없음.
		}

		function returnBackTheArticle2in(idx, bp){
			$.ajax({
				type: 'GET',
				url: 'part/article.php?id='+idx+'&bgnpage='+bp,
				dataType : 'text',
				error : function() {
				  alert('Fail!!');
				},
				success: function(data) {
					$('article').html(data);	//load()는 반응 없음.
				}
			});
		}
		

	function submitWhatForm(whatProcess, cPg){
		// sUrl= './' +whatProcess +'?bgnpage=' +cPg;
		// alert(sUrl);
		
		if(whatProcess === 'register_act.php') {
			txloginID = document.getElementById("form-loginID").value;
			txnameNic = document.getElementById("form-nameNic").value;
			txloginPW = document.getElementById("form-loginPW").value;
			txloginPWcf = document.getElementById("form-loginPWcf").value;
			
			// alert(txloginID +" | " +txnameNic +" | " +txloginPW +" | " +txloginPWcf);
			
			if(txloginID  ==="" || txloginID===null) { alert("필수: ID"); return; }
			if(txnameNic  ==="" || txnameNic===null) { alert("필수: 별명"); return; }
			if(txloginPW  ==="" || txloginPW===null) { alert("필수: 암호"); return; }
			if(txloginPWcf==="" || txloginPWcf===null) { alert("필수: 암호 학인"); return; }
		}
		
		var queryString = $("form[name=whatForm]").serialize();
		
		$.ajax({
			type: 'POST',
			url: './' +whatProcess +'?bgnpage=' +cPg,
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
	
	
	
	function goToLoginForm(){
		// alert("goToLoginForm()");
		$.ajax({
			type: 'GET',
			url: <?php echo "'./login.php?{$sql_id}={$Gget_ID}'" ?>,
			dataType : 'text',
			error : function() {
			  alert('Loading a process page of LOGIN failed!');
			},
			success: function(data) {
				$('article').html(data);
			}
		});
	}	

	function gotoRegisterForm(){
		$.ajax({
			type: 'GET',
			url: <?php echo "'./register.php?{$sql_id}={$Gget_ID}'" ?>,
			dataType : 'text',
			error : function() {
			  alert('Loading a process page of REGISTER failed!');
			},
			success: function(data) {
				$('article').html(data);
			}
		});
	}
	
	function logoutSession(){
		$.ajax({
			type: 'GET',
			// url: <?php echo "'".__DIR__."\..\login.php?action=1'" ?>,
			url: <?php echo "'./logout_act.php'" ?>,
			dataType : 'text',
			error : function() {
			  alert('Loading a process of LOGOUT failed!');
			},
			success: function(data) {
				$('article').html(data);
				refreshHeader();
			}
		});
	}
	</script>
    <!-- End. row 4 TW-Bootstrap -->

	<?php require("part/body_bottom.php"); ?>

		
  
  
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="./bootstrap/js/bootstrap.min.js"></script>  

</body>
</html>
