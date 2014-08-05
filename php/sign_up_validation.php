<?php
    // require the class or classes to be used
    require_once("profile.php");
    require_once("login.php");
    
    try
    {
        //enable exception handling
        mysqli_report(MYSQLI_REPORT_STRICT);
        
        // connect to mySQL
        $mysqli = new mysqli("localhost", "air_josephp", "felonahhan45th", "air_josephp");
        
        // salt for password
        $salt = bin2hex(openssl_random_pseudo_bytes(32));
        
        // hash the password with salt
        $password = $_POST["confirmSignUpPassword"];
        $hashedPassword = hash_pbkdf2("sha512", $password, $salt, 2050);
        
        // assign to the date for mySQL
        $dateOfBirth = $_POST["dateOfBirthYear"] . "-" . $_POST["dateOfBirthMonth"] . "-" . $_POST["dateOfBirthDay"];
        
        // create a login before profile
        $login = new Login(null, $_POST["contactEmail"], $hashedPassword, $salt);
        $login->insert($mysqli);
        
        // now create the profile
        $profile = new Profile(null, $dateOfBirth, $_POST["firstName"], $_POST["lastName"], $_POST["signUpPhoneNumber"], $login->getId());
        
        // insert into mySQL
        $profile->insert($mysqli);
        
        // echo the result to the user
        echo "You've successfully signed up!";
        
        //clean up the mySQLi connection
        $mysqli->close();
    }
    catch(mysqli_sql_exception $exception)
    {
        echo "Exception " . $exception->getMessage();
    }
?>