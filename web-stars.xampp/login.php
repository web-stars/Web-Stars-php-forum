<?php
	//Start Session
	session_start();
	
	//Include configuration
	require_once('config/config.php');

	//Include files
	require_once 'core/class/user.php';
	 
	//Include class 
	$user = new User();
	
	if (isset($_SESSION['userid'])) {
		header('location:index.php'); 
	}
		
	if (isset($_POST['login'])) {
		if ($user->logUser($_POST['usernamePHP'], $_POST['passwordPHP'])) {
			$alert = '<div class="alert alert-success" role="alert"><i class="fas fa-spinner fa-spin" style="font-size:20px"></i> Login successfuly</div>'; 
		} else {
			$alert = '<div class="alert alert-danger" role="alert">Please check your inputs!</div>';
		}
	}
	/*
	if(isset($_POST['username'], $_POST['password']))
	{
		if(get_magic_quotes_gpc())
		{
			$ousername = stripslashes($_POST['username']);
			$username = mysql_real_escape_string(stripslashes($_POST['username']));
			$password = stripslashes($_POST['password']);
		}
		else
		{
			$username = mysql_real_escape_string($_POST['username']);
			$password = $_POST['password'];
		}
		$req = mysql_query('select password,id from users where username="'.$username.'"');
		$dn = mysql_fetch_array($req);
		if($dn['password']==sha1($password) and mysql_num_rows($req)>0)
		{
			$form = false;
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['userid'] = $dn['id'];
			if(isset($_POST['memorize']) and $_POST['memorize']=='yes')
			{
				$one_year = time()+(60*60*24*365);
				setcookie('username', $_POST['username'], $one_year);
				setcookie('password', sha1($password), $one_year);
			}
			*/
?>

		
<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
        <link href="core/css/style.css" rel="stylesheet" title="Style" />
        <title>Forum | Login!</title>
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    </head>    

	<body>
		<div class="header">
        	<a href="/index.php"><img src="core/images/logo.png" alt="Forum" /></a>
	    </div>
		
		<div class="content">

		<div class="box">
			<div class="box_left">
				<a href="/index.php">Forum Index</a> &gt; Login
			</div>
			<div class="box_right">
				<a href="signup.php">Sign Up</a>
			</div>
			<div class="clean"></div>

		</div>
		<?php 
		if (isset($alert)) {
			echo $alert;
		}
		?> 

		<div class="box_login">
			<form action="login.php" method="post">
				<label for="username">Username</label><input type="text" name="username" id="username" /><br />
				<label for="password">Password</label><input type="password" name="password" id="password" /><br />
				<div class="center">
					<input type="submit" value="Login" /> <input type="button" onclick="javascript:document.location='signup.php';" value="Sign Up" />
				</div>
			</form>
		</div>
	</div>

<?php
		/*} else {
			$form = true;
			$message = 'The username or password you entered are not good.';
		}
	} else {
		$form = true;
	}*/
	//if($form) {
?>

<?php
/*
$nb_new_pm = mysql_fetch_array(mysql_query('select count(*) as nb_new_pm from pm where ((user1="'.$_SESSION['userid'].'" and user1read="no") or (user2="'.$_SESSION['userid'].'" and user2read="no")) and id2="1"'));
$nb_new_pm = $nb_new_pm['nb_new_pm'];
*/
?>
<!--
<div class="box">
	<div class="box_left">
    	<a href="/index.php">Forum Index</a> &gt; Login
    </div>
</div>
    <form action="login.php" method="post">
        Please, type your IDs to log:<br />
        <div class="login">
            <label for="username">Username</label><input type="text" name="username" id="username" value="<?php echo htmlentities($ousername, ENT_QUOTES, 'UTF-8'); ?>" /><br />
            <label for="password">Password</label><input type="password" name="password" id="password" /><br />
            <input type="submit" value="Login" />
		</div>
    </form>
	-->
<?php
	// }

?>
		<div class="foot"><a href="http://www.webestools.com/scripts_tutorials-code-source-26-simple-php-forum-script-php-forum-easy-simple-script-code-download-free-php-forum-mysql.html">Original PHP Forum Script</a></div>
	</body>
</html>