<?php 
$otpError="";
$error="";
$success="";
$otp="";
$email="";
require_once("includes/config.php");
session_start(); 

///////// send email function

if (isset($_POST['emailSend'])) {
    $randOtp=rand(10,10000);
    $email=$_POST["email"];
    
    $quary = "SELECT * FROM tblemployees WHERE EmailId='$email'";
    $result=mysqli_query($conn, $quary);
    $user_row = mysqli_fetch_array($result);
    if($user_row){

        /////////////////////////////////////////////
//      email send
        
        $msg = "dear madam/sir,\n OTP - $randOtp";

        $msg = wordwrap($msg,70);
        $header = 'From: sms.prathibha@gmail.com' . "\r\n" .
        'MIME-Version: 1.0' . "\r\n" .
        'Content-type: text/html; charset=utf-8';
       

        if(mail("$email","LMS Forget Password OTP",$msg,$header)){
            $success= 'email sent';
        }else{
            $error='error email';
        }
        
        //////////////////////////////////////////

        /////////////////////////////////////////
//      save to db        

        $emailCheckQuary = "SELECT * FROM otp WHERE EmailId='$email'";
        $emailCheckResult=mysqli_query($conn, $emailCheckQuary);
        $email_row = mysqli_fetch_array($emailCheckResult);
        if($email_row){
			
            $otpQuary="UPDATE otp SET otp=$randOtp where EmailId='$email'";
            if (mysqli_query($conn, $otpQuary)) {
                echo "Record updated successfully";
              } else {
                echo "Error updating record: " . mysqli_error($conn);
              }
        }
        else{
            $otpQuary="INSERT INTO otp ( EmailId, otp) VALUES('$email',$randOtp) ";
            if (mysqli_query($conn, $otpQuary)) {
                echo "Record inserted successfully";
              } else {
                echo "Error inserting record: " . mysqli_error($conn);
              }
        }
        ///////////////////////////////////////
    }

}


/////// check otp and redirect change password

if(isset($_POST['otpBtn'])){
	
    $otp=$_POST["otp"];
    
    $otpQuary= "SELECT * from otp where otp= $otp";
    $otpResult= mysqli_query($conn,$otpQuary);
    $otp_Raw=mysqli_fetch_array($otpResult);
    if($otp_Raw){
		echo "success";
        Header("Location: updatePassword.php?EmailId=".$otp_Raw['EmailId']);
    }else{
        $error= "Incorrect OTP";
    }
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
				<!-- <a href="login.html"> -->
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
							<h2 class="text-center text-primary">OTP</h2>
						</div>
						<form name="signin" method="post" action="">
						
							<div class="input-group custom">
								<input type="text" class="form-control form-control-lg" placeholder="Email" name="email" id="email" require>
								<div class="input-group-append custom">
									<span class="input-group-text">
                                        <i class="icon-copy fa fa-envelope-o" aria-hidden="true"></i></span>
                                    
								</div>
                            </div>                           
                                <button type="submit" name="emailSend" class="btn btn-primary me-1 mb-1">send</button>
								<small style="color: red;"><?php echo $success;?></small>
                                <br>
							<div class="input-group custom">
								<input type="text" class="form-control form-control-lg" placeholder="**********"name="otp" id="otp" require>
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
								</div>
							</div>
							<div class="row pb-30">
								
								<div class="col-6">
									
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="input-group mb-0">
									   <input class="btn btn-primary btn-lg btn-block" name="otpBtn" id="conferm" type="submit" >
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