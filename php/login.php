<?php
    /**
     *
     * class for login
     *
     * This class represents login info such as salt, id, email, and password.
     *
     * >
    **/
    class Login
    {
        /**
         * mySQL primary key for login
        **/
        protected $id;
        /**
         * login email
        **/
        protected $email;
        /**
         * login password
        **/
        protected $password;
        /**
         * salt
        **/
        protected $salt;
        
        /**
         * constructor for the login
         *
         * @param integer new value of id
         * @param string new value of email
         * @param string new value of password
         * @throws RuntimeException if invalid inputs detected
        **/
        public function __construct($newId, $newEmail, $newPassword, $newSalt)
        {
            try
            {
                $this->setId($newId);
                $this->setEmail($newEmail);
                $this->setPassword($newPassword);
                $this->setSalt($newSalt);
            }
            catch(RuntimeException $exception)
            {
                throw(new RuntimeException("Unable to build login", 0, $exception));
            }
        }
        
        /**
         * accessor method for id
         *
         * @return mixed value of id
        **/
        public function getId()
        {
            return($this->id);
        }
        
        /**
         * mutator method for id
         *
         * @param integer new value for id
         * @throws RangeException if id is negative
         * @throws UnexpectedValueException if id is invalid
        **/
        public function setId($newId)
        {
            // allow id to be null (for new rows)
            if($newId === null)
            {
                $this->id = null;
                return;
            }
            
            // first scrub out the obvious trash
            $newId = htmlspecialchars($newId);
            $newId = trim($newId);
            
            // second, verify it's numeric
            if(is_numeric($newId) === false)
            {
                throw(new UnexpectedValueException("Invalid id: $newId"));
            }
            
            // third, convert it and verify it's in range
            $newId = intval($newId);
            if($newId < 0)
            {
                throw(new RangeException("Invalid id: $newId"));
            }
            
            // finally, it's cleansed - assign it to the object
            $this->id = $newId;
        }
        
        /**
         * accessor method for email
         *
         * @return string value of email
        **/
        public function getEmail()
        {
            return($this->email);
        }
        
        /**
         * mutator method for email
         *
         * @param string new value of email
         * @throws UnexpectedValueException if email is empty
         * @throws UnexpectedValueException if email is not validated
        **/
        public function setEmail($newEmail)
        {
            // first scrub out the obvious trash
            $newEmail = htmlspecialchars($newEmail);
            $newEmail = trim($newEmail);
            
            // second, verify the variable still has something left
            if(empty($newEmail) === true)
            {
                throw(new UnexpectedValueException("Invalid email"));
            }
            
            // third, sanitize and validate email
            $newEmail = filter_var($newEmail, FILTER_SANITIZE_EMAIL);
            if(filter_var($newEmail, FILTER_VALIDATE_EMAIL) === false)
            {
                throw(new UnexpectedValueException("Failed to validate email: $newEmail"));
            }
            
            // finally it's cleansed - assign it to the object
            $this->email = $newEmail;
        }
        
        /**
         * accessor method for password
         *
         * @return string value of password
        **/
        public function getPassword()
        {
            return($this->password);
        }
        
        /**
         * mutator method for password
         *
         * @param string new value of password
         * @throws UnexpectedValueException if password is empty
        **/
        public function setPassword($newPassword)
        {
            // first scrub out the obvious trash
            $newPassword = htmlspecialchars($newPassword);
            $newPassword = trim($newPassword);
            
            // second, verify the variable with a regular expression
            if(preg_match("/^[a-fA-F0-9]{128}$/", $newPassword) !== 1)
            {
                throw(new RangeException("Invalid password"));
            }
            
            // finally it's cleansed - assign it to the object
            $this->password = $newPassword;
        }
        
        /**
         * accessor method for salt
         *
         * @return salt
        **/
        public function getSalt()
        {
            return($this->salt);
        }
        
        /**
         * mutator method for salt
         *
         * @param new salt
         * @throws RangeException if it does not macth the regular expression
        **/
        public function setSalt($newSalt)
        {
            // first scrub out the obvious trash
            $newSalt = htmlspecialchars($newSalt);
            $newSalt = trim($newSalt);
            
            // compare to regular expression
            if(preg_match("/^[a-fA-F0-9]{64}$/", $newSalt) !== 1)
            {
                throw(new RangeException("Invalid salt"));
            }
            
            // finally it's cleansed - assign it to the object
            $this->salt = $newSalt;
        }
        
        /**
         * deletes this login from mySQL
         *
         * @param resource pointer to mySQLi connection, by reference
         * @throws mysqli_sql_exception when mySQL errors occur
        **/
        public function delete(&$mysqli)
        {
            //handle degenerate cases
            if(is_object($mysqli) === false || get_class($mysqli) !== "mysqli")
            {
                throw(new mysqli_sql_exception("Not a mySQLi object"));
            }
            
            // verify this a new object (where id !== null)
            if($this->getId() === null)
            {
                throw(new mysqli_sql_exception("New id detected"));
            }
            
            // create a query template
            $query = "DELETE FROM login WHERE id = ?";
            
            // prepare the query statement
            $statement = $mysqli->prepare($query);
            if($statement === false)
            {
                throw(new mysqli_sql_exception("Unable to prepare statement"));
            }
            
            // bind parameters to the query template
            $wasClean = $statement->bind_param("i", $this->id);
            if($wasClean === false)
            {
                throw(new mysqli_sql_exception("Unable to bind parameters"));
            }
            
            // execute the statement
            if($statement->execute() === false)
            {
                throw(new mysqli_sql_exception("Unable to execute statement"));
            }
            
            // free the statement
            $statement->close();
        }
        
        /**
         *
         * inserts this login into mySQL
         *
         * @param resource pointer to mySQLi connection, by reference
         * @throws mysqli_sql_exception when mySQL errors occur
        **/
        public function insert(&$mysqli)
        {
            //handle degenerate cases
            if(is_object($mysqli) === false || get_class($mysqli) !== "mysqli")
            {
                throw(new mysqli_sql_exception("Not a mySQLi object"));
            }
            
            // verify this a new object (where id === null)
            if($this->getId() !== null)
            {
                throw(new mysqli_sql_exception("Non new id detected"));
            }
            
            // create a query template
            $query = "INSERT INTO login(email, password, salt) VALUES(?, ?, ?)";
            
            // prepare the query statement
            $statement = $mysqli->prepare($query);
            if($statement === false)
            {
                throw(new mysqli_sql_exception("Unable to prepare statement"));
            }
            
            // bind parameters to the query template
            $wasClean = $statement->bind_param("sss", $this->email, $this->password, $this->salt);
            if($wasClean === false)
            {
                throw(new mysqli_sql_exception("Unable to bind parameters"));
            }
            
            // execute the statement
            if($statement->execute() === false)
            {
                throw(new mysqli_sql_exception("Unable to execute statement"));
            }
            
            // update the id
            $this->setId($mysqli->insert_id);
            
            // free the statement
            $statement->close();
        }
        
        /**
         * updates this login in mySQL
         *
         * @param resource pointer to mySQL connection by reference
         * @throws mysqli_sql_exception when mySQL errors occur
        **/
        public function update(&$mysqli)
        {
            //handle degenerate cases
            if(is_object($mysqli) === false || get_class($mysqli) !== "mysqli")
            {
                throw(new mysqli_sql_exception("Not a mySQLi object"));
            }
            
            // verify this an existing object (where id !== null)
            if($this->getId() === null)
            {
                throw(new mysqli_sql_exception("New id detected"));
            }
            
            // create a query template
            $query = "UPDATE login SET id = ?, email = ?, password = ?, salt = ? WHERE id = ?";
            
            // prepare the query statement
            $statement = $mysqli->prepare($query);
            if($statement === false)
            {
                throw(new mysqli_sql_exception("Unable to prepare statement"));
            }
            
            // bind parameters to the query template
            $wasClean = $statement->bind_param("isssi", $this->id, $this->email, $this->password, $this->salt, $this->id);
            if($wasClean === false)
            {
                throw(new mysqli_sql_exception("Unable to bind parameters"));
            }
            
            // execute the statement
            if($statement->execute() === false)
            {
                throw(new mysqli_sql_exception("Unable to execute statement"));
            }
            
            // free the statement
            $statement->close();
        }
        
        /**
         * retrieves a login from mySQL based on id
         *
         * @param resource pointer to mySQLi connection, by reference
         * @param integer id to search for
         * @throws mysqli_sql_exception when mySQL errors occur
        **/
        public static function getLoginById(&$mysqli, $id)
        {
            // handle degenerate cases: bad mySQLi pointer
            if(is_object($mysqli) === false || get_class($mysqli) !== "mysqli")
            {
                throw(new mysqli_sql_exception("Not a mySQLi object"));
            }
            
            // handle degenerate cases: bad id
            if(is_numeric($id) === false)
            {
                throw(new mysqli_sql_exception("Non numeric id detected"));
            }
            
            // finalize the sanitization on the id
            $id = trim($id);
            $id = intval($id);
            
            // create a query template
            $query = "SELECT id, email, password, salt FROM login WHERE id = ?";
            
            // prepare the query statement
            $statement = $mysqli->prepare($query);
            if($statement === false)
            {
                throw(new mysqli_sql_exception("Unable to prepare statement"));
            }
            
            // bind parameters to the query template
            $wasClean = $statement->bind_param("i", $id);
            if($wasClean === false)
            {
                throw(new mysqli_sql_exception("Unable to bind parameters"));
            }
            
            // execute the statement
            if($statement->execute() === false)
            {
                throw(new mysqli_sql_exception("Unable to execute statement"));
            }
            
            // get the result & make sure we only get 1 row
            $result = $statement->get_result();
            if($result === false || $result->num_rows !== 1)
            {
                throw(new mysqli_sql_exception("No result found for $id"));
            }
            
            // fetch the row we get from mySQL
            $row = $result->fetch_assoc();
            
            // create an object out of it
            $login = new Login($row["id"], $row["email"], $row["password"], $row["salt"]);
            
            // free the result
            $result->free();
            
            // close the statement
            $statement->close();
            
            // return the object
            return($login);
        }
        
        /**
         * retrieves a login from mySQL based on email
         *
         * @param resource pointer to mySQLi connection, by reference
         * @param string email to search for
         * @throws mysqli_sql_exception when mySQL errors occur
        **/
        public static function getLoginByEmail(&$mysqli, $email)
        {
            // handle degenerate cases: bad mySQLi pointer
            if(is_object($mysqli) === false || get_class($mysqli) !== "mysqli")
            {
                throw(new mysqli_sql_exception("Not a mySQLi object"));
            }
            
            // verify the variable isn't empty
            if(empty($email) === true)
            {
                throw(new mysqli_sql_exception("Empty variable detected"));
            }
            
            // sanitize the email
            $email = htmlspecialchars($email);
            $email = trim($email);
            
            // create a query template
            $query = "SELECT id, email, password, salt FROM login WHERE email = ?";
            
            // prepare the query statement
            $statement = $mysqli->prepare($query);
            if($statement === false)
            {
                throw(new mysqli_sql_exception("Unable to prepare statement"));
            }
            
            // bind parameters to the query template
            $wasClean = $statement->bind_param("s", $email);
            if($wasClean === false)
            {
                throw(new mysqli_sql_exception("Unable to bind parameters"));
            }
            
            // execute the statement
            if($statement->execute() === false)
            {
                throw(new mysqli_sql_exception("Unable to execute statement"));
            }
            
            // get the result & make sure we only get 1 row
            $result = $statement->get_result();
            if($result === false || $result->num_rows !== 1)
            {
                throw(new mysqli_sql_exception("No result found for $email"));
            }
            
            // fetch the row we get from mySQL
            $row = $result->fetch_assoc();
            
            // create an object out of it
            $email = new Login($row["id"], $row["email"], $row["password"], $row["salt"]);
            
            // free the result
            $result->free();
            
            // close the statement
            $statement->close();
            
            // return the object
            return($email);
        }
    }
?>