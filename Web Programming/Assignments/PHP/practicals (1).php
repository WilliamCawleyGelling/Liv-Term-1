<!-- 
    Design choice 
    The design i have chosen for my website works on the principal that once an email has been used to book a lab for a module, 
    it cannot be used to book another lab for that module. This design prevents double booking of the same lab.
    It also prevents double booking of a module lab for that week.   
    This is refelected in my database as well. If i allowed students to book the same lab 
    multiple times then to stop errors occoring when accessing the database i would have to change the
    table to allow duplicate data. Or have it that the data is only added to student once but still 
    takes up one of the spaces in a lab. 
    in my opinion this is a better design choice. 
-->
<?php 
/**
 * Starting a session and storing the following request in session 
 */
session_start(); 
if (isset($_REQUEST['module']))
    $_SESSION['module'] = $_REQUEST['module']; 
if (isset($_REQUEST['name']))
    $_SESSION['name'] = $_REQUEST['name'];
if (isset($_REQUEST['email']))
    $_SESSION['email'] = $_REQUEST['email'];  
if (isset($_REQUEST['dayTime']))
    $_SESSION['dayTime'] = $_REQUEST['dayTime']; 
?>

<!DOCTYPE html>
<html lang='en-GB'>
    <head>
        <meta charset="UTF-8"> 
        <meta name = "description" content = "Practical Session Booking Service"> 
        <meta name = "author" content = "William Cawley Gelling"> 
        <meta name = "copyright" content="William Cawley Gelling"> 
        <title>University of Liverpool Practical Session Booking Service </title>
        <link rel="stylesheet" type ="text/css" href="practicals.css"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body> 
        <section id = "Title">
            <h1> University of Liverpool <br>MSC Lab Booking Service </h1>
        </section> 

        <?php
//Error messaging, useful for me when working 
error_reporting( E_ALL );
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

/**
 * Setting up the variables for starting a new pdo later in the code
 */
$db_hostname = "studdb.csc.liv.ac.uk";
$db_database = "sgwcawle";
$db_username = "sgwcawle";
$db_password = "Portugal1!";
$db_charset = "utf8mb4";
$dsn = "mysql:host=$db_hostname;dbname=$db_database;charset=$db_charset";
$opt = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
);

/**
 * Prints out a discription of the booking schedule
 */
function printDescription(){ 
    echo "<p> Below are this weeks options for practical lab sessions. 
    Please enter your name, email address and pick the module you are booking for.
    Once you pick a module the avalible practicles will be selectable. ";
}
/**
 * Creates and prints a table to the screen showing the times and if there are spaces 
 * @param $pdo is the access to my database so i can create a statment to find out the 
 * state of the Practical table in database. 
 */

function infoTable($pdo){
    //Prepare and execute function to find information to fill table 
    $stmt = $pdo->prepare("select * from Practical order by module, dayNoRep ASC"); 
    $stmt -> execute();
    //Printing created table to screen. 
    echo "<table><tr><th> Module </th><th>Day and Time</th><th> Location </th><th> Space </th></tr> ";
    foreach($stmt as $row){ 
        echo "<tr><td> ",$row["module"], " </td><td> ",$row["dayTime"], " </td><td> ",$row["location"], " </td><td> ",$row["space"], " </td></tr>\n";
    }

    echo"</table><br>";
}

/**
 * Creates and prints form1 to screen. 
 * @param $modules is the executed sql prepared statment that gives information on the available modules 
 * @param $lab is the executed sql prepared statment that gives me information on the labs available for a module 
 * its defualt is null. This is so we can use the function when labs are not needed. 
 */
