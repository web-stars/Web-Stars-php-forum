<?php
class Pm
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
	public function user_profile($id) {
		$query = 'SELECT username, email, avatar, signup_date FROM users WHERE id="'.$id.'"'; 
	}
	public function nb_new_pm($id)
	{
		$query = 'SELECT COUNT(*) AS nb_new_pm FROM pm WHERE ((user1="'.$id.'" AND user1read="no") OR (user2="'.$id.'" AND user2read="no"))'; 
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		$data = $stmt->fetchAll();
		return $data; 
	}
	
	public function req1() 
	{
		$query = 'SELECT m1.id, m1.title, m1.timestamp, COUNT(m2.id) AS reps, users.id AS userid, users.username FROM pm AS m1, pm AS m2,users WHERE ((m1.user1="'.$_SESSION['id'].'" AND m1.user1read="no" AND users.id=m1.user2) OR (m1.user2="'.$_SESSION['id'].'" AND m1.user2read="no" AND users.id=m1.user1)) AND m1.id2="1" AND m2.id=m1.id GROUP BY m1.id ORDER BY m1.id DESC';
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		$data = $stmt->fetchAll();
		return $data;
	}
	
	public function req2()
	{
		$query = 'SELECT m1.id, m1.title, m1.timestamp, COUNT(m2.id) AS reps, users.id AS userid, users.username FROM pm AS m1, pm AS m2, users WHERE ((m1.user1="'.$_SESSION['id'].'" AND m1.user1read="yes" AND users.id=m1.user2) OR (m1.user2="'.$_SESSION['id'].'" AND m1.user2read="yes" AND users.id=m1.user1)) AND m1.id2="1" AND m2.id=m1.id GROUP BY m1.id ORDER BY m1.id DESC';
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		$data = $stmt->fetchAll();
		return $data;
	}
	
	public function dn1($recip) 
	{
		$query = 'SELECT COUNT(id) AS recip, id AS recipid, (SELECT COUNT(*) FROM pm) AS npm FROM users WHERE username="'.$recip.'"';
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		$data = $stmt->fetchAll();
		return $data;
	}
}
?>