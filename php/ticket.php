<?php
    /**
     * class for ticket
     *
     * This class represents ticket info such as time/date, seat,
     * price, ticket number, profile id, flight number.
     *
     * 
    **/
    class Ticket
    {
        /**
         * mySQL primary key and foreign key for ticket
         * @see Flight
        **/
        protected $flightNumber;
        /**
         * mySQL primary key and foreign key for ticket
         *
         * @see Profile
        **/
        protected $profileId;
        /**
         * ticket date and time
        **/
        protected $dateTime;
        /**
         * ticket price
        **/
        protected $price;
        /**
         * ticket seat
        **/
        protected $seat;
        /**
         * ticket number
        **/
        protected $ticketNumber;
        
        /**
         * constructor for ticket
         *
         * @param integer new value of flight number
         * @param integer new value of profile id
         * @param integer new value of date time
         * @param integer new value of price
         * @param string new value of seat
         * @param integer new value of ticket number
         * @throws RuntimeException if invalid inputs detected
        **/
        public function __construct($newFlightNumber, $newProfileId, $newDateTime, $newPrice, $newSeat, $newTicketNumber)
        {
            try
            {
                $this->setFlightNumber($newFlightNumber);
                $this->setProfileId($newProfileId);
                $this->setDateTime($newDateTime);
                $this->setPrice($newPrice);
                $this->setSeat($newSeat);
                $this->setTicketNumber($newTicketNumber);
            }
            catch(RuntimeException $exception)
            {
                throw(new RuntimeException("Unable to build ticket", 0, $exception));
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
         * accessor method for profile id
         *
         * @return integer value of profile id
        **/
        public function getProfileId()
        {
            return($this->profileId);
        }
        
        /**
         * mutator method for profile id
         *
         * @param integer new value for profile id
         * @throws RangeException if profile id is negative
         * @throws UnexpectedValueException if profile id is invalid
        **/
        public function setProfileId($newProfileId)
        {
            // first scrub out the obvious trash
            $newProfileId = htmlspecialchars($newProfileId);
            $newProfileId = trim($newProfileId);
            
            // second verify it's numeric
            if(is_numeric($newProfileId) === false)
            {
                throw(new UnexpectedValueException("Invalid flight number: $newProfileId"));
            }
            
            // third, convert it and verify it's in range
            $newProfileId = intval($newProfileId);
            if($newProfileId < 0)
            {
                throw(new RangeException("Invalid flight number: $newProfileId"));
            }
            
            // finally, it's cleansed - assign it to the object
            $this->profileId = $newProfileId;
        }
        
        /**
         * accessor method for date and time
         *
         * @return integer value of date and time
        **/
         public function getDateTime()
        {
            return($this->dateTime);
        }
        
        /**
         * mutator method for date and time
         *
         * @param mixed DateTime object mySQL date string, or null
         * @throws InvalidArgumentException if the input is none of these
        **/
        public function setDateTime($newDateTime)
        {   
            // if the input is a DateTime object, just assign it
            if(gettype($newDateTime) === "object")
            {
                // ensure this is a DateTime first!
                if(get_class($newDateTime) === "DateTime")
                {
                    $this->dateTime = $newDateTime;
                    return;
                }
                else
                {
                    throw(new InvalidArgumentException("Invalid object, expected type DateTime but got " . get_class()));
                }
            }
            
            // if the input is string, parse the date
            $newDateTime = htmlspecialchars($newDateTime);
            $newDateTime = trim($newDateTime);
            $newDateTime = DateTime::createFromFormat("Y-m-d H:i:s", $newDateTime);
            
            if($newDateTime === false)
            {
                throw(new InvalidArgumentException("Invalid date detected: $newDateTime"));
            }
            
            // date sanitized: assign it
            $this->dateTime = $newDateTime;
        }
        
        /**
         * accessor method for price
         *
         * @return integer value of price
        **/
        public function getPrice()
        {
            return($this->price);
        }
        
        /**
         * mutator method for price
         *
         * @param integer new value for ticket
         * @throws RangeException if price is negative
         * @throws UnexpectedValueException if price is invalid
        **/
        public function setPrice($newPrice)
        {
            // first scrub out the obvious trash
            $newPrice = htmlspecialchars($newPrice);
            $newPrice = trim($newPrice);
            
            // second verify it's numeric
            if(is_numeric($newPrice) === false)
            {
                throw(new UnexpectedValueException("Invalid price: $newPrice"));
            }
            
            // third, convert it and verify it's in range
            $newPrice = intval($newPrice);
            if($newPrice < 0)
            {
                throw(new RangeException("Invalid price: $newPrice"));
            }
            
            // finally, it's cleansed - assign it to the object
            $this->price = $newPrice;
        }
        
        /**
         * accessor method for seat
         *
         * @return string value of seat
        **/
        public function getSeat()
        {
            return($this->seat);
        }
        
        /**
         * mutator method for seat
         *
         * @param string new value for seat
         * @throws UnexpectedValueException if seat is empty
        **/
        public function setSeat($newSeat)
        {
            // first scrub out the obvious trash
            $newSeat = htmlspecialchars($newSeat);
            $newSeat = trim($newSeat);
            
            // second verify the variable has something left
            if(empty($newSeat) === true)
            {
                throw(new UnexpectedValueException("Invalid seat"));
            }
            
            // finally it's cleansed - assign it to the object
            $this->seat = $newSeat;
        }
        
        /**
         * accessor method for ticket number
         *
         * @return integer value of ticket number
        **/
        public function getTicketNumber()
        {
            return($this->ticketNumber);
        }
        
        /**
         * mutator method for ticket number
         *
         * @param integer new value for ticket number
         * @throws RangeException if ticket number is negative
         * @throws UnexpectedValueException if ticket number is invalid
        **/
        public function setTicketNumber($newTicketNumber)
        {
            // first scrub out the obvious trash
            $newTicketNumber = htmlspecialchars($newTicketNumber);
            $newTicketNumber = trim($newTicketNumber);
            
            // second verify it's numeric
            if(is_numeric($newTicketNumber) === false)
            {
                throw(new UnexpectedValueException("Invalid ticket number: $newTicketNumber"));
            }
            
            // third convert it and verify it's in range
            $newTicketNumber = intval($newTicketNumber);
            if($newTicketNumber < 0)
            {
                throw(new RangeException("Invalid ticket number: $newTicketNumber"));
            }
            
            // finally it's cleansed - assign it to the object
            $this->ticketNumber = $newTicketNumber;
        }
        
        /**
         * deletes this ticket from mySQL
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
            if($this->getFlightNumber() === null)
            {
                throw(new mysqli_sql_exception("New flight number detected"));
            }
            
            // create a query template
            $query = "DELETE FROM ticket WHERE flightNumber = ?";
            
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
         * inserts this ticket into mySQL
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
            $query = "INSERT INTO ticket(flightNumber, profileId, dateTime, price, seat, ticketNumber) VALUES(?, ?, ?, ?, ?, ?)";
            
            // prepare the query statement
            $statement = $mysqli->prepare($query);
            if($statement === false)
            {
                throw(new mysqli_sql_exception("Unable to prepare statement"));
            }
            
            // bind parameters to the query template
            $wasClean = $statement->bind_param("iiiisi", $this->flightNumber, $this->profileId, $this->dateTime, $this->price, $this->seat, $this->ticketNumber);
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
         * updates this ticket in mySQL
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
            $query = "UPDATE flight SET flightNumber = ?, profileId = ?, dateTime = ?, price = ?, seat = ?, ticketNumber = ? WHERE flightNumber = ?";
            
            // prepare the query statement
            $statement = $mysqli->prepare($query);
            if($statement === false)
            {
                throw(new mysqli_sql_exception("Unable to prepare statement"));
            }
            
            // bind parameters to the query template
            $wasClean = $statement->bind_param("iiiisii", $this->flightNumber, $this->profileId, $this->dateTime, $this->price, $this->seat, $this->ticketNumber, $this->flightNumber);
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
         * retrieves a ticket from mySQL based on flight number
         *
         * @param resource pointer to mySQLi connection, by reference
         * @param integer flight number to search for
         * @throws mysqli_sql_exception when mySQL errors occur
        **/
        public static function getTicketByFlightNumber(&$mysqli, $flightNumber)
        {
            // handle degenerate cases: bad mySQLi pointer
            if(is_object($mysqli) === false || get_class($mysqli) !== "mysqli")
            {
                throw(new mysqli_sql_exception("Not a mySQLi object"));
            }
            
            // handle degenerate cases: bad id
            if(is_numeric($flightNumber) === false)
            {
                throw(new mysqli_sql_exception("Non numeric flight number detected"));
            }
            
            // finalize the sanitization on the id
            $flightNumber = trim($flightNumber);
            $flightNumber = intval($flightNumber);
            
            // create a query template
            $query = "SELECT flightNumber, profileId, dateTime, price, seat, ticketNumber FROM ticket WHERE flightNumber = ?";
            
            // prepare the query statement
            $statement = $mysqli->prepare($query);
            if($statement === false)
            {
                throw(new mysqli_sql_exception("Unable to prepare statement"));
            }
            
            // bind parameters to the query template
            $wasClean = $statement->bind_param("i", $flightNumber);
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
                throw(new mysqli_sql_exception("No result found for $flightNumber"));
            }
            
            // fetch the row we get from mySQL
            $row = $result->fetch_assoc();
            
            // create an object out of it
            $ticket = new Ticket($row["flightNumber"], $row["profileId"], $row["dateTime"], $row["price"], $row["seat"], $row["ticketNumber"]);
            
            // free the result
            $result->free();
            
            // close the statement
            $statement->close();
            
            // return the object
            return($ticket);
        }
        
        /**
         * retrieves a ticket from mySQL based on profile id
         *
         * @param resource pointer to mySQLi connection, by reference
         * @param integer profile id to search for
         * @throws mysqli_sql_exception when mySQL errors occur
        **/
        public static function getTicketByProfileId(&$mysqli, $profileId)
        {
            // handle degenerate cases: bad mySQLi pointer
            if(is_object($mysqli) === false || get_class($mysqli) !== "mysqli")
            {
                throw(new mysqli_sql_exception("Not a mySQLi object"));
            }
            
            // handle degenerate cases: bad id
            if(is_numeric($profileId) === false)
            {
                throw(new mysqli_sql_exception("Non numeric profile id detected"));
            }
            
            // finalize the sanitization on the id
            $profileId = trim($profileId);
            $profileId = intval($profileId);
            
            // create a query template
            $query = "SELECT flightNumber, profileId, dateTime, price, seat, ticketNumber FROM ticket WHERE profileId = ?";
            
            // prepare the query statement
            $statement = $mysqli->prepare($query);
            if($statement === false)
            {
                throw(new mysqli_sql_exception("Unable to prepare statement"));
            }
            
            // bind parameters to the query template
            $wasClean = $statement->bind_param("i", $profileId);
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
                throw(new mysqli_sql_exception("No result found for $profileId"));
            }
            
            // fetch the row we get from mySQL
            $row = $result->fetch_assoc();
            
            // create an object out of it
            $ticket = new Ticket($row["flightNumber"], $row["profileId"], $row["dateTime"], $row["price"], $row["seat"], $row["ticketNumber"]);
            
            // free the result
            $result->free();
            
            // close the statement
            $statement->close();
            
            // return the object
            return($ticket);
        }
    }
?>