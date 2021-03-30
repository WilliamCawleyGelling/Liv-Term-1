<?php
require_once 'database.php';
/** 
*Class team creates object Team
*/ 
class Team { 
    private $conn;
    private static $table = 'teams';
    private $parts = ['tName','sport','aveAge'];

    public $tName, $sport, $aveAge, $_links;
    public function __construct($db) {
        $this->conn = $db->conn;
    }
    /** 
    *Sets the data brought in to the $parts of the object created
    * @param $source is the data coming from the request 
    */ 
    public function set($source) {
        if (is_object($source))
            $source = (array)$source;
        foreach ($source as $key=>$value)
            if (in_array($key,$this->parts))
                $this->$key = $value;
            else
                throw new Exception("$key not an attribute of teams",400);
    }
    /** 
    *Validates that all of the parts have been set before inputting data into database 
    */ 

    public function validate() {
        foreach ($this->parts as $key)
            if (is_null($this->$key))
                return FALSE;
        return TRUE;
    }

    /** 
    *retruns the encoded string 
    */ 
    public function __toString() {
        return json_encode($this,
                    JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    }

    /** 
    *Sets the links for the data being returned 
    * @param $tName, the name of the team
    */ 
    public function setLinks($tName) {
        $this->_links = 
            [(object)['href' => "teams", 'method' => 'GET', 'rel' => 'self'],
            (object)['href' => "teams?tName=regex", 'method' => 'GET', 'rel' => 'search with regex'], 
            (object)['href' => "teams/$tName/players", 'method' => 'GET', 'rel' => 'players']];
    }
    
    /** 
    *reads the data in the databese from the view table and returns all the teams
    * @param $db is the database to be used
    * @param $regexp is the given regular expression if given
    * @returns [allTeams,200] returns all the team objects and the code 200
    */ 
    public static function readAll($db,$regexp) {
        $allTeams = [];
        if (!is_null($regexp)) {
            $query = 'select * from ' . self::$table . ' where tName regexp ?'; 
            $stmt = $db->conn->prepare($query);
            $stmt -> execute(array($regexp));

        } else {
            $query = 'select * from ' . self::$table; 
            $stmt = $db->conn->prepare($query);
            $stmt -> execute();
        }
        foreach ($stmt as $row) {
            $t = new Team($db); 
            $t -> set($row);
            $t ->setLinks($t->tName);
            //can you create an object from within the class 
            // Construct a new Meeting object $m based on the
            // information in the array $row
            array_push($allTeams,$t);

        }

        return [$allTeams,200];
    }

}
/** 
*Class Player that creates Player objects 
*/ 
class Player { 
    private $conn;
    private static $table = 'Players';
    //all the parts 
    private $parts = ['pid', 'tName','fName','lName','nationality','DoB'];
    //parts without the id for when creating data 
    private $partsNoPid = ['tName','fName','lName','nationality','DoB'];

    

    public $pid, $tName, $fName, $lName, $nationality, $DoB, $_links;
    public function __construct($db) {
        $this->conn = $db->conn;
    }
    /** 
    *Sets the data brought in to the $parts of the onbject
    * @param $source is the data coming from the request 
    */ 
    public function set($source) {
        if (is_object($source))
            $source = (array)$source;
        foreach ($source as $key=>$value)
            if (in_array($key,$this->parts))
                $this->$key = $value;
            else
                throw new Exception("$key not an attribute of players",400);
    }
    /** 
    *Sets the data brought in to the $parts of the object created
    * @param $source is the data coming from the request 
    */ 
    public function setNoPid($source) {
        if (is_object($source))
            $source = (array)$source;
        foreach ($source as $key=>$value)
            if (in_array($key,$this->partsNoPid))
                $this->$key = $value;
            else
                throw new Exception("$key not an attribute of players",400);
    }

