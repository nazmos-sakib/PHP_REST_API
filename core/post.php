<?php 
	
	/**
	 * 
	 */
	class Post
	{
		//db property
		private $conn;
		private $table = "post";

		//post property
		public $id;
		public $category_id;
		public $category_name;
		public $title;
		public $body;
		public $author;
		public $created_at;
		
		function __construct($db)
		{
			# code...
			$this->conn = $db;
		}

		//getting post from our database
		public function read()
		{
			//create query
			$query = 'SELECT
				c.name as category_name,
				p.id,
				p.category_id,
				p.title,
				p.body,
				p.author,
				p.created_at
				FROM 
				' . $this->table.' p
				LEFT JOIN
					categories c ON p.category_id = c.id
					ORDER BY p.created_at DESC';


			//prepared statement
			$stmt = $this->conn->prepare($query);

			//execute quary
			$stmt->execute();

			return $stmt;

		}

		public function read_single()
		{
			//create query
			$query = 'SELECT
				c.name as category_name,
				p.id,
				p.category_id,
				p.title,
				p.body,
				p.author,
				p.created_at
				FROM 
				' . $this->table.' p
				LEFT JOIN
					categories c ON p.category_id = c.id
					WHERE P.id = ? LIMIT 1';


			//prepared statement
			$stmt = $this->conn->prepare($query);

			//bind parameter
			$stmt->bindParam(1, $this->id);
			

			//execute quary
			$stmt->execute();

			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			$this->title = $row['title'];
			$this->body = $row['body'];
			$this->author = $row['author'];
			$this->category_id = $row['category_id'];
			$this->category_name = $row['category_name'];

			
		}

		//uspdate post function
		public function update()
		{
			//create query
			$query = 'UPDATE ' . $this->table . 
			' SET
				title = :title,
				body = :body,
				author = :author,
				category_id = :category_id 
				WHERE id = :id';


			//prepared statement
			$stmt = $this->conn->prepare($query);

			//clean data
			$this->id 	  	= htmlspecialchars(strip_tags($this->id));
			$this->title  	= htmlspecialchars(strip_tags($this->title));
			$this->body   	= htmlspecialchars(strip_tags($this->body));
			$this->author 	= htmlspecialchars(strip_tags($this->author));
			$this->category_id = htmlspecialchars(strip_tags($this->category_id));


			//bind parameter
			$stmt->bindParam('id', $this->id);
			$stmt->bindParam('title', $this->title);
			$stmt->bindParam('body', $this->body);
			$stmt->bindParam('author', $this->author);
			$stmt->bindParam('category_id', $this->category_id);
			

			//execute quary
			if($stmt->execute())
			{
				return true;
			}

			//print error if happen
			printf("Error: %s. \n",$stmt->error);
		}


		public function create()
		{
			//create query
			$query = 'INSERT INTO ' . $this->table . 
			' SET
				title = :title,
				body = :body,
				author = :author,
				category_id = :category_id
				';


			//prepared statement
			$stmt = $this->conn->prepare($query);

			//clean data
			$this->title = htmlspecialchars(strip_tags($this->title));
			$this->body = htmlspecialchars(strip_tags($this->body));
			$this->author = htmlspecialchars(strip_tags($this->author));
			$this->category_id = htmlspecialchars(strip_tags($this->category_id));


			//bind parameter
			$stmt->bindParam('title', $this->title);
			$stmt->bindParam('body', $this->body);
			$stmt->bindParam('author', $this->author);
			$stmt->bindParam('category_id', $this->category_id);
			

			//execute quary
			if($stmt->execute())
			{
				return true;
			}

			//print error if happen
			printf("Error: %s. \n",$stmt->error);
		}


		public function delete()
		{
			//create query
			$query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

			//prepared statement
			$stmt = $this->conn->prepare($query);

			//clean data
			$this->id = htmlspecialchars(strip_tags($this->id));
			
			//bind parameter
			$stmt->bindParam('id', $this->id);

			//execute quary
			if($stmt->execute())
			{
				return true;
			}

			//print error if happen
			printf("Error: %s. \n",$stmt->error);
		}

		
	}





 ?>