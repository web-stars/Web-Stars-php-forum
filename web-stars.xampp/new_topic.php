<?php
require_once('core/init.php');

$forum = new Forum();
$dn1 = $forum->get_catogery($parent_id); 

if(!isset($parent_id)) {
	echo '<h2>The ID of the category you want to add a topic is not defined.</h2>';
}
if(!isset($_SESSION['username'])) {
?>
<h2>You must be logged to access this page.</h2>
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
$last_id = null; 
foreach($dn1 as $ctg) {
	if(!$ctg['nb1']>0) {
		echo '<h2>The category you want to add a topic doesn\'t exist.</h2>';
	}
	$last_id = $ctg['topics'] + 1;
}
echo $last_id;
?>


<?php
require_once('templates/includes/header.php');
?>


    <body>
    	<div class="header">
        	<a href="index.php"><img src="images/logo.png" alt="Forum" /></a>
	    </div>
        <div class="content">
			<div class="box">ddggd/ddggd
				<?php 
				foreach ($dn1 as $ctg) { 
				?>
				<div class="box_left">
					<a href="index.php">Forum Index</a> &gt; <a href="list_topics.php?parent_id=<?php echo $parent_id; ?>"><?php echo htmlentities($ctg['name'], ENT_QUOTES, 'UTF-8'); ?></a> &gt; New Topic
				</div>
				<?php 
				}
				?>
				<div class="box_right">
					<a href="list_pm.php">Your messages()</a> - <a href="profile.php?id=<?php echo $_SESSION['id']; ?>"><?php echo htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></a> (<a href="login.php">Logout</a>)
				</div>
				<div class="clean"></div>
			</div>
<?php
if(isset($_POST['message'], $_POST['title']) and $_POST['message']!='' and $_POST['title']!='')
{
	include('bbcode_function.php');
	
	$title = $_POST['title'];
	$message = $_POST['message'];
	
	if($forum->new_topic($parent_id, $title, $message)) {
	?>
	<div class="message">The topic have successfully been created.<br />
	<a href="list_topics.php?parent=<?php echo $id; ?>">Go to the forum</a></div>
	<?php
	} else {
		echo 'An error occurred while creating the topic.';
	}
}
else
{
?>
<form action="new_topic.php?parent_id=<?php echo $parent_id; ?>" method="post">
	<label for="title">Title</label><input type="text" name="title" id="title"  /><br />
    <label for="message">Message</label><br />
    <div class="message_buttons">
        <input type="button" value="Bold" onclick="javascript:insert('[b]', '[/b]', 'message');" /><!--
        --><input type="button" value="Italic" onclick="javascript:insert('[i]', '[/i]', 'message');" /><!--
        --><input type="button" value="Underlined" onclick="javascript:insert('[u]', '[/u]', 'message');" /><!--
        --><input type="button" value="Image" onclick="javascript:insert('[img]', '[/img]', 'message');" /><!--
        --><input type="button" value="Link" onclick="javascript:insert('[url]', '[/url]', 'message');" /><!--
        --><input type="button" value="Left" onclick="javascript:insert('[left]', '[/left]', 'message');" /><!--
        --><input type="button" value="Center" onclick="javascript:insert('[center]', '[/center]', 'message');" /><!--
        --><input type="button" value="Right" onclick="javascript:insert('[right]', '[/right]', 'message');" />
    </div>
    <textarea name="message" id="message" cols="70" rows="6"></textarea><br />
    <input type="submit" value="Send" />
</form>
<?php
}
?>
		</div>
		<div class="foot"><a href="http://www.webestools.com/scripts_tutorials-code-source-26-simple-php-forum-script-php-forum-easy-simple-script-code-download-free-php-forum-mysql.html">Simple PHP Forum Script</a> - <a href="http://www.webestools.com/">Webestools</a></div>
	</body>
</html>
<?php

?>