function printForm1($modules, $lab = Null) {

    //Starts the form 
    echo "<form name = 'form1' method = 'post'>";
    //Creats input text box for email
    //Checks if $_SESSION['email'] has beeen set if so sets value =$_SESSION['email'] if not leaves blank 
    if (isset($_SESSION['email'])){
        echo "<label>Email:</label> <input type='text' name = 'email' size = '40' value ='",$_SESSION['email'],"'><br><br>";
    } else {
        echo "<label>Email:</label> <input type='text' name = 'email' size = '40'><br><br>";
    }
    //Creats input text box for name
    //Checks if $_SESSION['name'] has beeen set if so sets value =$_SESSION['name'] if not leaves blank 
    if (isset($_SESSION['name'])){
        echo "<label>Name:</label> <input type='text' name = 'name' size = '30' value = '",$_SESSION['name'],"'><br><br>";
    }
    else { 
        echo "<label>Name:</label> <input type='text' name = 'name' size = '30'><br><br>";
    }
    //Creates a select box for module 
    //Checks if $_SESSION['module'] has beeen set, if so set shows the box with $_SESSION['module']
    echo "<select name='module' required onChange = 'document.form1.submit()'>";
    if (isset($_SESSION['module'])){
        echo "<option value ='' disabled selected hidden>", $_SESSION['module'],"</option>";
    } else { 
        echo "<option value ='' disabled selected hidden> Select a module</option>";
    }
    foreach($modules as $row)
        echo "<option  value='",$row['module'],"'>",$row['module'],"</option>";
        
    echo"</select>";

    //Creates a select box for lab
    echo "<select name = 'dayTime' required>";
    //Checks if $_SESSION['module'] has beeen set, if so shows available times 
    if (isset($_SESSION['module'])){

        //Checks if there available times if so populates select options 
        if ($lab->rowcount()> 0){

            echo "<option value ='' disabled selected hidden>Select a Lab Session</option> ";
            foreach($lab as $row)
                echo "<option  value='",$row['dayTime'],"'>",$row['dayTime'],"</option>";
        }
        //If non available for that module gives non selectable option showing this 
        else {
            echo "<option value ='' disabled selected hidden>There are no spaces left avalible </option> ";
        }
    
    //If $_SESSION['module'] has not been set then shows unselectable option saying to pick a module
    } else  {
        echo "<option value ='' disabled selected hidden>Select a module to choose a lab</option> ";
    }
    echo "</select><br> <br>
    <input type='submit' name='book' value = 'Book' >
    </form>";
}
/**
 * Function that is run to check inputs of name and email and print error message if not. 
 * @return true if email and name are correct and this is used to move to the next section. 
 */
function regExpCheck(){
    
    $patternName ="/([a-zA-Z]+[- ']?)+/";
    $patternEmail = "/\A[a-zA-Z.-]*[a-zA-z][@][a-zA-Z-.]+[a-zA-z]\z/";

    if (preg_match($patternName, $_SESSION['name'], $matches) and $matches[0] == $_SESSION['name']){

        if (preg_match($patternEmail, $_SESSION['email'])){
            return true;
        }
        else{ 
            echo "This is an invalid email, please enter a valid one. ";
        }
    }

    else{
        echo "You have entered an invalid name, please input a name with only a-z, space, hyphens and apostrophes."; 
    }
}
/**
 * Function that runs the transaction with the database, populates the student table and 
 * takes away a space from the module's lab in Practical table.  
 * @param $pdo is the access to my database 
 *  
 */
