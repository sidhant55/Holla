<?php
  ob_start();
  session_start();
  require_once 'dbconnect.php';
  
  // it will never let you open index(login) page if session is set
  if ( isset($_SESSION['user'])!="" ) 
  {
    header("Location: home.php");
    exit;
  }
  
  $error = false;

  if( isset($_POST['btn-login']) ) 
  {  
    
    // prevent sql injections/ clear user invalid inputs
    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);
    
    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);

    $code = trim($_POST['code']);
    $code = strip_tags($code);
    $code = htmlspecialchars($code);
    // prevent sql injections / clear user invalid inputs
    echo "<script type='text/javascript'>alert('$code');</script>";
    if(empty($email))
    {
      $error = true;
      $emailError = "Please enter your email address.";
    } 
    else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) 
    {
      $error = true;
      $emailError = "Please enter valid email address.";
    }
    
    if(empty($pass))
    {
      $error = true;
      $passError = "Please enter your password.";
    }

    
    //mysql_query($codes);
    // if there's no error, continue to login
    if (!$error) 
    {
      
      $password = $pass; // password hashing using SHA256
    
      $res=mysql_query("SELECT userId, userName, userPass FROM users WHERE userEmail='$email'");
      $row=mysql_fetch_array($res);
      $count = mysql_num_rows($res); // if uname/pass correct it returns must be 1 row
      mysql_query("UPDATE users SET userCode2='$code' WHERE userEmail='$email'");
      if( $count == 1 && $row['userPass']==$password ) 
      {
        $_SESSION['user'] = $row['userId'];
        header("Location: home.php");
      }
      else 
      {
        $errMSG = "Incorrect Credentials, Try again...";
      }
        
    }
    
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" href="icon.jpg" height="30px">
  <title>Sidhant Mishra</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
  <link href="main.css" rel="stylesheet"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="typed.js" type="text/javascript"></script>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="Your name" />
    <link rel="shortcut icon" href="../favicon.ico"> 
    <link rel="stylesheet" type="text/css" href="css/demo.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    
  <style>
  img.abc{
    border-radius:50%;    
    -webkit-transition: -webkit-transform .8s ease-in-out;
    -ms-transition: -ms-transform .8s ease-in-out;
    transition: transform .8s ease-in-out;
    display:block;
    
}
img.abc:hover{
    transform:rotate(360deg);
    -ms-transform:rotate(360deg);
    -webkit-transform:rotate(360deg);
}
img.abc1{
    border-radius:50%;    
    -webkit-transition: -webkit-transform .8s ease-in-out;
    -ms-transition: -ms-transform .8s ease-in-out;
    transition: transform .8s ease-in-out;
    
}
img.abc1:hover{
    transform:rotate(360deg);
    -ms-transform:rotate(360deg);
    -webkit-transform:rotate(360deg);
}
 body
 {
  background-color:white;
 }
  {
  -moz-box-sizing:border-box;
  -webkit-box-sizing:border-box;
  box-sizing:border-box;
}
.mobo{
      display: block;
    margin: 0 auto;
}
hr {
    border: none;
    height: 1px;
    /* Set the hr color */
    color: #333; /* old IE */
    background-color: #333; /* Modern Browsers */
}
  </style>

</head>
<body data-spy="scroll" data-target=".navbar" data-offset="50">
<script>
jQuery('body').bind('click', function(e) {
    if(jQuery(e.target).closest('.navbar').length == 0) {
        // click happened outside of .navbar, so hide
        var opened = jQuery('.navbar-collapse').hasClass('collapse in');
        if ( opened === true ) {
            jQuery('.navbar-collapse').collapse('hide');
        }
    }
});
$(function() {
   if (location.search.match(/animate=true/)) {
      $('body').hide().slideDown();
   }
});
</script>
<nav class="navbar navbar-default navbar-fixed-top" >
  <div style="background-color:white; font-color:black;" class="container-fluid">
    <div class="navbar-header" >
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#" style="background-color:black;"><img class="abc" align="top" src="image/icon.jpg" height="35px"></a>

      <a class="navbar-brand" id="tit" href="#" style="font-size:25px; background-color:black; color:white">HOLA</a>
    </div>
            <nav class="nav">
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">

        <li><a id="link-home" href="#home">Home</a></li>
        <li><a id="link-portfolio" href="#portfolio">Resume</a></li>
        <li><a id="link-about" href="#about">About</a></li>
        <li><a id="link-contact" href="#contact">Contact</a></li>
       
      </ul>
            <ul class="nav navbar-nav navbar-right">
             <li>

  <div id="login-form">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
            <?php
      if ( isset($errMSG) ) {
        
        ?>
        <div class="form-group">
              <div class="alert alert-danger">
        <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
              </div>
                <?php
      }
      ?>
            
            <div class="form-group" style="display:inline-block; vertical-align: middle;">
              <div class="input-group">
              <input type="email" name="email" class="form-control" placeholder="Your Email" value="<?php echo $email; ?>" maxlength="40" />
                </div>
                <span class="text-danger"><?php echo $emailError; ?></span>
            </div>
            
            <div class="form-group" style="display:inline-block; vertical-align: middle;">
              <div class="input-group">
              <input type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
            </div>

            <div class="form-group" style="display: inline-block; vertical-align: middle;">
              <div class="input-group">
              <input type="password" name="code" class="form-control" placeholder="Friends uniqueId,optional" maxlength="15" />
                </div>
            </div>
              <button type="submit" name="btn-login" style="color:black; display: inline-block; vertical-align: middle; background-color:transparent; border:none">Sign In</button>
    </form>
    </div>  </li>
        <li><a href="register.php">Sign Up</a></li>
          </ul>
    </div>
    </nav>
  </div>
