<?php
$servername = "localhost";
$username = "root";
$password = "3mJw4/LwD$Ueuk!Z";
$dbname = "solarauth";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$db_username = $_GET["Username"];

$sql = "SELECT id, username, created_at FROM Users WHERE username = $db_username";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["created_at"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>