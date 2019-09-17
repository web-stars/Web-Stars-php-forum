<?php
require_once('core/init.php');

$pm = new Pm();

$arr_nb_new_pm = $pm->nb_new_pm(); 
$arr_req1 = $pm->req1(); 
$arr_req2 = $pm->req2(); 

	$nb_new_pms = null; 
	foreach ($arr_nb_new_pm as $nb_new_pm) {
			$nb_new_pms = $nb_new_pm['nb_new_pm'];
	}
	$nb_pms = null; 
	foreach ($arr_req2 as $nb_pms) {
			$nb_pms = $nb_pms['reps'];
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
if(isset($_SESSION['username'])) {
?>
<div class="box">
	<div class="box_left">
    	<a href="index.php">Forum Index</a> &gt; List of your Personal Messages
    </div>
	<?php
	?>
	<div class="box_right">
    	<a href="list_pm.php">Your messages(<?php echo $nb_new_pms; ?>)</a> - <a href="profile.php?id=<?php echo $_SESSION['id']; ?>"><?php echo htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></a> (<a href="login.php">Logout</a>)
    </div>
	<?php 
	
	?>
    <div class="clean"></div>
</div>
This is the list of your personal messages:<br />
<a href="new_pm.php" class="button">New Personal Message</a><br />
<h3>Unread messages(<?php echo $nb_new_pms?>):</h3>
<table class="list_pm">
	<tr>
    	<th class="title_cell">Title</th>
        <th>Nb. Replies</th>
        <th>Participant</th>
        <th>Date Sent</th>
    </tr>
<?php
foreach ($arr_req1 as $dn1) {
?>
	<tr>
    	<td class="left"><a href="read_pm.php?id=<?php echo $dn1['id']; ?>"><?php echo htmlentities($dn1['title'], ENT_QUOTES, 'UTF-8'); ?></a></td>
    	<td><?php echo $dn1['reps']-1; ?></td>
    	<td><a href="profile.php?id=<?php echo $dn1['userid']; ?>"><?php echo htmlentities($dn1['username'], ENT_QUOTES, 'UTF-8'); ?></a></td>
    	<td><?php echo date('d/m/Y H:i:s' ,$dn1['timestamp']); ?></td>
    </tr>
<?php
}
if(($nb_new_pms)==0) {
?>
	<tr>
    	<td colspan="4" class="center">You have no unread message.</td>
    </tr>
<?php
}
?>
</table>
<br />
<h3>Read messages(<?php echo $nb_pms; ?>):</h3>
<table class="list_pm">
	<tr>
    	<th class="title_cell">Title</th>
        <th>Nb. Rreplies</th>
        <th>Participant</th>
        <th>Date Sent</th>
    </tr>
<?php
foreach ($arr_req2 as $dn2) {
?>
	<tr>
    	<td class="left"><a href="read_pm.php?id=<?php echo $dn2['id']; ?>"><?php echo htmlentities($dn2['title'], ENT_QUOTES, 'UTF-8'); ?></a></td>
    	<td><?php echo $dn2['reps']-1; ?></td>
    	<td><a href="profile.php?id=<?php echo $dn2['userid']; ?>"><?php echo htmlentities($dn2['username'], ENT_QUOTES, 'UTF-8'); ?></a></td>
    	<td><?php echo date('d/m/Y H:i:s' ,$dn2['timestamp']); ?></td>
    </tr>
<?php
}
if($nb_pms==0) {
?>
	<tr>
    	<td colspan="4" class="center">You have no read message.</td>
    </tr>
<?php
}
?>
</table>
<?php
} else {
?>
<h2>You must be logged to access this page:</h2>
<div class="box_login">
	<form action="login.php" method="post">
		<label for="username">Username</label><input type="text" name="username" id="username" /><br />
		<label for="password">Password</label><input type="password" name="password" id="password" /><br />
        <label for="memorize">Remember</label><input type="checkbox" name="memorize" id="memorize" value="yes" />
        <div class="center">
	        <input type="submit" value="Login" /> <input type="button" onclick="javascript:document.location='signup.php';" value="Sign Up" />
        </div>
    </form>
</div>
<?php
}
?>
		</div>
		<div class="foot"><a href="http://www.webestools.com/scripts_tutorials-code-source-26-simple-php-forum-script-php-forum-easy-simple-script-code-download-free-php-forum-mysql.html">Simple PHP Forum Script</a> - <a href="http://www.webestools.com/">Webestools</a></div>
	</body>
</html>