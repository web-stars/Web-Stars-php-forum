<?php
	//Start Session
	session_start();
	
	//Include configuration
	require_once('config/config.php');

	//Include files
	require_once 'core/class/user.php';
	require_once 'core/class/pm.php';
	 
	//Include class 
	$user = new User();
	$pm = new Pm();
	
	if (isset($_SESSION['userid'])) {
		$arr_nb_new_pm = $pm->nb_new_pm(); 

		$nb_new_pms = null; 
		foreach ($arr_nb_new_pm as $nb_new_pm) {
				$nb_new_pm = $nb_new_pm['nb_new_pm'];
		}
	}
?>
<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
        <link href="core/css/style.css" rel="stylesheet" title="Style" />
        <title>Forum | Topics</title>
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    </head>    

<body>
    	<div class="header">
        	<a href="index.php"><img src="core/images/logo.png" alt="Forum" /></a>
	    </div>
        <div class="content">

<div class="box">
	<div class="box_left">
    	<a href="index.php">Forum Index</a> &gt; Profile
    </div>
<?php
if(isset($_SESSION['username'])) {
?>
	<div class="box_right">
    	<a href="list_pm.php">Your messages(<?php echo $nb_new_pm; ?>)</a> - <a href="profile.php?id=<?php echo $_SESSION['id']; ?>"><?php echo htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></a> (<a href="login.php">Logout</a>)
    </div>
<?php
} else {
?>
	<div class="box_right">
    	<a href="signup.php">Sign Up</a> - <a href="login.php">Login</a>
    </div>
<?php 
} 
?>
    <div class="clean"></div>
</div>

<?php
if(isset($_GET['id']))
{
	$id = intval($_GET['id']);
	$dn = mysql_query('select username, email, avatar, signup_date from users where id="'.$id.'"');
	if(mysql_num_rows($dn)>0) {
		$dnn = mysql_fetch_array($dn);
?>
This is the profile of "<?php echo htmlentities($dnn['username']); ?>" :
<?php
if($_SESSION['id']==$id) {
?>
<br /><div class="center"><a href="edit_profile.php" class="button">Edit my profile</a></div>
<?php
}
?>
<table style="width:500px;">
	<tr>
    	<td><?php
if($dnn['avatar']!='')
{
	echo '<img src="'.htmlentities($dnn['avatar'], ENT_QUOTES, 'UTF-8').'" alt="Avatar" style="max-width:100px;max-height:100px;" />';
}
else
{
	echo 'This user has no avatar.';
}
?></td>
    	<td class="left"><h1><?php echo htmlentities($dnn['username'], ENT_QUOTES, 'UTF-8'); ?></h1>
    	Email: <?php echo htmlentities($dnn['email'], ENT_QUOTES, 'UTF-8'); ?><br />
        This user joined the website on <?php echo date('Y/m/d',$dnn['signup_date']); ?></td>
    </tr>
</table>
<?php
if(isset($_SESSION['username']) and $_SESSION['username']!=$dnn['username'])
{
?>
<br /><a href="new_pm.php?recip=<?php echo urlencode($dnn['username']); ?>" class="big">Envoyer un MP à "<?php echo htmlentities($dnn['username'], ENT_QUOTES, 'UTF-8'); ?>"</a>
<?php
}
	}
	else
	{
		echo 'This user doesn\'t exist.';
	}
}
else
{
	echo 'The ID of this user is not defined.';
}
?>
		</div>
		<div class="foot"><a href="http://www.webestools.com/scripts_tutorials-code-source-26-simple-php-forum-script-php-forum-easy-simple-script-code-download-free-php-forum-mysql.html">Original PHP Forum Script</a></div>
	</body>
</html>