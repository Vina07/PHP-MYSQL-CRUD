<?php
//include config
require_once('includes/config.php');

//check if already logged in move to home page
if( $user->is_logged_in() ){ header('Location: index.php'); } 

//process login form if submitted
if(isset($_POST['submit'])){

	$username = $_POST['username'];
	$password = $_POST['password'];
	
	if($user->login($username,$password)){ 
		$_SESSION['username'] = $username;
		header('Location: memberpage.php');
		exit;
	
	} else {
		$error[] = 'Wrong username or password or your account has not been activated.';
	}

}//end if submit

//define page title
$title = 'Login';

//include header template
require('layout/header.php'); 
?>
</div>
<head>
<title>Login</title>
<!-- Add to Head -->
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
//Form validation highlights
$.validator.setDefaults({
    highlight: function(element) {
	    $(element).nextAll('.form-control-feedback').show().removeClass('glyphicon-ok').addClass('glyphicon-remove');
    },
    unhighlight: function(element) {
	    $(element).nextAll('.form-control-feedback').show().removeClass('glyphicon-remove').addClass('glyphicon-ok');
    },
    errorPlacement: function (error, element) {
        if (element.parent('.input-group').length || element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
            error.insertAfter(element.parent());
        } else {
            error.insertAfter(element);
        }
    }
});
//Form validation  
$(function () {
   
$("#UsernameLoginForm").validate({
        ignore: ".ignore",
		
        invalidHandler : function() {
            $('html, body').animate({
                scrollTop: $("#UsernameLoginForm").offset().top // scroll top to your form on error
            }, 'slow' );
        },
        // Specify the validation rules
        rules: {
           username: {
                required: true,
				minlength: 6,
            },
            password: {
                required: true,
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
            username: {
                required: "Please enter your username",
            },
            password: {
                required: "Please enter your password",
            },
			hiddenRecaptcha: {
                required: "Human response required",
            },
			submitHandler: function(form) // CALLED ON SUCCESSFUL VALIDATION
                {
                window.location.replace=''; // Add your custom form submitted redirect page full path here the forward slash / will redirect to your home page
			}
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
  <legend>Login</legend>
  <form name="UsernameLoginForm" id="UsernameLoginForm" role="form" action="" method="post" autocomplete="off">
    <!-- Text input-->
    <div class="form-group" id="input-block" style="margin-top:-20px;">
      <label class="control-label" for="username">Username</label>
      <div class="inputGroupContainer">
        <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
          <input  name="username" id="username" placeholder="Username" class="form-control" type="text" value="<?php if(isset($error)){ echo $_POST['username']; } ?>" maxlength="50" tabindex="1">
          <span class="form-control-feedback glyphicon glyphicon-ok"></span> </div>
        <label style="color:red; font-weight:normal;" class="error" for="username" generated="true"></label>
      </div>
    </div>
    <!-- Text input-->
    <div class="form-group" id="input-block">
      <label class="control-label" for="password">Passord</label>
      <div class="inputGroupContainer">
        <div class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
          <input name="password" id="password" placeholder="Password" class="form-control" type="password" maxlength="20" tabindex="2">
          <span class="form-control-feedback glyphicon glyphicon-ok"></span> </div>
        <label style="color:red; font-weight:normal;" class="error" for="password" generated="true"></label>
      </div>
    </div>
    <!-- NoCaptcha -->
    <div class='form-group' id="nocaptcha-block">
      <label class="control-label" for="hiddenRecaptcha">Security</label>
      <!-- Google No Captcha Human Security Scripts -->
      <input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha" tabindex="3">
      <div class="g-recaptcha" data-sitekey="Enter Your Public Site Key Here" data-callback="recaptchaCallback" style="transform:scale(0.90);-webkit-transform:scale(0.90);transform-origin:0 0;-webkit-transform-origin:0 0; color:transparent; font-weight:normal; line-height:0px;" tabindex="6"> </div>
      <div>
        <label style="color:red; font-weight:normal; position:relative; top:-8px;" class="error" for="hiddenRecaptcha" generated="true"></label>
      </div>
    </div>
    <!-- Button -->
    <div class="form-group">
      <div>
        <!-- For sliver button change btn-primary to btn-default - you can add button width:100%; for full width button -->
        <input type="submit" name="submit" value="Login" class="btn btn-primary btn-lg" style="width:; position:relative; top:10px;" tabindex="4">
        <div>&nbsp;</div>
        <div style="text-align:center; margin-bottom:-10px;"><a href="register.php">Register</a> | <a href="reset.php">Forgot password?</a></div>
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
                   case 'resetAccount':
                     echo "<div class='bg-success'>Password changed, you may now login.</div>";
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
