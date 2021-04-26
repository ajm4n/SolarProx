<?php
session_id(htmlspecialchars($_COOKIE["SessionID"]));
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SolarProx - Home</title>
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


</head>
<body> <!-- hardcoded to blue to override boostrap --->

<?php

if ($_SESSION["priv"] == "Admin") {
    echo '
                <div class="topnav">
                <a href="./Home_Admin.php">Admin Home</a>
                <a class="active" href="./Home.php">Student Home</a>
                <a style="" href="./Login.php">Logout</a>
                <h1>SolarProx</h1>
                <h2>Your solution to penetration testing with Proxmox</h2>
                <br>
                </div>

                ';
} elseif ($_SESSION["priv"] == "User") {
    echo '
                    <div class="topnav">
                    <a class="active" href="./Home.php">Home</a>
                    <a href="./Login.php">Logout</a>
                    <h1>SolarProx</h1>
                    <h2>Your solution to penetration testing with Proxmox</h2>
                    <br>
                    </div>

                ';
} else {
    echo '<script> window.location.replace("./Login.php")</script>';
}
?>

<header class="header">
    <h1>SolarProx</h1>
    <h2>Your solution to penetration testing with Proxmox</h2>
</header>
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

                    $result = shell_exec('./getAllMachineInfo.sh ');
                    //echo "<pre>$result</pre>";

                    echo "<table style='width: 100%'><tr><th>Box Name</th><th>Box Status</th></tr>";

                    $BoxList = json_decode($result);
                    $List = $BoxList->data;
                    foreach ($List as $Box) {
                        $BoxID = $Box->vmid;
                        $start = 'start' . $BoxID;
                        $stop = 'stop' . $BoxID;
                        $rollback = 'rollback' . $BoxID;
                        if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST[$start])) {
                            start($BoxID);
                        }
                        if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST[$stop])) {
                            stop($BoxID);
                        }
                        if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST[$rollback])) {
                            rollback($BoxID);
                        }
                        echo "<tr>";

                        echo "<td>";
                        echo $Box->name;
                        echo "</td>";

                        echo "<td>";
                        echo $Box->status;
                        echo "</td>";

                        echo "<td>";

                        $button1 = "<form action='Home_Admin.php' method='post'><input type='submit' name='" . $start . "' value='Start' /></form>&emsp;";
                        $button2 = "<form action='Home_Admin.php' method='post'><input type='submit' name='" . $stop . "' value='Stop' /></form>&emsp;";
                        $button3 = "<form action='Home_Admin.php' method='post'><input type='submit' name='" . $rollback . "' value='Rollback' /></form>";
                        echo $button1;
                        echo $button2;
                        echo $button3;

                        echo "</td>";

                        echo "</tr>";
                    }
                    echo "</table>";

                    function start($id)
                    {
                        $command = './start.sh  ' . $id;
                        shell_exec($command);
                        echo "<script>window.location = window.location.href;</script>";
                    }

                    function stop($id)
                    {
                        $command = 'bash stop.sh  ' . $id;
                        shell_exec($command);
                        echo "<script>window.location = window.location.href;</script>";
                    }

                    function rollback($id)
                    {
                        $command = 'bash rollback.sh  ' . $id . ' base';
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
</body>
</html>
