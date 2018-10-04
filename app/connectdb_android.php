<?php 
  
      
    // connect to mysql 
   class DbConnect{
	private $conn;
	private $server="localhost"; 
    private $user="root"; 
    private $pass=""; 
    private $db="clis_monitoring"; 
    
public function __construct()
{
		//echo "inside cons";
    
	$this->conn = mysqli_connect($this->server, $this->user, $this->pass) or die("Sorry, can't connect to the localhost."); 
    if($this->conn){
    	//echo "Connected to $this->server <br>";
    }
      
    // select the db 
      
    $this->connect_to_db = mysqli_select_db($this->conn, $this->db) or die("Sorry, can't select the database."); 
    if($this->connect_to_db){
    	//echo "Connected to $this->db <br>";
    
}
}

public function getDb()
{
	return $this->conn;
}	
   }

$test = new   DbConnect;
$conn = $test->getDb();

   
	
  
?>