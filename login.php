<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
ob_start();//ob_start() is used to start output buffering meaning that all the output that is sent to the browser is cached in the buffer.
if(!isset($_SESSION['system'])){
	$system = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
	foreach($system as $k => $v){
		$_SESSION['system'][$k] = $v;
	}
	//Above code is used to set the system settings in the session variable.
}
ob_end_flush();//ob_end_flush() is used to flush the output buffer and send the contents of the buffer to the browser.
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $_SESSION['system']['name'] ?></title>
 	

<?php include('./header.php'); //we included the header file which consists of all the loaders like bootstrap jqery etc ?>
<?php 
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");
//Now we checked the session and then if logged in then we redirect to the index page else we keep current page
?>

</head>
<style>
	body{
		width: 100%;
	    height: calc(100%);
	    /*background: #007bff;*/
	}
	main#main{
		width:100%;
		height: calc(100%);
		background:white;
	}
	#login-right{
		position: absolute;
		right:0;
		width:40%;
		height: calc(100%);
		background: linear-gradient(to right, rgb(127,0,0), rgba(222,123,0,0.5));
		display: flex;
		align-items: center;
	}
	#login-left{
		position: absolute;
		left:0;
		width:60%;
		height: calc(100%);
		background: linear-gradient(to right, #0062E6, #33AEFF);
		display: flex;
		align-items: center;
	}
	#login-right .card{
		margin: auto;
		background: white;
		z-index: 1
	}
	.logo {
    margin: auto;
    font-size: 8rem;
    background: white;
    padding: .5em 0.7em;
    border-radius: 50% 50%;
    color: #000000b3;
    z-index: 10;
}
div#login-right::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: calc(100%);
    height: calc(100%);
    /*background: #000000e0;*/
}

</style>

<body>


  <main id="main" class=" bg-light">
  		<div id="login-left" >
  		</div>

  		<div id="login-right" >
  			<div class="w-100">
			<h4 class="text-white text-center"><b><?php echo $_SESSION['system']['name'] ?></b></h4>
			<br>
			<br>
			<!-- Login Form  -->
  			<div class="card col-md-8">
  				<div class="card-body">
  					<form id="login-form" >
  						<div class="form-group">
  							<label for="username" class="control-label">Username</label>
  							<input type="text" id="username" name="username" class="form-control">
  						</div>
  						<div class="form-group">
  							<label for="password" class="control-label">Password</label>
  							<input type="password" id="password" name="password" class="form-control">
  						</div>
  						<center><button class="btn-sm btn-block btn-wave col-md-4 btn-primary">Login</button></center>
  					</form>
  				</div>
  			</div>
  			</div>
  		</div>
   

  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>



 
</body>

<script>
	//Login Form Validation and Ajax for authentication
	$('#login-form').submit(function(e){//This e is for the event
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled',true).html('Logging in...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax.php?action=login',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
				//what we are doing here is we are preventing the default behaviour of the form.
		$('#login-form button[type="button"]').removeAttr('disabled').html('Login');

			},
			success:function(resp){
				if(resp == 1){
					location.href ='index.php?page=home';
				}else{
					$('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
		//Above we are using ajax to send the data to the server and then we are checking the response from the server.
		//If the response is 1 then we are redirecting to the index page else we are showing the error message.
		//We are also removing the disabled attribute and the button text.
		//We are also using the serialize() method to get the data from the form.
		//We are also using the error and success method to handle the error and success response.
		
	})
</script>	
</html>