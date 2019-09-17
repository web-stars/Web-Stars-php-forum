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
	
	$id = $_GET['id'];
	
	$dn1 = $forum->get_topic($id); 
	$dn2 = $forum->read_topic($id); 

	if(!$id) {
	//	header('location:****');
	}


if(!$dn1>0) {
	echo '<h2>This topic doesn\'t exist.</h2>';
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
        	<a href="index.php"><img src="core/images/logo.png" alt="Forum"></a>
	    </div>

        <div class="content">
			
<?php
?>
<div class="box">
<?php 
foreach($dn1 as $tpc) { 
?>
	<div class="box_left">
    	<a href="index.php">Forum Index</a> &gt; <a href="list_topics.php?parent_id=<?php echo $tpc['category_id']; ?>"><?php echo htmlentities($tpc['name'], ENT_QUOTES, 'UTF-8'); ?></a> &gt; <a href="read_topic.php?id=<?php echo $id; ?>"><?php echo htmlentities($tpc['title'], ENT_QUOTES, 'UTF-8'); ?></a> &gt; Read the topic
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
<h1><?php 
foreach($dn1 as $tpc) { 
	echo $tpc['title']; 
}
?></h1>


<?php
if(isset($_SESSION['username'])) {
?>
	<a href="new_reply.php?id=<?php echo $id; ?>" class="button">Reply</a>
<?php
}

	
?>
<table class="messages_table">
	<tr>
    	<th class="author">Author</th>
    	<th>Message</th>
	</tr>
<?php
foreach ($dn2 as $msg) {
	?>
	<tr>
    	<td class="author center"><?php
if($msg['avatar']!='') {
	echo '<img src="'.htmlentities($msg['avatar']).'" alt="Image Perso" style="max-width:100px;max-height:100px;" />';
}
?><br><a href="profile.php?id=<?php echo $msg['authorid']; ?>"><?php echo $msg['author']; ?></a></td>
    	<td class="left">
		
		<?php /* if(isset($_SESSION['username']) and ($_SESSION['username']==$msg['author'])){ ?><div class="edit"><a href="edit_message.php?id=<?php echo $id; ?>&id2=<?php echo $msg['id2']; ?>"><img src="core/images/edit.png" alt="Edit" /></a></div><?php } */ ?>
		
		<div class="date">Date sent: <?php // echo date('Y/m/d H:i:s' ,$msg['timestamp']); ?></div>
        <div class="clean"></div>
    	<?php echo $msg['message']; ?></td>
    </tr>
<?php
}
?>
</table>


<?php 
require_once('core/includes/new_reply.php');
?>



		</div>
		<div class="foot"><a href="http://www.webestools.com/scripts_tutorials-code-source-26-simple-php-forum-script-php-forum-easy-simple-script-code-download-free-php-forum-mysql.html">Original PHP Forum Script</a> - <a href="http://www.webestools.com/">Webestools</a></div>
	</body>
</html>
<?php
	
?>