function transaction($pdo) {
    //try statment to catch if there is an error 
    try{

        $pdo ->beginTransaction(); 
        //This prepared statment finds the row for the dateTime of the module 
        $stmt = $pdo->prepare("select * from Practical where module = ? and dayTime = ?");
        $stmt->execute(array($_SESSION['module'], $_SESSION['dayTime']));
        //This prepared statment finds if someone has already booked this module with email
        //If we wanted it only to stop people form booking a lab time and not the module then include dayTime = ? 
        $stmt2 = $pdo->prepare("select * from Student where module = ? and email = ?;");
        $stmt2 -> execute(array($_SESSION['module'], $_SESSION['email']));
        //can just use fetch as there should only be one touple as the primary key was asked for. 
        $row = $stmt -> fetch(); 

        //This if statment firstly deals with situations where someone else has booked the slot since you logged on. 
        if ($row['space']<1){
            echo "<h2>There is no space left in this lab:<br>";
            echo $_SESSION['module'], " on ", $_SESSION['dayTime'];
            echo "<br> please a diffrent lab!<br><h2>";
            unset($_SESSION['module']);
            unset($_SESSION['dayTime']);
            //Creates form and input button to reset page. 
            echo "<br> <form name = 'return' method = 'post'><input type= 'submit' name='return' value = 'Return to start page'></form>"; 
        } 
        // else if catches double bookings of modules and tells them it is not possible 
        // Can be removed along with changing the database as stated at the top, to allow double booking.
        else if ($stmt2->rowCount() > 0){ 
            echo "<h2>You have booked a lab for this module already!";
            echo "The session you had already booked was: <br>";
            $row2 = $stmt2->fetch();
            echo $row2['module'], " on ", $row2['dayTime'];
            echo "<br><br>The session you just tried to book was: <br>";
            echo $_SESSION['module'], " on ", $_SESSION['dayTime'], "</h2>";
            unset($_SESSION['module']);
            unset($_SESSION['dayTime']);
            //Creates form and input button to reset page. 
            echo "<br><br> <form name = 'return' method = 'post'><input type= 'submit' name='return' value = 'Return to start page'></form>";  
        }
        //Everything has passed and transation can occor updating Student and Practical table. 
        else{
            //Statment to update the spaces avalible in Practical table. 
            $stmt = $pdo->prepare("update Practical set space = space - 1 where module = ? AND dayTime = ?");
            //Statment to insert new touple to the Student table.
            $stmt2 = $pdo->prepare("insert into Student values(?,?,?,?)"); 
            
            //Decreases the number of spaces available for the class .
            $stmt ->execute(array($_SESSION['module'], $_SESSION['dayTime']));

            //Executes statment 
            $stmt2 ->execute(array($_SESSION['email'],$_SESSION['name'],$_SESSION['module'], $_SESSION['dayTime']));
            
            //prints Message to say booking compleate 
            echo "<h2>You have booked the following lab:<br><br>";
            echo $_SESSION['module'], " on ", $_SESSION['dayTime'];
            echo "<br><br>Have a good day!<h2>";
            
            //Ends the session so if they come back there is no information stored on server
            //Doesn't affect the database 
            session_destroy();
            
        }
        //Commit the transfer regradless of whether anything occurred or if we have printed an error message
        $pdo->commit();  

    }
    //Sends error to screen if one occurs when accessing database 
    catch (PDOException $e) {
        
        exit("PDO Error: ".$e->getMessage()."<br>");
        //Rolls back the transaction if error occurred accessing database 
        $pdo->rollBack();
    }
    
}

//Try to connect to database 
try {
    //Setting the pdo for accessing database 
    $pdo = new PDO($dsn,$db_username,$db_password,$opt);

    //The next if statment calls the functions to display the page deppending 
    //on what sessions are stored and if they fullfil regExpCheck  

    //checks if 'book' has been selected and that regExpCheck has returned true 
    if (isset($_POST['book']) and regExpCheck()){
        //runs transaction
        transaction($pdo);
    } 
    //checks if $_SESSION['module'] has been selected, if so runs this section 
    else if (isset($_SESSION['module'])){
        //prepares statement to execute finding the avalible modules with space 
        $modules = $pdo->prepare(
            "select distinct module from Practical where space > 0");
        $modules->execute();
        //prepares statement for finging the available labe for a module and orders by module then dayNoRep
        $lab = $pdo->prepare(
            "select dayTime from Practical where module = ? and space > 0 order by dayNoRep ASC");
        $lab->execute(array($_SESSION['module'])); 
        //print description, table and form 
        printDescription();
        infoTable($pdo);
        printForm1($modules, $lab);
    } else { 
        //prepares statement to execute finding the avalible modules with space
        $modules = $pdo->prepare(
            "select distinct module from Practical where space > 0");
        $modules->execute();
        //Checks there are labs available
        if ($modules->rowCount() > 1){
            //print description, table and form 
            printDescription();
            infoTable($pdo);
            printForm1($modules);
        }
        //if all labs are booked shows message
        else {
            echo "<h2> All the labs for this week have been booked <h2> " ;
        }
    }

} 
//catch and show errors if they occor accessing database
catch (PDOException $e) {
    exit("PDO Error: ".$e->getMessage()."<br>");
}
?>
    </body>
</html>