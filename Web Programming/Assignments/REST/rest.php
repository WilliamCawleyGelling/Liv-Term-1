<?php
require_once('database.php');
require_once('model.php');
$db = new Database();

//sets the exception
set_exception_handler(function ($e) {
    $code = $e-> getCode() ?: 400;
    header ("Content-Type: application/json", NULL, $code);
    echo json_encode(["error" => $e-> getMessage()]);
    exit ;
});

//These set the variables to be used coming from the request 
$method = $_SERVER['REQUEST_METHOD'];
$resource = explode('/', $_REQUEST['resource']);
$regexp = isset($_REQUEST['tName']) ? $_REQUEST['tName'] : NULL;
$data = json_decode(file_get_contents('php://input'),TRUE);

//Below i used for debugging 
//$method = 'GET';
//$resource = explode('/','teams/Everton/players/5');
//$method = 'POST';
//$resource = explode('/','teams/Everton/players');
//$data = json_decode('{"tName" : "Everton", "fName" : "Tom", "lName":"Carrol", "nationality" : "English", "DoB" : "2001-01-07" }', TRUE ); 
//$data = ["tName" => "Everton", "fName" => "Tom", "lName" => "Carrol" , "nationality" => "English", "DoB" => "2001-01-07"];
//$method = 'PATCH';
//$resource = explode('/','teams/sale/players/23');
//$data = json_decode('{"tName" : "bob"}', TRUE );


//switch method used to decided which function to use. 
switch($method) {
    case 'GET':
        [$data,$status] = readData($db,$resource,$regexp);
        break;
    case 'POST':
        [$data,$status] = createData($db,$resource,$data);
        break;
    case 'DELETE':
        [$data,$status] = deleteData($db,$resource);
        break;
    case 'PATCH': 
        [$data,$status] = patchData($db,$resource,$data);
        break;
    default:
        throw new Exception('Method Not Supported', 405);
}
header("Content-Type: application/json",TRUE,$status);
echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
/** 
*function used to insert data into the database
* @param $db is the database to be used
* @param $resource the supplied resource
* @param $data the json_decoded data that has been supplied 
*/ 
function createData($db,$resource,$data) {
    if ((count($resource) == 3) && ($resource[0] == 'teams') && ($resource[2] == 'players')){
        
        $p = new Player($db);
        $p -> setNoPid($data);
        if($p->tName == $resource[1]){
            if ($p->validateNoPid()){
                $p->pid = $p->store(); 
                $p->setLinks($p->tName, $p->pid);
                return [$p,201];
            } else { 
                throw new Exception ('Incomplete data', 400);
            }
        } elseif(!is_null($p->tName)){
            $p->tName = $resource[1]; 
            if ($p->validateNoPid()){
                $p->pid = $p->store(); 
                $p->setLinks($p->tName, $p->pid);
                return [$p,201];
            } else { 
                throw new Exception ('Incomplete data', 400);
            }
        }else {
            throw new Exception ('Bad Request, team name required to be the same in the post as in the heading', 400);
        }
    } else{
        throw new Exception("Bad request ".implode('/',$resource),400);
    }
}
/** 
*function used read data from the database and return what is there
* @param $db is the database to be used
* @param $resource the supplied resource
* @param $regexp the regular expression supplied to check if there is a team with that regexp 
* @return object and response code
*/ 
function readData($db,$resource,$regexp) {
    if ((count($resource) == 1) &&
            ($resource[0] == 'teams')) {
        return Team::readAll($db,$regexp);
    } elseif((count($resource) == 3) &&
        ($resource[0] == 'teams') && ($resource[2]=='players')) {
        $teamName = $resource[1];
        return Player::readAll($db, $teamName);
    } elseif((count($resource) == 4) &&
        ($resource[0] == 'teams') && ($resource[2]=='players')) {
            $t = new Player($db); 
            $t ->pid = $resource[3];
            $t ->tName = $resource[1];
            $t -> read($db); 
            return[$t,200];
    } else{
        throw new Exception("Bad request ".implode('/',$resource),400);
    }
}
/** 
*function used to delete data from the database 
* @param $db is the database to be used
* @param $resource the supplied resource
* @return 'not found' and whether it was successful or not
*/ 
function deleteData($db,$resource) {
    if ((count($resource) == 4) &&
        ($resource[0] == 'teams') && ($resource[2] == 'players')) {

        if (preg_match('/^\d+$/',$resource[3])) {
            $p = new Player($db);
            $p ->pid = $resource[3];
            $success = $p -> delete();
            return ['Not Found',$success];
            
        } else {
            throw new Exception("Invalid pid".$resource[3],404);
        }
    } else {
        throw new Exception("Bad request ".implode('/',$resource),400);
    }
}

/** 
*function used to edit data from the database,
*first checks the player exists in the team, then creates Player object and assigns the data from the database to it 
*then over writes the changed data from $data and updates the database.
* @param $db is the database to be used
* @param $resource the supplied resource
* @param $data the json_decoded data that has been supplied 
* @return 'not found' and whether it was successful or not
*/ 

function patchData($db,$resource,$data) {

    if ((count($resource) == 4) && ($resource[0] == 'teams') && ($resource[2] == 'players')) {

        if (preg_match('/^\d+$/',$resource[3])) {
            $p = new Player($db);
            $p ->pid = $resource[3];
            $p->tName = $resource[1]; 
            $p-> patch($db,$data);
            $p->setLinks($p->tName, $p->pid);
            return [$p, 200];
        } else {
            throw new Exception("Invalid pid".$resource[3],404);
        }
    } else{
        throw new Exception("Bad request ".implode('/',$resource),400);
    }
}

?>


