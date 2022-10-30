<?php 
$error="";
$erroro="";
$uid="";
$pwd="";
$encry_pwd="";
$role="";
$dir="";
$npw="";
$cnpw="";
require_once("includes/Config.php");
session_start(); 
$email_id=$_REQUEST['EmailId'];

?>
<?php 
// if(isset($_SESSION["role"]))  
// {  
//    if($_SESSION['role']=="admin"){
//        header("location:Admin/index.php"); 
//    }else if($_SESSION['role']=="staff"){
//        header("location:Staff/index.php"); 
//    }
      
// } 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userQuary="SELECT * from tblemployees where EmailId='$email_id'";
    $idResult= mysqli_query($conn,$userQuary);
    $user_Raw=mysqli_fetch_array($idResult);
    if($user_Raw){
        
        $uid=$user_Raw['emp_id'];
        $role=$user_Raw['role'];

    $npw = $_POST['newPassword'];
    $cnpw = $_POST['confpassword'];

    if($npw == $cnpw){
        $encry_pwd = md5($npw);
        $quary="UPDATE tblemployees SET password='$encry_pwd'  where emp_id ='$uid'";
        if (mysqli_query($conn, $quary)) {
				echo "success";
           Header("Location: index.php");

          } else {
            $error= "Error updating record: " . mysqli_error($conn);
          }

    }else{
        $error="Please Enter Same passwords";
        //echo "\n Please Enter Same password in new and confirm password fields";
    }
}

// UPDATE users SET password=$npw  where userId =$uid;
}
?>
<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>KDUSC Leave Management</title>

	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="vendors/images/kdusc.png">
	<link rel="icon" type="image/png" sizes="32x32" href="vendors/images/kdusc-small.png">
	<link rel="icon" type="image/png" sizes="16x16" href="vendors/images/kdusc-small.png">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="vendors/styles/core.css">
	<link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="vendors/styles/style.css">

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-119386393-1');
	</script>
</head>
<body class="login-page">
	<div class="login-header box-shadow">
		<div class="container-fluid d-flex justify-content-between align-items-center">
			<div class="brand-logo">
				<a href="login.html">
					<img src="vendors/images/kdusc-small" alt="">
				</a>
			</div>
		</div>
	</div>
	<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6 col-lg-7">
					<img src="vendors/images/login1.png" alt="">
				</div>
				<div class="col-md-6 col-lg-5">
					<div class="login-box bg-white box-shadow border-radius-10">
						<div class="login-title">
							<h2 class="text-center text-primary">change password</h2>
						</div>
						<form name="signin" method="post">
						
                        <div class="input-group custom">
								<input type="password" class="form-control form-control-lg" placeholder="password"name="newPassword" id="password" require>
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
								</div>
							</div>
							<div class="input-group custom">
								<input type="password" class="form-control form-control-lg" placeholder="confirm password"name="confpassword" id="password" require>
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
								</div>
							</div>
                            <input class="btn btn-primary btn-lg btn-block" name="confermPassword" id="confirm" type="submit" value="confirm">
							<div class="row pb-30">
						
								</div>
							</div>
                            
							<div class="row">
								<div class="col-sm-12">
									<div class="input-group mb-0">
									   
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- js -->
	<script src="vendors/scripts/core.js"></script>
	<script src="vendors/scripts/script.min.js"></script>
	<script src="vendors/scripts/process.js"></script>
	<script src="vendors/scripts/layout-settings.js"></script>
</body>
</html>