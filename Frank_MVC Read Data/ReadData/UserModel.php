<?

class UserModel{
	
	private $db;
	
	public function __construct($dsn, $db_user, $db_pass) {
		try{
    		$this->db = new PDO($dsn, $db_user, $db_pass);
		}
		catch (\PDOException $e){
			var_dump($e);
		}
	}
	
	public function getUsers(){
	
	$statement = $this->db->prepare("
	SELECT username, id
	FROM appUsers

	");
	
	try{
		if ($statement->execute()){
		$rows = $statement->fetchAll(\PDO::FETCH_ASSOC);
		return $rows;
		
		}
		
	}
	catch (\PDOException $e){
		echo "couldn't query database";
		var_dump($e);
	}
	
	return array();
	
	}

	public function getUser($id){      
                $statement = $this->db->prepare("
						SELECT username, id, userpassword
						FROM appUsers
                        WHERE id = :id
                ");
        
                try {
                        if($statement->execute(array(":id"=>$id))){
                        
                                $rows = $statement->fetchAll(\PDO::FETCH_ASSOC);

                                return $rows;
                                
                        }// end if
                        else{ 
                                echo "Please try again.";
                        }//end else
                } catch(\PDOException $e) {
                
                        echo "Couldn't query database";
                        var_dump($e);
                        
                }// catch end
                
                return array();				

	}

}