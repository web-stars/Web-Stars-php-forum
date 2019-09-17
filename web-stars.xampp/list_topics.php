<?php
	//Start Session
	session_start();
	
	//Include configuration
	require_once('config/config.php');

	//Include files
	require_once 'core/class/user.php';
	require_once 'core/class/forum.php';
	 
	//Include class 
	$user = new User();
	$forum = new Forum();
	
	$parent_id = $_GET['parent_id'];
	$dn1 = $forum->get_catogery($parent_id); 
	$dn2 = $forum->list_topics($parent_id); 

	if(!isset($_GET['parent_id'])) {
		echo '<h2>The ID of the category you want to visit is not defined.</h2>';
	}

	if(!$dn1>0) {
		echo '<h2>This category doesn\'t exist.</h2>';
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
        	<a href="index.php"><img src="images/logo.png" alt="Forum"></a>
	    </div>

        <div class="content">
			
			<div class="box">
<?php 
	foreach ($dn1 as $ctg) { 
?>
				
				<div class="box_left">
					<a href="index.php">Forum Index</a> &gt; <a href="list_topics.php?parent=<?php echo $ctg['id']; ?>"><?php echo htmlentities($ctg['name'], ENT_QUOTES, 'UTF-8'); ?></a>
				</div>
<?php 
} 
?>
<?php 
if(isset($_SESSION['username'])) {
?>
				<div class="box_right">
					<a href="list_pm.php">Your messages()</a> - <a href="profile.php?id=<?php echo $_SESSION['id']; ?>"><?php echo htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></a> (<a href="login.php">Logout</a>)
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
if(isset($_SESSION['username'])) {
?>
	<a href="new_topic.php?parent_id=<?php echo $parent_id; ?>" class="button">New Topic</a>
<?php
}
			
			
if($dn2>0) {
?>
<table class="topics_table">
	<tr>
    	<th class="forum_tops">Topic</th>
    	<th class="forum_auth">Author</th>
    	<th class="forum_nrep">Replies</th>
<?php
if(isset($_SESSION['username']) and $_SESSION['username']==$admin)
{
?>
    	<th class="forum_act">Action</th>
<?php
}
?>
	</tr>
<?php
foreach ($dn2 as $tpc) {

?>
	<tr>
    	<td class="forum_tops"><a href="read_topic.php?id=<?php echo $tpc['id']; ?>"><?php echo htmlentities($tpc['title'], ENT_QUOTES, 'UTF-8'); ?></a></td>
    	<td><a href="profile.php?id=<?php echo $tpc['authorid']; ?>"><?php echo htmlentities($tpc['author'], ENT_QUOTES, 'UTF-8'); ?></a></td>
    	<td><?php echo $tpc['replies']; ?></td>
<?php
if(isset($_SESSION['username']) and $_SESSION['username']==$admin)
{
?>
    	<td><a href="delete_topic.php?id=<?php echo $tpc['id']; ?>"><img src="<?php echo $design; ?>/images/delete.png" alt="Delete" /></a></td>
<?php
}
?>
    </tr>
<?php
}
?>
</table>
<?php
} else {
?>
<div class="message">This category has no topic.</div>
<?php
}
if(isset($_SESSION['username'])) {
?>
	<a href="new_topic.php?parent_id=<?php echo $parent_id; ?>" class="button">New Topic</a>
<?php
} else {
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
<?php
}
?>
		</div>
		<div class="foot"><a href="http://www.webestools.com/scripts_tutorials-code-source-26-simple-php-forum-script-php-forum-easy-simple-script-code-download-free-php-forum-mysql.html">Original PHP Forum Script</a> - <a href="http://www.webestools.com/">Webestools</a></div>
	</body>
</html>
<?php

?>