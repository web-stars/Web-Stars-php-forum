<?php
class User
{
	private $db;
	
	public function __construct()
	{
		try
		{
            $this->db = new PDO(DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		}
		catch(PDOException $e)
		{
			echo "PDO Error".$e->getMessage();
			die();
		}
	}

// SESSIONS 
	public function regUser($username, $password, $verify)
	{ 
		$username = mysqli_real_escape_string($this->con, $username);
		$data1 = $this->con->query("SELECT id FROM verify WHERE username='".$username."'"); 
		$data2 = $this->con->query("SELECT id FROM users WHERE username='".$username."'"); 		
		$error = 0;

		if ($data1->num_rows) {
			$error = 1;
			$message = "This username already exists.";
		} else if ($data2->num_rows) {
			$error = 1;
			$message = "This username already exists.";
		} elseif ($password!=$verify) {
			$error = 1;
			$message = "The passwords do not match.";
		}

		//password hash after password verification
		$password = password_hash($password, PASSWORD_DEFAULT);
		$signupDate = date('Y-m-d');
		$endDate = date('Y-m-d', strtotime("+4 week"));
		
		
		if ($error) {
			return $message;
		} else {
			$this->con->query("
			INSERT INTO verify (username, password, signupDate, endDate)
			VALUES('$username', '$password', '$signupDate', '$endDate')
			"); 
			$id = mysqli_insert_id($this->con);
			$_SESSION['id'] = $id; 
			$_SESSION['username'] = $username; 
			return 0;
		}
	}
	
	public function logUser($username, $password)
	{ 
		$username = mysqli_real_escape_string($this->con, $username);
		$data3 = $this->con->query("SELECT id, username, password FROM verify WHERE username='".$username."'"); 
		$data4 = $this->con->query("SELECT id, username, password FROM users WHERE username='".$username."'"); 		
		$fetch3 = mysqli_fetch_array($data3);
		$fetch4 = mysqli_fetch_array($data4);
		$error = 0;
		
		if ($data3->num_rows) {
			if (!password_verify($password, $fetch3['password'])) {
				$error = 1;
			}
		} else if ($data4->num_rows) {
			if (!password_verify($password, $fetch4['password'])) {
				$error = 1;
			}
		} else {
			$error = 1;
		}
			
		if (!$error) {
			if ($data3->num_rows) {
				$_SESSION['userid'] = $fetch3['id']; 
				$_SESSION['username'] = $fetch3['username']; 
			} else if ($data4->num_rows) {
				$_SESSION['id'] = $fetch4['id']; 
				$_SESSION['username'] = $fetch4['username']; 
				$_SESSION['active'] = 1; 
			}
			return 1;
		} else {
			return 0;
		}
	}
	
	
// DATA 
	public function unread_count($id) { // pass id of receiver to the function 
		$stmt = $this->db->prepare("SELECT COUNT(*) as total FROM pm WHERE unread=1 AND receiver_id=:id");
		$stmt->execute(['id'=>$id]);
		
		return $stmt->fetchColumn();
	}
		
	public function check_admin($id) {
		$stmt = $this->db->prepare("SELECT admin FROM users WHERE admin=1 AND id=:id");
		$stmt->execute(['id'=>$id]);
		
		return $stmt->fetchColumn();
	}
		
//??
/*
	public function activated()
	{
		$id = $_SESSION['id'];
		$result = $this->con->query("SELECT id FROM users WHERE id=".$id.""); 
		if ($result->num_rows > 0) {
			return 1;
		}
	}

//??
	public function endDate() 
	{
		$id = $_SESSION['id'];
		$result = $this->con->query("SELECT endDate FROM verify WHERE id=".$id.""); 
		$fetch = mysqli_fetch_array($result);
		return $fetch['endDate'];
	}
	
//??
	public function dateDiff()
	{
		$id = $_SESSION['id'];
		$result = $this->con->query("SELECT endDate FROM verify WHERE id=".$id.""); 
		$fetch = mysqli_fetch_array($result);
		
		$now = date("Y/m/d"); 
		$date1=date_create($now);
		$date2=date_create($fetch['endDate']);

		$diff=date_diff($date1,$date2);
		return $diff->format("%a");
	}
	
//??
	public function storeEmail($email) 
	{ 
		$id = $_SESSION['id'];
		$code = rand(10000000000, 99999999999);
		$email = password_hash($email, PASSWORD_DEFAULT);

		
		if($this->con->query("UPDATE verify SET emailaddress='".$email."', verifyCode='".$code."' WHERE id=".$id."")) {
			// send email 
			// if send email is true return 1
			return 1;
		} else {
			return 0;
		}
	}
	
	
	public function newEmailAddres($passwordControle, $newEmail) 
	{
		$id = $_SESSION['id'];
		$data1 = $this->con->query("SELECT password FROM verify WHERE id='".$id."'"); 
		$data2 = $this->con->query("SELECT password FROM users WHERE id='".$id."'"); 		
		$fetch1 = mysqli_fetch_array($data1);
		$fetch2 = mysqli_fetch_array($data2);
		$error = 0;
		$code = rand(10000000000, 99999999999);
		$newEmail = password_hash($newEmail, PASSWORD_DEFAULT);

		if ($data1->num_rows) {
			if (!password_verify($passwordControle, $fetch1['password'])) {
				$error = 1;
				$message = "The password is incorrect!";
			}
		} else if ($data2->num_rows) {
			if (!password_verify($passwordControle, $fetch2['password'])) {
				$error = 1;
				$message = "The password is incorrect!";
			}
		} else {
			$error = 1;
			// not logged, send to home.php. Is this piece of extra security neccesary? 
			header('Location: index.php?q=logout');
		}
		
		if ($error) {
			return $message;
		} else {
			if ($data1->num_rows) {
				$this->con->query("UPDATE verify SET emailaddress='".$newEmail."', verifyCode='".$code."' WHERE id=".$id."");
			} else if ($data2->num_rows) {
				$this->con->query("UPDATE verify SET emailaddress='".$newEmail."' WHERE id=".$id."");			
			}
			return 0;
		}
	}

	public function sendAgain($email) 
	{
		$id = $_SESSION['id'];
		$data1 = $this->con->query("SELECT emailaddress FROM verify WHERE id='".$id."'"); 
		$fetch1 = mysqli_fetch_array($data1);
		if (password_verify($email, $fetch1['emailaddress'])) {
			return 1; 
		} else {
			return 0;
		}
	}
	
	public function changePassword($currentPassword, $newPassword, $newPasswordVerify) 
	{
		$id = $_SESSION['id'];
		$data1 = $this->con->query("SELECT password FROM verify WHERE id='".$id."'"); 
		$data2 = $this->con->query("SELECT password FROM users WHERE id='".$id."'"); 		
		$fetch1 = mysqli_fetch_array($data1);
		$fetch2 = mysqli_fetch_array($data2);
		$error = 0;
		
		if ($newPassword!=$newPasswordVerify) {
			$error = 1;
			$message = "The passwords do not match.";
		} else if ($data1->num_rows) {
			if (!password_verify($currentPassword, $fetch1['password'])) {
				$error = 1;
				$message = "The password is incorrect!";
			}
		} else if ($data2->num_rows) {
			if (!password_verify($currentPassword, $fetch2['password'])) {
				$error = 1;
				$message = "The password is incorrect!";
			}
		} else {
			$error = 1;
			// not logged, send to home.php. Is this piece of extra security neccesary? 
			header('Location: index.php?q=logout');
		}
		
		$newpassword = password_hash($newPassword, PASSWORD_DEFAULT);
		if ($error) {
			return $message;
		} else {
			if ($data1->num_rows) {
				$this->con->query("UPDATE verify SET password='".$newpassword."' WHERE id=".$id."");
			} else if ($data2->num_rows) {
				$this->con->query("UPDATE verify SET password='".$newpassword."' WHERE id=".$id."");			
			}
			return 0;
		}
	}
	*/
	public function logout() 
	{
		session_destroy();
		header('location:index.php'); 
	}
	
}