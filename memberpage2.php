<?php require('includes/config.php'); 

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); } 

//define page title
$title = 'Members Page 2';

//include header template
require('layout/header.php'); 
?>
<style type="text/css" media="screen">
a:link { color:#0099FF; text-decoration: none; }
a:visited { color:#33348e; text-decoration: none; }
a:hover { color:#33348e; text-decoration: underline; }
a:active { color:#7476b4; text-decoration: underline; }
</style>
<div style="text-align:right; margin-top:5px; margin-right:5px;"><?php echo $_SESSION['username']; ?> &nbsp;&nbsp;&nbsp;<a href='logout.php'>Logout</a></div>
<div style="text-align:left; margin-top:5px; margin-left:5px;">
<ul>
 <li><a href="memberpage.php">Members Page 1</a></li>
 <li><a href="memberpage2.php">Members Page 2</a></li>
 <li><a href="memberpage3.php">Members Page 3</a></li>
</ul>
<div>
  <p align="center"><strong>Members Page 2</strong></p>
  <p align="center">This is where you create your members only pages, each has some php inserted to redirect anyone not logged in to your login.php page.</p>
  <p align="center">&copy;2018 SWD</p>
</div>
<?php 
//include header template
require('layout/footer.php'); 
?>
