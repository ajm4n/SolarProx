<?php
$servername = "localhost";
$username = "root";
$password = "3mJw4/LwD$Ueuk!Z";
$dbname = "solarauth";

<<<<<<< HEAD
<!DOCTYPE html>
<html>
<head>
    <title>Read Data From Database Using PHP - Demo Preview</title>
    <meta content="noindex, nofollow" name="robots">
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="maindiv">
    <div class="divA">
        <div class="title">
            <h2>Read Data Using PHP</h2>
        </div>
        <div class="divB">
            <div class="divD">
                <p>Click On Menu</p>
                <?php

		ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

                $connection = mysql_connect("localhost", "root", "3mJw4/LwD$Ueuk!Z"); // Establishing Connection with Server
                $db = mysql_select_db("solarauth", $connection); // Selecting Database
                //MySQL Query to read data
                $query = mysql_query("select * from Users", $connection);
                while ($row = mysql_fetch_array($query)) {
                    echo "<b><a href="readphp.php?id={$row['username']}">{$row['id']}</a></b>";
echo "<br />";
}
                ?>
            </div>
            <?php
            if (isset($_GET['username'])) {
                $id = $_GET['username'];
                $query1 = mysql_query("select * from employee where username=$id", $connection);
                while ($row1 = mysql_fetch_array($query1)) {
                    ?>
                    <div class="form">
                        <h2>---Details---</h2>
                        <!-- Displaying Data Read From Database -->
                        <span>Name:</span> <?php echo $row1['username']; ?>
                        <span>Date created:</span> <?php echo $row1['created_at']; ?>
                        <span>ID</span> <?php echo $row1['id']; ?>
                    </div>
                    <?php
                }
            }
            ?>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<?php
mysql_close($connection); // Closing Connection with Server
?>
</body>
</html>
=======
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
>>>>>>> 8a572cf8588e1e3a6dbe4a2f1ed06de329474d00
