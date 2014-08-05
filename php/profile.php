<?php
    /**
     * class for profile
     *
     * This class represents profile info such as name, special needs,
     * birthday, etc.
     *
     * >
    **/
    class Profile
    {
        /**
         * mySQL primary key for profile
        **/
        protected $id;
        /**
         * profile birthday
        **/
        protected $dateOfBirth;
        /**
         * profile first name
        **/
        protected $firstName;
        /**
         * profile last name
        **/
        protected $lastName;
        /**
         * profile phone number
        **/
        protected $phoneNumber;
        /**
         * profile user id
         * @see Login
        **/
        protected $userId;
        
        /**
         * contructor for profile
         *
         * @param integer new value of id
         * @param integer new value of date of birth
         * @param string new value of first name
         * @param string new value of last name
         * @param string new value of phone number
         * @param integer new value of userId
         * @throws RuntimeException if invalid inputs detected
        **/
        public function __construct($newId, $newDateOfBirth, $newFirstName, $newLastName, $newPhoneNumber, $newUserId)
        {
            try
            {
                $this->setId($newId);
                $this->setDateOfBirth($newDateOfBirth);
                $this->setFirstName($newFirstName);
                $this->setLastName($newLastName);
                $this->setPhoneNumber($newPhoneNumber);
                $this->setUserId($newUserId);
            }
            catch(RuntimeException $exception)
            {
                throw(new RuntimeException("Unable to build profile", 0, $exception));
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
         * accessor method for date of birth
         *
         * @return integer value of date of birth
        **/
         public function getDateOfBirth()
        {
            return($this->dateOfBirth);
        }
        
        /**
         * mutator method for date of birth
         *
         * @param mixed DateTime object mySQL date string, or null
         * @throws InvalidArgumentException if the input is none of these
        **/
        public function setDateOfBirth($newDateOfBirth)
        {   
            // if the input is a DateTime object, just assign it
            if(gettype($newDateOfBirth) === "object")
            {
                // ensure this is a DateTime first!
                if(get_class($newDateOfBirth) === "DateTime")
                {
                    $this->dateOfBirthday = $newDateOfBirth;
                    return;
                }
                else
                {
                    throw(new InvalidArgumentException("Invalid object, expected type DateTime but got " . get_class()));
                }
            }
            
            // if the input is string, parse the date
            $newDateOfBirth = htmlspecialchars($newDateOfBirth);
            $newDateOfBirth = trim($newDateOfBirth);
            $newDateOfBirth = DateTime::createFromFormat("Y-m-d", $newDateOfBirth);
            
            if($newDateOfBirth === false)
            {
                throw(new InvalidArgumentException("Invalid date detected: $newDateOfBirth"));
            }
            
            // date sanitized: assign it
            $this->dateOfBirth = $newDateOfBirth;
        }
        
        /**
         * accessor method for first name
         *
         * @return string value of first name
        **/
        public function getFirstName()
        {
            return($this->firstName);
        }
        
        /**
         * mutator method for first name
         *
         * @param string new value for first name
         * @throws UnexpectedValueException if first name is empty
        **/
        public function setFirstName($newFirstName)
        {
            // first scrub out the obvious trash
            $newFirstName = htmlspecialchars($newFirstName);
            $newFirstName = trim($newFirstName);
            
            // second, verify the variable has something left
            if(empty($newFirstName) === true)
            {
                throw(new UnexpectedValueException("Invalid first name"));
            }
            
            // finally, it's cleansed - assign it to the object
            $this->firstName = $newFirstName;
        }
        
        /**
         * accessor method for last name
         *
         * @return string value of last name
        **/
        public function getLastName()
        {
            return($this->lastName);
        }
        
        /**
         * mutator method for last name
         *
         * @param string new value for last name
         * @throws UnexpectedValueException if last name is empty
        **/
        public function setLastName($newLastName)
        {
            // scrub out the obvious trash
            $newLastName = htmlspecialchars($newLastName);
            $newLastName = trim($newLastName);
            
            // second verify the variable has something left
            if(empty($newLastName) === true)
            {
                throw(new UnexpectedValueException("Invalid last name"));
            }
            
            // finally, it's cleansed - assign it to the object
            $this->lastName = $newLastName;
        }
        
        /**
         * accesor method for phone number
         *
         * @return string value of phone number
        **/
        public function getPhoneNumber()
        {
            return($this->phoneNumber);
        }
        
        /**
         * mutator method for phone number
         *
         * @param string new value for phone number
         * @throws UnexpectedValueException if phone number is empty
        **/
        public function setPhoneNumber($newPhoneNumber)
        {
            // first scrub out the obvious trash
            $newPhoneNumber = htmlspecialchars($newPhoneNumber);
            $newPhoneNumber = trim($newPhoneNumber);
            
            // second verify the variable has something left
            if(empty($newPhoneNumber) === true)
            {
                throw(new UnexpectedValueException("Invalid phone number"));
            }
            
            // finally, it's cleansed - assign it to the object
            $this->phoneNumber = $newPhoneNumber;
        }
        
        /**
         * accessor method for userId
         *
         * @return integer value of userId
        **/
        public function getUserId()
        {
            return($this->userId);
        }
        
        /**
         * mutator method for userId
         *
         * @param integer new value for userId
         * @throws UnexpecetedValueException if userId is invalid
         * @throws RangeException if userId is negative
        **/
        public function setUserId($newUserId)
        {
            // first scrub out the obvious trash
            $newUserId = htmlspecialchars($newUserId);
            $newUserId = trim($newUserId);
            
            // second verify it's numeric
            if(is_numeric($newUserId) === false)
            {
                throw(new UnexpectedValueException("Invalid user id: $newUserId"));
            }
            
            // third convert it and verify it's in range
            $newUserId = intval($newUserId);
            if($newUserId < 0)
            {
                throw(new RangeException("Invalid user id : $newUserId"));
            }
            
            // finally, it's cleansed - assign it to the object
            $this->userId = $newUserId;
        }
        
        /**
         * deletes this profile from mySQL
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
            $query = "DELETE FROM profile WHERE id = ?";
            
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
         * inserts this profile into mySQL
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
            $query = "INSERT INTO profile(dateOfBirth, firstName, lastName, phoneNumber, userId) VALUES(?, ?, ?, ?, ?)";
            
            // prepare the query statement
            $statement = $mysqli->prepare($query);
            if($statement === false)
            {
                throw(new mysqli_sql_exception("Unable to prepare statement"));
            }
            
            // bind parameters to the query template
            $formattedDate = $this->dateOfBirth->format("Y-m-d");
            $wasClean = $statement->bind_param("ssssi", $formattedDate, $this->firstName, $this->lastName, $this->phoneNumber, $this->userId);
            if($wasClean === false)
            {
                throw(new mysqli_sql_exception("Unable to bind parameters"));
            }
            
            // execute the statement
            if($statement->execute() === false)
            {
                echo $statement->error . "<br/>";
                throw(new mysqli_sql_exception("Unable to execute statement"));
            }
            
            // update the id
            $this->setId($mysqli->insert_id);
            
            // free the statement
            $statement->close();
        }
        
        /**
         * updates this profile in mySQL
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
            $query = "UPDATE profile SET id = ?, dateOfBirth = ?, firstName = ?, lastName = ?, phoneNumber = ? WHERE id = ?";
            
            // prepare the query statement
            $statement = $mysqli->prepare($query);
            if($statement === false)
            {
                throw(new mysqli_sql_exception("Unable to prepare statement"));
            }
            
            // bind parameters to the query template
            $formattedDate = $this->dateOfBirth->format("Y-m-d");
            $wasClean = $statement->bind_param("issssss", $this->id, $formattedDate, $this->firstName, $this->lastName, $this->phoneNumber, $this->id);
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
         * retrieves a profile from mySQL based on id
         *
         * @param resource pointer to mySQLi connection, by reference
         * @param integer id to search for
         * @throws mysqli_sql_exception when mySQL errors occur
        **/
        public static function getProfileById(&$mysqli, $id)
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
            $query = "SELECT id, dateOfBirth, firstName, lastName, phoneNumber, userId FROM profile WHERE id = ?";
            
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
            $profile = new Profile($row["id"], $row["dateOfBirth"], $row["firstName"], $row["lastName"], $row["phoneNumber"], $row["userId"]);
            
            // free the result
            $result->free();
            
            // close the statement
            $statement->close();
            
            // return the object
            return($profile);
        }
    }
?>