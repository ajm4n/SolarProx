<?php

ini_set('display_errors', 1); error_reporting(-1);

//include config file

require_once "config.php";


//define variables and initialize with empty values

$flagdata = "";

$flagdata_err = "";

//process form data

if($_SERVER["REQUEST_METHOD"] == "POST"{

    //validate flag data
    if(empty(trim($_POST["flagdata"]))){
        $flagdata_err = "Please submit a flag";
    }
    else{

        if (md5($flagdata) == md5_file(flagdata.txt))  { //check if flag matches
            //prepare a compare statement
            $sql = "UPDATE solarauth SET score = score + 1 WHERE username = '" . $_SESSION['username'] ."'";

            if ($stmt = mysqli_prepare($link, $sql)) {
                //bind variables to prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_flagdata );

            //set parameters

            $param_flagdata = trim($_POST["flagdata"]);

            //attempt to execute prepared statement

                if(mysqli_stmt_store_result($stmt)){
                    /* store result */
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) == 1){
                        $flagdata_err = "Flag already submitted";

                    } else{

                        $flagdata = trim($_POST["flagdata"]);

                    }

                } else {
                    echo "Oops! Something went wrong, please try again later.";
                }
                //close statement

                mysqli_stmt_close($stmt);
            }
        }
    }

}
?> //end php


<!DOCTYPE html>
<html>

<style>
    body{ font: 14px sans-serif; }
    .wrapper{ width: 360px; padding: 20px; }
</style>

<head>
    <title>Scoring Beta page</title>
</head>

<body>

<h3>Scoring beta!</h3>


<div class="form-group">
    <label>Enter score</label>
    <input type="text" name="flagdata" class="form-control <?php echo (!empty($flagdata_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $flagdata; ?>">
    <span class="invalid-feedback"><?php echo $flagdata_err; ?></span>
</div>
<div class="form-group">
    <input type="submit" class="btn btn-primary" value="Submit">
</div>
</body>

</html>
