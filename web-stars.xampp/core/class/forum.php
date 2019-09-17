<?php
class Forum
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
	
	public function list_categories() {
		$query = 'SELECT c.id, c.name, c.description, c.position, (select COUNT(t.id) FROM topics AS t WHERE t.category_id=c.id) AS topics, (SELECT COUNT(t2.id) FROM topics AS t2 WHERE t2.category_id=c.id) AS replies FROM categories AS c group BY c.id ORDER BY c.position ASC';
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		$data = $stmt->fetchAll();
		return $data; 
	}
	
	
	public function get_catogery($parent_id) 
	{
		$query = 'SELECT COUNT(c.id) AS nb1, c.name, COUNT(t.id) AS topics FROM categories AS c LEFT JOIN topics AS t ON t.category_id="'.$parent_id.'" WHERE c.id="'.$parent_id.'" GROUP BY c.id';
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		$data = $stmt->fetchAll();
		return $data; 
	}
	
	public function list_topics($parent_id) 
	{
		$query = 'SELECT t.id, t.title, t.authorid, u.username AS author, COUNT(r.id) AS replies FROM topics AS t LEFT JOIN topics AS r ON r.category_id="'.$parent_id.'" AND r.id=t.id LEFT JOIN users AS u ON u.id=t.authorid WHERE t.category_id="'.$parent_id.'" GROUP BY t.id ORDER BY t.timestamp DESC';
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		$data = $stmt->fetchAll();
		return $data; 
	}
	
	public function get_topic($id) 
	{
		$query = 'SELECT COUNT(t.id) AS nb1, t.title, t.category_id, COUNT(t2.id) AS nb2, c.name FROM topics AS t, topics AS t2, categories AS c WHERE t.id="'.$id.'" AND t2.id="'.$id.'" AND c.id=t.category_id GROUP BY t.id'; 
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		$data = $stmt->fetchAll();
		return $data; 
	}

	public function read_topic($id) {
		$query = 'SELECT r.authorid, r.message, r.timestamp, u.username AS author, u.avatar FROM replies AS r, users AS u WHERE r.topic_id="'.$id.'" AND u.id=r.authorid ORDER BY r.id ASC';
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		$data = $stmt->fetchAll();
		return $data; 
	}
	
	public function new_reply($topic_id, $message) 
	{
		$stmt = $this->db->prepare("INSERT INTO replies (topic_id, message, authorid) VALUES (:topic_id, :message, :authorid)");
		$stmt->bindParam(':topic_id', $topic_id);
		$stmt->bindParam(':message', $message);
		$stmt->bindParam(':authorid', $_SESSION['id']);
		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}
	
	public function new_topic($category_id, $title, $message) 
	{
		$stmt = $this->db->prepare("INSERT INTO topics (category_id, title, message, authorid) VALUES (:category_id, :title, :message, :authorid)");
		$stmt->bindParam(':category_id', $category_id);
		$stmt->bindParam(':title', $title);
		$stmt->bindParam(':message', $message);
		$stmt->bindParam(':authorid', $_SESSION['id']);
		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}

}
?>