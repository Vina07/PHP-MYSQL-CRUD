<?php require('includes/config.php');

//if logged in redirect to members page
if( $user->is_logged_in() ){ header('Location: memberpage.php'); }

//if form has been submitted process it
if(isset($_POST['submit'])){

	//email validation
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Please enter a valid email address';
	} else {
		$stmt = $db->prepare('SELECT email FROM members WHERE email = :email');
		$stmt->execute(array(':email' => $_POST['email']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(empty($row['email'])){
			$error[] = 'Email provided is not on recognised.';
		}

	}

	//if no errors have been created carry on
	if(!isset($error)){

		//create the activasion code
		$token = md5(uniqid(rand(),true));

		try {

			$stmt = $db->prepare("UPDATE members SET resetToken = :token, resetComplete='No' WHERE email = :email");
			$stmt->execute(array(
				':email' => $row['email'],
				':token' => $token
			));

			//send email
			$to = $row['email'];
			$subject = "Password Reset";
			$body = "<p>Someone requested that the password be reset.</p>
			<p>If this was a mistake, just ignore this email and nothing will happen.</p>
			<p>To reset your password, visit the following address: <a href='".DIR."resetPassword.php?key=$token'>".DIR."resetPassword.php?key=$token</a></p>";

			$mail = new Mail();
			$mail->setFrom(SITEEMAIL);
			$mail->addAddress($to);
			$mail->subject($subject);
			$mail->body($body);
			$mail->send();

			//redirect to index page
			header('Location: login.php?action=reset');
			exit;

		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

	}

}

//define page title
$title = 'Reset Account';

//include header template
require('layout/header.php');
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js" type="text/javascript"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script src='//www.google.com/recaptcha/api.js'></script>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css" rel="stylesheet">
<!-- jQuery Form Validation code -->
<script type="text/javascript" language="JavaScript">
<!--
// Removes Error Message When reCaptcha is Checked Valid
function recaptchaCallback() {
  $('#hiddenRecaptcha').valid();
};

$(function () {
   
$("#LostDetailsForm").validate({
        ignore: ".ignore",
		
        invalidHandler : function() {
            $('html, body').animate({
                scrollTop: $("#LostDetailsForm").offset().top // scroll top to your form on error
            }, 'slow' );
        },
        // Specify the validation rules
        rules: {
           email: { 
                required: true,
				email: true,
            },
			hiddenRecaptcha: {
                required: function () {
                if (grecaptcha.getResponse() == '') {
                     return true;
                } else {
                     return false;
			    }
			  }				
           },
       },

        // Specify the validation error messages
        messages: {
            email: {
                required: "Please enter your email",
            },
			hiddenRecaptcha: {
                required: "Human response required"
            },
			submitHandler: function(form) // CALLED ON SUCCESSFUL VALIDATION
			// Redirect can be removed from here
                {
                window.location.replace=''; // Add your custom form submitted redirect page
			}
			// Redirect can be removed to here
        },
   });

});
-->
</script>
<style type="text/css">
.outer-padding {
  padding-left:10px; /* margin left for mobile phones */
  padding-right:10px; /* margin right for mobile phones */
  margin-bottom:30px;
}
fieldset{
  max-width:400px;
  margin:auto; /* position left. right and atuo for middle  */
  margin-top:20px;
  padding:20px;
  border:1px #CCCCCC solid; /* border around form */
  background-color:white; /* Form background colour */
  border-radius: 5px; /* round corners on border */
}
legend {
  font-size:18px;
  font-weight:bold;
  color:#333333;
  width:inherit; /* Or auto */
  padding:0 10px; /* To give a bit of padding on the left and right */
  border-bottom:none;
}
.errormessage {
  max-width:400px;
  margin:auto; /* position left. right and atuo for middle  */
  margin-top:20px;
}
.bg-danger {
  padding:10px;
  border:#FF6C6C 1px solid;
  border-radius: 5px; /* round corners on border */
}
.bg-success {
  padding:10px;
  border:#009900 1px solid;
  border-radius: 5px; /* round corners on border */
}  
input[type='text'],
textarea { width:100%;
}
#input-block {
  display:block;
  height:65px;
}
#textarea-block {
  display:block;
  height:105px;
}
#nocaptcha-block {
  display:block;
  height:105px;
}
::-webkit-input-placeholder {
    color:#888;
}
:-moz-placeholder {
    color:#888;
}
::-moz-placeholder {
    color:#888;
}
:-ms-input-placeholder {
    color:#888;
}
/* Placeholder disappears on focus */
input:focus::-webkit-input-placeholder  {color:transparent !IMPORTANT;}
input:focus::-moz-placeholder   {color:transparent !IMPORTANT;}
input:-moz-placeholder   {color:transparent !IMPORTANT;}
textarea:focus::-webkit-input-placeholder  {color:transparent !IMPORTANT;}
textarea:focus::-moz-placeholder   {color:transparent !IMPORTANT;}
textarea:-moz-placeholder   {color:transparent !IMPORTANT;}
.style1 {color: #FF0000}
textarea {
 height:70px !IMPORTANT;
 }
.form-control-feedback{
  display: none;
}
.input-group {
  width:100% !IMPORTANT;
}
.glyphicon-ok {
   color:#338b34; /* off green success tick */
}
.glyphicon-remove {
   color:#a94442; /* off red error cross */  
}
</style>
<!-- End Head -->
</head>
<body>
<!-- Place All in Body -->
<div class="outer-padding">
  <fieldset>
  <legend>Reset Password</legend>
  <form role="form" name="LostDetailsForm" id="LostDetailsForm" action="" method="post" autocomplete="off">
	<!-- Text input-->
    <div class="form-group" id="input-block">
      <label class="control-label" for="email">Email</label>
      <div class="inputGroupContainer">
        <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
           <input type="email" name="email" id="email" placeholder="Enter Email" value="" class="form-control" maxlength="100" tabindex="1">
          <span class="form-control-feedback glyphicon glyphicon-ok"></span> </div>
        <label style="color:red; font-weight:normal;" class="error" for="email" generated="true"></label>
      </div>
    </div>
    <!-- NoCaptcha -->
    <div class='form-group' id="nocaptcha-block">
      <label class="control-label" for="hiddenRecaptcha">Security</label>
      <!-- Google No Captcha Human Security Scripts -->
      <input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha" tabindex="5">
      <div class="g-recaptcha" data-sitekey="Enter Your Public Site Key Here" data-callback="recaptchaCallback" style="transform:scale(0.90);-webkit-transform:scale(0.90);transform-origin:0 0;-webkit-transform-origin:0 0; color:transparent; font-weight:normal; line-height:0px;" tabindex="6"> </div>
      <div>
        <label style="color:red; font-weight:normal; position:relative; top:-8px;" class="error" for="hiddenRecaptcha" generated="true"></label>
      </div>
    </div>
    <!-- Button -->
    <div class="form-group">
      <div>
        <!-- For sliver button change btn-primary to btn-default - you can add button width:100%; for full width button -->
        <input type="submit" name="submit" value="Submit" class="btn btn-primary btn-lg" style="width:; position:relative; top:10px;" tabindex="4">
        <div>&nbsp;</div>
        <div style="text-align:left; margin-bottom:-10px;"><a href="login.php">Return to Login</a></div>
      </div>
    </div>
   <div class="errormessage">
   <?php
   //check for any errors
   if(isset($error)){
     foreach($error as $error){
       echo '<p class="bg-danger">'.$error.'</p>';
          }
       }
       if(isset($_GET['action'])){
       //check the action
        switch ($_GET['action']) {
          case 'active':
            echo "<div class='bg-success'>Your account is now active you may now log in.</div>";
            break;
          case 'reset':
            echo "<div class='bg-success'>Please check your inbox for a reset link.</div>";
            break;
           }
       }
    ?>
    </div>
  </form>
  </fieldset>
</div>
<?php
//include header template
require('layout/footer.php');
?>
<!-- End Body -->
</body>
