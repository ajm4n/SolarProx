
<?php
$servername = "localhost";
$username = "ajman";
$password = "Ajman123!";
$dbname = "solarauth";


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}




//$db_username = $_GET["username"];


$sql = "SELECT id, username, created_at, score FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Name: " . $row["username"]. " " . $row["created_at"]. " - Score:" . $row["score"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();


?>


     <div class="col-md-3">
                <a class="active" href="./Home_Admin.php">Back home</a>
                
            </div>
