
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