    /** 
    *Validates that all of the parts have been set before inputting data into database 
    */ 
    public function validate() {
        foreach ($this->parts as $key)
            if (is_null($this->$key))
                return FALSE;
        return TRUE;
    }
    /** 
    *Validates that all of the parts (bar pid) have been set before inputting data into database 
    */ 
    public function validateNoPid() {
        foreach ($this->partsNoPid as $key)
            if (is_null($this->$key))
                return FALSE;
        return TRUE;
    }
    /** 
    *retruns the encoded string 
    */ 
    public function __toString() {
        return json_encode($this,
                    JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    }

    /** 
    *Sets the links for the data being returned 
    * @param $tName, the name of the team
    * @param $pid the player id 
    */ 
    public function setLinks($tName, $pid) {
        $this->_links = 
            [(object)['href' => "teams/$tName/players", 'method' => 'GET', 'rel' => 'collection'],
            (object)['href' => "teams/$tName/players/$pid", 'method' => 'GET', 'rel' => 'self'], 
            (object)['href' => "teams/$tName/players", 'method' => 'POST', 'rel' => 'insert'],
            (object)['href' => "teams/$tName/players/$pid", 'method' => 'PATCH', 'rel' => 'edit'],
            (object)['href' => "teams/$tName/players/$pid", 'method' => 'DELETE', 'rel' => 'delete']
             
            ];
    }

    /** 
    *reads the data in the databese and returns all the players playing for a team
    * @param $db is the database to be used
    * @param $tName is the name of the team 
    * @returns [allTeams,200] returns a list of all the player objects 
    */ 
    public static function readAll($db,$tName) {

        $allPlayers = [];
        $query = 'select * from teams where tName = ?'; 
        $stmt = $db->conn->prepare($query);
        $stmt -> execute(array($tName));
        if ($stmt -> rowcount()> 0){
            $query = 'select * from ' . self::$table . ' where tName = ?'; 
            $stmt = $db->conn->prepare($query);
            $stmt -> execute(array($tName));
            
            foreach ($stmt as $row) {
                $t = new Player($db); 
                $t -> set($row);
                $t ->setLinks($tName, $t->pid);
                array_push($allPlayers,$t);
            }
            return [$allPlayers,200];
        }else {
            return ['This team does not exist in the table', 404];
        }
    } 
    /** 
    *reads the data in the databese and returns the player with the given pid
    * @param $db is the database to be used
    * 
    */ 
    public function read($db) { 
        $query = 'select * from teams where tName = ?'; 
        $stmt = $db->conn->prepare($query);
        $stmt -> execute(array($this->tName));
        if ($stmt -> rowcount()> 0){
            $query = 'select * from ' . self::$table . ' where pid = ? and tName = ?'; 
            $stmt = $db->conn->prepare($query);
            $stmt -> execute(array($this->pid, $this->tName));
            $row = $stmt->fetch(); 
            if ($row == FALSE) { 
                throw new Exception ("Player Not Found in team ", 404);
            } else {
                forEach($row as $key => $value)
                    $this -> $key = $value;
                $this -> setLinks($this->tName, $this->pid); 
            }
        }else {
            throw new Exception ('This team does not exist in the table', 404);
        }

    }
    /** 
    *checks that data is correct and then inserts it into the database 
    *the database generates a player id for the player and then this is returned
    * @return the pid of the player 
    */ 
    public function store() { 

        //the pid is generated in sql 
        $query = " Insert into " . self::$table . " (tName, fName, lName, nationality, DoB) values (?,?,?,?,?) ";
        $stmt = $this->conn->prepare($query); 
        $stmt->execute(array($this->tName, $this->fName, $this->lName, $this->nationality, $this->DoB));
        $query = " select pid from " . self::$table . " where tName = ? and  fName = ? and  lName = ? and nationality = ? and DoB = ? ";
        //this now finds the pid that was created in the database 
        $stmt2 = $this->conn->prepare($query);
        $stmt2->execute(array($this->tName, $this->fName, $this->lName, $this->nationality, $this->DoB));
        $row = $stmt2->fetch();
        return $row['pid'];
    }
    /** 
    *Deletes the player from the database with the given player id. 
    *@return returns the code for if it was successful or not 
    */ 
    public function delete() {
        $query = " delete from " . self::$table . " where pid = ?";
        $stmt = $this->conn->prepare($query);
        $stmt -> execute(array($this->pid));

        if($stmt -> rowcount()>0){
            return 204;
        } else {
            return 404;
        }
     }
    /** 
    *Edits the information on a given player 
    *@param $db the database 
    *@param $data is the data of the player to be edited
    */ 
     public function patch($db, $data){

        $query = "select * from " . self::$table . " where pid = ? and tName = ? ";
        $stmt = $db->conn->prepare($query);
        $stmt -> execute(array($this->pid, $this->tName));
        $row = $stmt->fetch(); 
        if ($row == FALSE) { 
            throw new Exception ("Player Not Found in team to edit", 404);
        } else {
            forEach($row as $key => $value)
                $this -> $key = $value;
            forEach($data as $key => $value)
                $this -> $key = $value;
            // now we have the updated this we update by doing 
            $query = "update " . self::$table . " set tName = ? , fName = ? ,  lName = ? , nationality = ? , DoB = ? where pid = ?";
            $stmt = $db->conn->prepare($query);
            $stmt -> execute(array($this->tName, $this->fName, $this->lName, $this->nationality, $this->DoB, $this->pid));
            
        }
        
     }
}
