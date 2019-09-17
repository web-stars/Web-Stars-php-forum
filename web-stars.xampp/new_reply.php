<?php
require_once('core/init.php');

$forum = new Forum();

$dn1 = $forum->get_topic($id); 

if(!$id) {
	echo '<h2>The ID of the topic you want to reply is not defined.</h2>';
}

if(!$dn1>0) {
	echo '<h2>The topic you want to reply doesn\'t exist.</h2>';
}

$form = true; 
if(isset($_POST['message']) and $_POST['message']!='') {
	
	include('bbcode_function.php');
		
	if($forum->new_reply($id, $_POST['message'])) {
	?>
	<div class="message">The message have successfully been sent.<br />
	<a href="read_topic.php?id=<?php echo $id; ?>">Go to the topic</a></div>
	<?php
	} else {
		echo 'An error occurred while sending the message.';
	}
}
?>


<?php
require_once('templates/includes/header.php');
?>
    <body>
    	<div class="header">
        	<a href="index.php"><img src="images/logo.png" alt="Forum" /></a>
	    </div>
        <div class="content">

<?php
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
?>

<div class="box">
<?php 
foreach($dn1 as $tpc) {
?>
	<div class="box_left">
    	<a href="index.php">Forum Index</a> &gt; <a href="list_topics.php?parent_id=<?php echo $tpc['category_id']; ?>"><?php echo htmlentities($tpc['name'], ENT_QUOTES, 'UTF-8'); ?></a> &gt; <a href="read_topic.php?id=<?php echo $id; ?>"><?php echo htmlentities($tpc['title'], ENT_QUOTES, 'UTF-8'); ?></a> &gt; Add a reply
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
 
if ($form == true) {
?>
<form action="new_reply.php?id=<?php echo $id; ?>" method="post">
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

