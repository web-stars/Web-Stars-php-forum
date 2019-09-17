<?php
//This page let create a new personnal message
include('core/init.php');

	$pm = new Pm(); 
	$arr_nb_new_pm = $pm->nb_new_pm(); 
	$dn1 = $pm->dn1($_POST['recip']); 

	foreach ($arr_nb_new_pm as $nb_new_pm) {
			$nb_new_pm = $nb_new_pm['nb_new_pm'];
	}

?>
<?php
if(!isset($_SESSION['username'])) {
?>
<div class="message">You must be logged to access this page.</div>
<div class="box_login">
	<form action="login.php" method="post">
		<label for="username">Username</label><input type="text" name="username" id="username">
		<label for="password">Password</label><input type="password" name="password" id="password">
        <div class="center">
	      
			<input type="submit" value="Login" /> <input type="button" onclick="javascript:document.location='signup.php';" value="Sign Up" />
        </div>
    </form>
</div>
<?php
}
?>
<?php
require_once('templates/includes/header.php');
?>

    <body>
    	<div class="header">
        	<a href="index.php"><img src="images/logo.png" alt="Forum" /></a>
	    </div>
<?php
$form = true;

		
if(isset($_POST['title'], $_POST['recip'], $_POST['message'])) {
	$otitle = $_POST['title'];
	$orecip = $_POST['recip'];
	$omessage = $_POST['message'];
		$message = nl2br(htmlentities($omessage, ENT_QUOTES, 'UTF-8'));
		
		
		if($dn1['recip']==1)
		{
			if($dn1['recipid']!=$_SESSION['userid']) {
				$id = $dn1['npm']+1;
				if(mysql_query('insert into pm (id, id2, title, user1, user2, message, timestamp, user1read, user2read)values("'.$id.'", "1", "'.$title.'", "'.$_SESSION['userid'].'", "'.$dn1['recipid'].'", "'.$message.'", "'.time().'", "yes", "no")'))
				{
	?>
	<div class="message">The PM have successfully been sent.<br />
	<a href="list_pm.php">List of your Personal Messages</a></div>
	<?php
					$form = false;
				} else {
					$error = 'An error occurred while sending the PM.';
				}
			} else {
				$error = 'You cannot send a PM to yourself.';
			}
		} else {
			$error = 'The recipient of your PM doesn\'t exist.';
		}
} 
if($form) {
if(isset($error)) {
	echo '<div class="message">'.$error.'</div>';
}
?>
<div class="content">

<div class="box">
	<div class="box_left">
    	<a href="index.php">Forum Index</a> &gt; <a href="list_pm.php">List of you PMs</a> &gt; New PM
    </div>
	
	<div class="box_right">
     	<a href="list_pm.php">Your messages(<?php echo $nb_new_pm; ?>)</a> - <a href="profile.php?id=<?php echo $_SESSION['id']; ?>"><?php echo htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></a> (<a href="login.php">Logout</a>)
    </div>
    <div class="clean"></div>
</div>
	
<div class="container">
  <h2>New personal message</h2>
  <form action="/action_page.php">
	  
		<div class="form-group">
		  <label for="title">Title:</label>
		  <input type="text" class="form-control" id="title" placeholder="Enter Title" name="title" autocomplete="off"  required>
		</div>
		
		<div class="form-group">
		  <label for="recip">Recipient: (username)</label>
		  <input type="text" class="form-control" id="recip" name="recip" required>
		</div>
		
		<div class="form-group">
		  <label for="message">Message:</label>
		  <textarea class="form-control" rows="5" id="message"></textarea>
		</div>
	  
		<button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</div>
<?php
}
?>
		<div class="foot"><a href="http://www.webestools.com/scripts_tutorials-code-source-26-simple-php-forum-script-php-forum-easy-simple-script-code-download-free-php-forum-mysql.html">Simple PHP Forum Script</a> - <a href="http://www.webestools.com/">Webestools</a></div>
	</body>
</html>