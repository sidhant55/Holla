<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	
	// if session is not set this will redirect to login page
	if( !isset($_SESSION['user']) ) {
		header("Location: index.php");
		exit;
	}
	// select loggedin users detail
	$res=mysql_query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
	$userRow=mysql_fetch_array($res);
  $id=$_SESSION['user'];
  $code1=$userRow['userCode1'];
  $code2=$userRow['userCode2'];
  $code2n1 = mysql_query("SELECT * FROM users WHERE userCode1='$code2'");
  $code2n2 = mysql_fetch_array($code2n1);

/*while ($row = mysql_fetch_array($results)) {
  //$row=mysql_fetch_array($results);
    foreach($row as $field) {
        echo $field;
        $field=" ";
    }
}*/
  if ( isset($_POST['btn-signup']) ) {
    date_default_timezone_set('Asia/Kolkata');
    // clean user inputs to prevent sql injections
    $name = trim($_POST['name']);
    $name = strip_tags($name);
    $name = htmlspecialchars($name);
    $date=date("m/d");
    $time=date("H:i");
    //echo "<script>alert('$time');</script>";
     $sql1 = "INSERT INTO user1(code1,code2,userPost,postDate,postTime) VALUES('$code1','$code2','$name','$date','$time')";
     mysql_query($sql1);
    

  }
   if ( isset($_POST['id_save']) ) {
    
    // clean user inputs to prevent sql injections
    $frnd = trim($_POST['id2']);
    $frnd = strip_tags($frnd);
    $frnd = htmlspecialchars($frnd);

    $frndN = trim($_POST['id1']);
    $frndN = strip_tags($frndN);
    $frndN = htmlspecialchars($frndN);

    $query3=mysql_query("SELECT * FROM user2");
$flag=0;
  while($row2 = mysql_fetch_row($query3))
  {
    if ("$row2[0]"==$id && "$row2[1]"==$frnd){
    $flag=1;
    break;
   }
 }
    if ($flag==0){
     $sql2 = "INSERT INTO user2(userId, userFriend, friendName) VALUES('$id','$frnd','$frndN')";
     mysql_query($sql2);}
    //$sql = "INSERT INTO users (userPost) VALUES ('$name')";
  }

  if ( isset($_POST['chng-frnd']) ) {
    $id_1 = trim($_POST['id_1']);
    $id_1 = strip_tags($id_1);
    $id_1 = htmlspecialchars($id_1);
    mysql_query("UPDATE users SET userCode2='$id_1' WHERE userId='$id'");
    header("Location: index.php");
  }
?>


<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['userEmail']; ?></title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>
<style>


</style>
</head>
<body>
<script>

	    $(window).load(function() {
  $(".scr").animate({ scrollTop: 50000 }, 5000);
});
/*$(window).load(function() {
  var elem = document.getElementById('page');
  elem.scrollTop = elem.scrollHeight;
}, 1000)*/
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
          <li><a href="http://www.sidhantmishra.byethost16.com">Home</a></li>
          <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Friends<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <?php
  $query2="SELECT * FROM user2";
  $results2 = mysql_query($query2);

  while($row2 = mysql_fetch_row($results2))
  {
    if ("$row2[0]"==$id){
    echo "<tr>";
    echo str_pad("$row2[2] - $row2[1]", 0)."<br>";
    echo "</tr>";
   }
 }
   ?>
          </ul>
        </li>
      </ul>

          <ul class="nav navbar-nav navbar-right">
            <li>
              <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">

            <div class="form-group" style="display:inline-block; vertical-align: middle;">
              <div class="input-group">
              <input type="password" name="id_1" class="form-control" placeholder="Friend's uniqueId" maxlength="15" />
                </div>
            </div>
              <button type="submit" name="chng-frnd" style="vertical-align: middle; background-color:transparent; border:none">Change Friend</button>
   
    </form>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        <span class="glyphicon glyphicon-user"></span>&nbsp;Hi' <?php echo $userRow['userName']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
              </ul>
            </li>
          </ul>
    </div>
    </nav>
  </div>
</nav>


<div style="padding-top:50px"></div>
<div>
<h3 style="float:left;">Your Id- <b><?php echo $userRow['userCode1'];?></b></h3>

<h3 style="float:right; display:inline-block;">Friend's Id- <b><?php echo $userRow['userCode2'];?></b></h3>
</div>
<h1 style="text-align:center;">Welcome <?php echo $userRow['userName']; ?></h1>

<div class="container1">
  <div class="row">
    <div class="col-md-7">
      <h2 style="padding-left:20px; display:inline-block"><?php echo $userRow['userName'] ?></h2><h2 style="display:inline-block; padding-right:10px; float:right;"><?php echo $code2n2['userName']?></h2>

            <div class="scr" id=page style="background-color:#ffcccc; height:380px; overflow-y:auto; border-radius:15px; border-left: thick solid #ff0000; border-right: thick solid #ff0000;">
              
                <h4><?php
  $query="SELECT * FROM user1";
  $results = mysql_query($query);
  $flag=0;
  while($row = mysql_fetch_row($results))
  {
    if ("$row[0]"==$code1 && "$row[1]"==$code2){
    if ($flag==0)
    {
      $flag=$row[3];
      $flag++;
    }
    if ($flag!="$row[3]")
    {
      echo "<tr>";
    ?><div style="color:#ffcccc">.</div><div style="text-align:center"><div style="background-color:#ff5500; padding:5px; border-radius:10px"><?php 
    echo "$row[3]"; ?></div></div><?php
    echo "</tr>";
    $flag=$row[3];
    }
    echo "<tr>";
    ?><div style="color:#ffcccc">.</div><div style="padding-bottom:15px; padding-left:15px"><div style="float:left; background-color:lightblue; padding:5px; border-radius:10px"><?php 
    echo "$row[2] -$row[4]"; ?></div></div><?php
    echo "</tr>";
   }
   else if ("$row[1]"==$code1 && "$row[0]"==$code2){
    echo "<tr>";
    ?><div style="padding-bottom:15px; padding-right:15px;"><div style="color:#ffcccc">.</div><div style="float:right; background-color:lightgreen; padding:5px; border-radius:10px"><?php echo "$row[2] -$row[4]";?></div></div><?php
    echo "</tr>";
   }
 }
   ?></h4>
</div>

    </div>
    <div class="col-md-5">
    <div style="padding-top:50px"></div>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
              <textarea type="text" name="name" class="form-control"  rows="3" placeholder="Deploy whats in your mind...." maxlength="1000" value="<?php echo $name ?>"></textarea>
                </div>
                <span class="text-danger"><?php echo $nameError; ?></span>
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Post</button>
            </div>
            </form>

    <form method="post">
    <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                <textarea type="text" name="id1" class="form-control" placeholder="Friend's Name" maxlength="15" value="<?php echo $name ?>"></textarea>
              <textarea type="text" name="id2" class="form-control" placeholder="Friend's Id" maxlength="15" value="<?php echo $name ?>"></textarea>
                </div>
                <span class="text-danger"><?php echo $nameError; ?></span>
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-block btn-primary" name="id_save">Save</button>
            </div>
            </form>
    </div>

</div>
</div>
<script src="assets/jquery-1.11.3-jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

    
</body>
</html>
<?php ob_end_flush(); ?>