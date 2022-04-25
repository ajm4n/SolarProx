<?php
    session_id(htmlspecialchars($_COOKIE["SessionID"]));
    session_start();

?>
<!DOCTYPE html>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SolarProx - Admin Home</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Paaji+2:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--- BootStrap --->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="main.css" rel="stylesheet">
    <!-- Local files -->
    <script src="js/Sort.js"></script>

</head>
<body onload="sortTable(0)"> 
	
<form>
  <label for="flag">Flag:</label><br>
  <input type="text" id="flag" name="flag"><br>
  <input type="submit" value="Submit">
</form>


<?php
if ($_SESSION["priv"] == "Admin"){
    echo '
    <div class="container-fluid">
        <div class="row" id="topnav">
            <div class="col-md-3">
                <a class="active" href="./Home_Admin.php">Admin Home</a>
                <a href="./Player.php">Player Info</a>
            </div>
            <div class="col-md-6">
                <h1>SolarProx</h1>
		<h2>Your solution to penetration testing with Proxmox</h2>   
            </div>
            <div class="col-md-3">
                <a style="position: absolute; top: 0px;right: 0px;" href="./logout.php">Logout</a>
            </div>
        </div>
    </div>
    ';
}
if ($_SESSION["priv"] != "Admin"){
    echo '<script> window.location.replace("./Login.php")</script>';
}
?>

<br>
<!--- This is the main content --->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <!--- Do not paste above here. This is for formatting. --->

            <!--- copy from here to the end of the section div to create
            a new category ---->
            <div class="section">

                <h3>Admin Overview</h3>

                <div class="sectionBody">

                <?php


                    chdir("Scripts");

                    $result = shell_exec('bash getAllMachineInfo.sh ');
                    //echo "<pre>$result</pre>";

                    echo '<table id="myTable" style="width: 100%"><tr class="first"><th onclick="sortTable(0)">Box Name</th><th onclick="sortTable(1)">Box Status&emsp;</th><th>Start&emsp;</th><th>Stop&emsp;</th><th>Rollback&emsp;</th></tr>';

                    $BoxList = json_decode($result);
                    $List = $BoxList -> data;
                    foreach($List as $Box){
                        $BoxID = $Box -> vmid;
                        $start = 'start'.$BoxID;
                        $stop = 'stop'.$BoxID;
                        $rollback = 'rollback'.$BoxID;
			$submit = 'submit'.$BoxID;
                        if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST[$start]))
                                {
                            start($BoxID);
                            }
                        if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST[$stop]))
                                {
                            stop($BoxID);
                            }
                        if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST[$rollback]))
                                {
                            rollback($BoxID);
                            }
			if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST[$submit]))
                                {
                            submit($BoxID);
                            }
                        echo "<tr>";

                        echo "<td>";
                        echo $Box -> name;
                        echo "</td>";

                        echo "<td>";
                        echo $Box -> status;
                        echo "</td>";

                        

                        $button1 =  "<td><form action='Home_Admin.php' method='post'><input type='submit' name='".$start."' value='Start' /></form></td>";
                        $button2 =  "<td><form action='Home_Admin.php' method='post'><input type='submit' name='".$stop."' value='Stop' /></form></td>";
                        $button3 =  "<td><form action='Home_Admin.php' method='post'><input type='submit' name='".$rollback."' value='Rollback' /></form></td>";
			$button4 =  "<td><form action='Home_Admin.php' method='post'><input type='submit' name='".$submit."' value='Submit' /></form></td>";
                        echo $button1;
                        echo $button2;
                        echo $button3;
			echo $button4;

                        

                        echo "</tr>";
                    }
                    echo "</table>";

                    function start($id)
                        {
                            $command = 'bash start.sh  '.$id;
                            shell_exec($command);
                            echo "<script>window.location = window.location.href;</script>";
                        }
                    function stop($id)
                        {
                            $command = 'bash stop.sh  '.$id;
                            shell_exec($command);
                            echo "<script>window.location = window.location.href;</script>";
                        }
                    function rollback($id)
                        {
                            $command = 'bash rollback.sh  '.$id.' base';
                            shell_exec($command);
                            echo "<script>window.location = window.location.href;</script>";
                        }

                ?>

                </div>
                <br>
            </div>
            <!---end of Category --->

            <!--- DO NOT EDIT BELOW HERE. This is for formatting--->
            </div>
            <br>
        </div>
    </div>
</div>
</body>
</html>
