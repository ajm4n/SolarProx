<?php
session_start();
setcookie("SessionID", session_id(), time()+3600);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SolarProx - Login</title>
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

<body>
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
            
            
            <?php
            
            if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['User']) and isset($_POST['Pass']))
                        {
                            // using ldap bind
                            $ldaprdn  = "cn={$_POST['User']},cn=Users,dc=prox,dc=corp";    // ldap rdn or dn
                            $ldappass = $_POST['Pass'];  // associated password

                            // connect to ldap server
                            $ldapconn = ldap_connect("ldap://192.168.1.229")
                                or die("Could not connect to LDAP server.");
                            ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
                            

                            if ($ldapconn) {

                                // binding to ldap server
                                $ldapbind = @ldap_bind($ldapconn, $ldaprdn, $ldappass);

                                // verify binding
                                if ($ldapbind) {
                                    echo "LDAP bind successful...";
                                        if ($_POST['User'] == 'administrator'){
                                            echo '<br> Admin';
                                            $_SESSION["priv"] = "Admin";
                                            echo '<script> window.location.replace("./Home_Admin.php")</script>';
                                        }
                                        else{
                                            echo '<br> User';
                                            $_SESSION["priv"] = "User";
                                            echo '<script> window.location.replace("./Home.php")</script>';
                                        }
                                                
                                } else {
                                    echo "LDAP bind failed...";
                                    
                                }

                            }
                        }
            else{
                session_destroy();
                
                
            }
            
            //echo $_SESSION["priv"];
            //echo session_id();

            ?>
            
            <div class="section">
                <h3>Please Authenticate Below</h3>
                <div class="sectionBody">
                    <form action='Login.php' method='post'>
                        <label for="User">Username:</label>
                        <input type="text" id="User" name="User"><br><br>
                        <label for="Pass">Password:</label>
                        <input type="password" id="Pass" name="Pass"><br><br>
                        <input type="submit" value="Login">
			<p>Need to login through a different method? <a href="loginoptions.php">Click here for login options.</a>.</p>
                    </form>
                    
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
