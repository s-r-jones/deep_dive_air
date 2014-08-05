<?php
    // require the classes needed
    require_once("login.php");
    
    try
    {
        //enable exception handling
        mysqli_report(MYSQLI_REPORT_STRICT);
        
        // connect to mySQL
        $mysqli = new mysqli("localhost", "air_samj", "felonahhan45th", "air_samj");
        
        // get the users email from mySQL and the input email
        $login = Login::getLoginByEmail($mysqli, $_POST["loginEmail"]);
        
        // get the user's salt
        $loginSalt = $login->getSalt();
        
        // remake the hash and get the users password for comparison
        $inputPassword = hash_pbkdf2("sha512", $_POST["loginPassword"], $loginSalt, 2050);
        $loginPassword = $login->getPassword();
        
        // now compare the input password and login password to verify login
        if($inputPassword === $loginPassword)
        {
            header("location:/profile.html");
        }
        else
        {
            echo "Your password or email must be incorrect!";
        }
    }
    catch(mysqli_sql_exception $exception)
    {
        echo "Exception " . $exception->getMessage();
    }
    
?>