<?php

/*
 * Database Class
 * 
 * @package		php
 * @category	Database Handling
 * @author		Richard Dahlgren
 */
class database {
	private $dbUrl;
        private $dbUser;
        private $dbPassword;
        private $dbDatabase;
	private $connection;

	/*
	 * Constructor
	 * 
	 */
	public function __construct($url, $user, $password, $database) {
                $this->dbUrl = $url;
                $this->dbUser = $user;
                $this->dbPassword = $password;
                $this->dbDatabase = $database;
		$this->establishConnection();
	}
	
	// --------------------------------------------------------------------------------------------------------------------------------------------------------
	
	/*
	 * Establish Connection
	 * 
	 * Establishes a connection to the database
	 * 
	 * @access	private
	 */
	private function establishConnection() {
		$this->connection = mysql_connect($this->dbUrl, $this->dbUser, $this->dbPassword);
		if (!$this->connection) {
			die("Failed to connect to database!");
		}
		if (!mysql_select_db($this->dbDatabase, $this->connection)) {
			die("Failed to select database!");
		}
	}
	
	/*
	 * Get MySQL link
	 * 
	 * Fetch the established MySQL link
	 * 
	 * @access	public
	 * @return	MySQL link
	 */
	public function getConnection() {
		return $this->connection;
	}
	
	/*
	 * Close MySQL link
	 * 
	 * Close the already open MySQL link
	 * 
	 * @access	public
	 * @return	MySQL link
	 */
	public function closeConnection() {
		mysql_close($this->connection);
	}
}

?>