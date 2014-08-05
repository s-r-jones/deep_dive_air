<?php
    /**
     *
     * class for flights
     *
     * This class represents flight info such as flight destination,
     * flight departure, and flight number.
     *
     * @author Joseph Perez <josephperez717@gmail.com>
     **/
    class Flight
    {
        /**
         * mySQL primary key for flight
        **/
        protected $flightNumber;
        /**
         * flight departure location
        **/
        protected $flightDeparture;
        /**
         * flight destination location
        **/
        protected $flightDestination;
        
        /**
         * constructor for the flight
         *
         * @param integer new value of flight number
         * @param string new value of flight departure
         * @param string  new value of flight destination
         * @throws RuntimeException if invalid inputs detected
        **/
        public function __construct($newFlightNumber, $newFlightDeparture, $newFlightDestination)
        {
            try
            {
               $this->setFlightNumber($newFlightNumber);
               $this->setFlightDeparture($newFlightDeparture);
               $this->setFlightDestination($newFlightDestination);
            }
            catch(RuntimeException $exception)
            {
                throw(new RuntimeException("Unable to build flight", 0, $exception));
            }
        }
        
        /**
         * accessor method for flight number
         *
         * @return integer value of flight number
        **/
        public function getFlightNumber()
        {
            return($this->flightNumber);
        }
        
        /**
         * mutator method for flight number
         *
         * @param integer new value for flight number
         * @throws RangeException if flight number is negative
         * @throws UnexpectedValueException if flight number is invalid
        **/
        public function setFlightNumber($newFlightNumber)
        {
            // first scrub out the obvious trash
            $newFlightNumber = htmlspecialchars($newFlightNumber);
            $newFlightNumber = trim($newFlightNumber);
            
            // second verify it's numeric
            if(is_numeric($newFlightNumber) === false)
            {
                throw(new UnexpectedValueException("Invalid flight number: $newFlightNumber"));
            }
            
            // third, convert it and verify it's in range
            $newFlightNumber = intval($newFlightNumber);
            if($newFlightNumber < 0)
            {
                throw(new RangeException("Invalid flight number: $newFlightNumber"));
            }
            
            // finally, it's cleansed - assign it to the object
            $this->flightNumber = $newFlightNumber;
        }
        
        /**
         * accessor method for flight departure
         *
         * @return string value of flight departure
        **/
        public function getFlightDeparture()
        {
            return($this->flightDeparture);
        }
        
        /**
         * mutator method for flight departure
         *
         * @param string new value of flight departure
         * @throws UnexpectedValueException if flight departure is empty
        **/
        public function setFlightDeparture($newFlightDeparture)
        {
            // first scrub out the obvious trash
            $newFlightDeparture = htmlspecialchars($newFlightDeparture);
            $newFlightDeparture = trim($newFlightDeparture);
            
            // second verify the variable still has something left
            if(empty($newFlightDeparture) === true)
            {
                throw(new UnexpectedValueException("Invalid flight departure"));
            }
            
            // finally it's cleansed - assign it to the object
            $this->flightDeparture = $newFlightDeparture;
        }
        
        /**
         * accessor method for flight destination
         *
         * @return string value of flight destination
        **/
        public function getFlightDestination()
        {
            return($this->flightDestination);
        }
        
        /**
         * mutator method for flight destination
         *
         * @param string new value of flight departure
         * @throws UnexpectedValueException if flight destination is empty
        **/
        public function setFlightDestination($newFlightDestination)
        {
            // first scrub out the obvious trash
            $newFlightDestination = htmlspecialchars($newFlightDestination);
            $newFlightDestination = trim($newFlightDestination);
            
            // second verify the variable still has something left
            if(empty($newFlightDestination) === true)
            {
                throw(new UnexpectedValueException("Invalid flight destination"));
            }
            
            // finally it's cleansed - assign it to the object
            $this->flightDestination = $newFlightDestination;
        }
        
        /**
         * deletes this Flight from mySQL
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
            
            // verify this a new object (where flight number !== null)
            if($this->getFlightNumber() === null)
            {
                throw(new mysqli_sql_exception("New flight number detected"));
            }
            
            // create a query template
            $query = "DELETE FROM flight WHERE flightNumber = ?";
            
            // prepare the query statement
            $statement = $mysqli->prepare($query);
            if($statement === false)
            {
                throw(new mysqli_sql_exception("Unable to prepare statement"));
            }
            
            // bind parameters to the query template
            $wasClean = $statement->bind_param("i", $this->flightNumber);
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
         * inserts this Flight into mySQL
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
            
            // verify this a new object (where flight number === null)
            if($this->getFlightNumber() !== null)
            {
                throw(new mysqli_sql_exception("Non new flight number detected"));
            }
            
            // create a query template
            $query = "INSERT INTO flight(flightNumber, flightDeparture, flightDestination) VALUES(?, ?, ?)";
            
            // prepare the query statement
            $statement = $mysqli->prepare($query);
            if($statement === false)
            {
                throw(new mysqli_sql_exception("Unable to prepare statement"));
            }
            
            // bind parameters to the query template
            $wasClean = $statement->bind_param("iss", $this->flightNumber, $this->flightDeparture, $this->flightDestination);
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
         * updates this Flight in mySQL
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
            
            // verify this an existing object (where flight number !== null)
            if($this->getFlightNumber() === null)
            {
                throw(new mysqli_sql_exception("New flight number detected"));
            }
            
            // create a query template
            $query = "UPDATE flight SET flightNumber = ?, flightDeparture = ?, flightDestination = ? WHERE flightNumber = ?";
            
            // prepare the query statement
            $statement = $mysqli->prepare($query);
            if($statement === false)
            {
                throw(new mysqli_sql_exception("Unable to prepare statement"));
            }
            
            // bind parameters to the query template
            $wasClean = $statement->bind_param("issi", $this->flightNumber, $this->flightDeparture, $this->flightDestination, $this->flightNumber);
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
         * retrieves flights based on departure
         *
         * @param resource pointer to mySQLi connection, by reference
         * @param string make to search for
         * @return mixed array of results or single result
         * @throws mysqli_sql_exception when mySQL errors occur
        **/
        public static function getFlightByDeparture(&$mysqli, $flightDeparture)
        {
            // handle degenerate cases: bad mySQLi pointer
            if(is_object($mysqli) === false || get_class($mysqli) !== "mysqli")
            {
                throw(new mysqli_sql_exception("Not a mySQLi object"));
            }
            
            // handle degenerate cases: nonsensical make
            $flightDeparture = htmlspecialchars($flightDeparture);
            $flightDeparture = trim($flightDeparture);
            if(empty($flightDeparture) === true)
            {
                throw(new mysqli_sql_exception("Invalid flight detected"));
            }
            
            // create a query template
            $query = "SELECT flightNumber, flightDeparture, flightDestination FROM flight WHERE flightDeparture = ?";
            
            // prepare the query statement
            $statement = $mysqli->prepare($query);
            if($statement === false)
            {
                throw(new mysqli_sql_exception("Unable to prepare statement"));
            }
            
            // bind parameters to the query template
            $wasClean = $statement->bind_param("s", $flightDeparture);
            if($wasClean === false)
            {
                throw(new mysqli_sql_exception("Unable to bind parameters"));
            }
            
            // execute the statement
            if($statement->execute() === false)
            {
                throw(new mysqli_sql_exception("Unable to execute statement"));
            }
            
            // validate the result set
            $result = $statement->get_result();
            if($result === false || $result->num_rows === 0)
            {
                throw(new mysqli_sql_exception("Empty result set"));
            }
            
            // loop through the result set
            $resultSet = array();
            while(($row = $result->fetch_assoc()) !== null)
            {
                $nextFlight = new Flight($row["flightNumber"], $row["flightDeparture"], $row["flightDestination"]);
                $resultSet[] = $nextFlight;
            }
            
            // free the result
            $result->free();
            
            // close the statement
            $statement->close();
            
            // if we got only one result, return the single item
            if(count($resultSet) === 1)
            {
                return($resultSet[0]);
            }
            
            // if we got multiple results, just return the array
            if(count($resultSet) > 1)
            {
                return($resultSet);
            }
        }
        
        /**
         * retrieves flights based on destination
         *
         * @param resource pointer to mySQLi connection, by reference
         * @param string destination to search for
         * @return mixed array of results or single result
         * @throws mysqli_sql_exception when mySQL errors occur
        **/
        public static function getFlightByDestination(&$mysqli, $flightDestination)
        {
            // handle degenerate cases: bad mySQLi pointer
            if(is_object($mysqli) === false || get_class($mysqli) !== "mysqli")
            {
                throw(new mysqli_sql_exception("Not a mySQLi object"));
            }
            
            // handle degenerate cases: nonsensical make
            $flightDestination = htmlspecialchars($flightDestination);
            $flightDestination = trim($flightDestination);
            if(empty($flightDestination) === true)
            {
                throw(new mysqli_sql_exception("Invalid flight detected"));
            }
            
            // create a query template
            $query = "SELECT flightNumber, flightDeparture, flightDestination FROM flight WHERE flightDestination = ?";
            
            // prepare the query statement
            $statement = $mysqli->prepare($query);
            if($statement === false)
            {
                throw(new mysqli_sql_exception("Unable to prepare statement"));
            }
            
            // bind parameters to the query template
            $wasClean = $statement->bind_param("s", $flightDestination);
            if($wasClean === false)
            {
                throw(new mysqli_sql_exception("Unable to bind parameters"));
            }
            
            // execute the statement
            if($statement->execute() === false)
            {
                throw(new mysqli_sql_exception("Unable to execute statement"));
            }
            
            // validate the result set
            $result = $statement->get_result();
            if($result === false || $result->num_rows === 0)
            {
                throw(new mysqli_sql_exception("Empty result set"));
            }
            
            // loop through the result set
            $resultSet = array();
            while(($row = $result->fetch_assoc()) !== null)
            {
                $nextFlight = new Flight($row["flightNumber"], $row["flightDeparture"], $row["flightDestination"]);
                $resultSet[] = $nextFlight;
            }
            
            // free the result
            $result->free();
            
            // close the statement
            $statement->close();
            
            // if we got only one result, return the single item
            if(count($resultSet) === 1)
            {
                return($resultSet[0]);
            }
            
            // if we got multiple results, just return the array
            if(count($resultSet) > 1)
            {
                return($resultSet);
            }
        }
    }
?>