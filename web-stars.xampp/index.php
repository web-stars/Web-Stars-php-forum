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

	if (isset($_GET['logout'])) {
		$user->logout(); 
	} 
	
	if (isset($_POST['login'])) {
		if ($user->logUser($_POST['usernamePHP'], $_POST['passwordPHP'])) {
			$alert = '<div class="alert alert-success" role="alert"><i class="fas fa-spinner fa-spin" style="font-size:20px"></i> Login successfuly</div>'; 
		} else {
			$alert = '<div class="alert alert-danger" role="alert">Please check your inputs!</div>';
		}
	}
	
	$categories = $forum->list_categories(); 
	
	if (isset($_SESSION['userid'])) {
		$id = $_SESSION['userid'];
		$value = $user->unread_count($id); 
		$admin = $user->check_admin($id);
	}
?>

<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
        <link href="core/css/style.css" rel="stylesheet" title="Style" />
        <title>Forum</title>
		
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

			<div class="box">
				
				<div class="box_left">
					<a href="index.php">Forum Index</a>
				</div>
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
if(isset($_SESSION['username']) and $_SESSION['username']==$admin) {
?>
	<a href="new_category.php" class="button">New Category</a>
<?php
}
?>
<table class="categories_table">
	<tr>
    	<th class="forum_cat">Category</th>
    	<th class="forum_ntop">Topics</th>
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
foreach ($categories as $ctg) {

?>
	<tr>
    	<td class="forum_cat"><a href="list_topics.php?parent_id=<?php echo $ctg['id']; ?>" class="title"><?php echo htmlentities($ctg['name'], ENT_QUOTES, 'UTF-8'); ?></a>
        <div class="description"><?php echo $ctg['description']; ?></div></td>
    	<td><?php echo $ctg['topics']; ?></td>
    	<td><?php echo $ctg['replies']; ?></td>
<?php
if(isset($_SESSION['username']) and $_SESSION['username']==$admin)
{
?>
    	<td><a href="delete_category.php?id=<?php echo $ctg['id']; ?>"><img src="<?php echo $design; ?>/images/delete.png" alt="Delete" /></a>
		<?php if($ctg['position']>1){ ?><a href="move_category.php?action=up&id=<?php echo $ctg['id']; ?>"><img src="<?php echo $design; ?>/images/up.png" alt="Move Up" /></a><?php } ?>
		<?php if($ctg['position']<$nb_cats){ ?><a href="move_category.php?action=down&id=<?php echo $ctg['id']; ?>"><img src="<?php echo $design; ?>/images/down.png" alt="Move Down" /></a><?php } ?>
		<a href="edit_category.php?id=<?php echo $ctg['id']; ?>"><img src="<?php echo $design; ?>/images/edit.png" alt="Edit" /></a></td>
<?php
}
?>
    </tr>
<?php
}
?>
</table>
<?php
if(isset($_SESSION['username']) and $_SESSION['username']==$admin)
{
?>
	<a href="new_category.php" class="button">New Category</a>
<?php
}
if(!isset($_SESSION['username']))
{
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