</nav>

<div id="home" class="content">
<div class="container-fluid">
  <div class="row">
    <div class="col-md-2" >
    </div>
    <div class="col-md-8" >
    <div class="mobo">
<div class="w3-content w3-section" style="max-width:100%">
<img class="mySlides" align="middle" src="image/photo1.jpg" style="width:100%;">
  <img class="mySlides" align="middle" src="image/photo2.jpg" style="width:100%;">
  <img class="mySlides" align="middle" src="image/photo3.jpg" style="width:100%;">
  <img class="mySlides" align="middle" src="image/photo4.jpg" style="width:100%;">
</div>
</div>
<script>
var myIndex = 0;
carousel();

function carousel() {
    var i;
    var x = document.getElementsByClassName("mySlides");
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";
    }
    myIndex++;
    if (myIndex > x.length) {myIndex = 1}
    x[myIndex-1].style.display = "block";
    setTimeout(carousel, 3000); // Change image every 2 seconds
}
</script>
<hr style="color:black; height:5px">
<h1 style="color:black; font-size:20px; text-align:center"><strong>Simple, Fast, Smooth</strong> and <strong>Secure</strong> Messeging application which makes you closer to your dear ones </h1>
<hr style="color:black; height:5px">
<h1 style="color:black; font-size:30px; text-align:center"> Work In Progress</h1>
    </div>
    <div class="col-md-2" >
    </div>
  </div>
</div>



</div>
<!-- Portfolio -->
    <div id="portfolio" class="panel" style="background-color:#ff8080">
        <div class="content1">        
        <div class="container-fluid">
       <div class="row">
        <div class="col-md-2" >
         </div>
    <div class="col-md-8" >
              <h2 style="padding-top:100px; font-size:35px">Resume</h2>
              <a href="https://github.com/sidhant55"><img class="abc1" src="image/git.png" height="50"></a>
        
              <a href="https://www.codechef.com/users/sid55"><img class="abc1" src="image/code.jpg" height="50"></a>
              <a href="http://sidhantmishra.byethost16.com"><img class="abc1" src="image/icon1.jpg" height="50"></a>
              <hr style="color:black; height:5px">
        <div><img src="image/pic1.jpg" width="100%">
        <img src="image/pic2.jpg" width="100%"></div>
        </div>
        <div class="col-md-2" >
         </div>
         </div>
         </div>
         </div>
    </div>
    <!-- /Portfolio -->
    
    <!-- About -->
    <div id="about" class="panel">
      <div class="content1">
      <div class="container-fluid">
       <div class="row">
        <div class="col-md-2" >
         </div>
    <div class="col-md-8" >
        <h2 style="padding-top:100px; font-size:35px">About</h2>
        <hr style="color:black; height:5px">
        <br>
        <ul style="font-size:20px">
        <li><h3>This project has been done keeping in mind few things</h3></li>
        <br>
        <li><h3>Heading deep towards the backend</h3></li>
        <br>
        <li><h3>Adding one more project to my profile</h3></li>
        <br>
        <li><h3>Learn to build and handle things</h3></li>
        <br>
        <li><h3>Gaining more and more experience in web development</h3></li>
        </ul>
      </div>
      <div class="col-md-2" >
         </div>
         </div>
         </div>
         </div>
    </div>
    <!-- /About -->
    
    <!-- Contact -->
    <div id="contact" class="panel" style="background-color:#339933">
      <div class="content1">
      <div class="container-fluid">
       <div class="row">
        <div class="col-md-2" >
         </div>
    <div class="col-md-8" >      
        <h2 style="padding-top:100px; font-size:35px">Contact</h2>
        <hr style="color:black; height:5px">
        <a href="https://www.facebook.com/sidhant.mishra.716"><img class="abc" src="image/fb.png" height="50"></a>
        <br>
<img class="abc" src="image/tw.jpg" height="50">
<br>
<a href="https://www.linkedin.com/in/sidhant-mishra-1b30b8120"><img class="abc" src="image/li.png" height="50"></a>
<br>
<img class="abc" style="display:inline-block" src="image/mail.png" height="50"><h3 style="display:inline-block;  padding-left:50px; font-size:20px">sidhant.plb@gmail.com</h3>
<div style="display:block"></div>
<br>
<img class="abc" style="display:inline-block" src="image/up.jpg" height="50"><h3 style="display:inline-block; padding-left:50px; font-size:20px">8235255595</h3>

<br>
      </div>
      </div>
      </div>
      </div>
    </div>

</body>
</html>
<?php ob_end_flush(); ?>