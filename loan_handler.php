<?php

class LoanHandler {
    private $db;
    
    function __construct() {
        $dbconfig = include('dbconfig.php');
        
        $dbhost = $dbconfig['dbhost'];
        $dbusername = $dbconfig['dbusername'];
        $dbpassword = $dbconfig['dbpassword'];
        $dbname = $dbconfig['dbname'];
        
        $this->db = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
    }
    
    function __destruct() {
        if($this->db && $this->db->ping()) {
            $this->db->close();
        }
    }
    
    function processLoan($amount, $value, $ssn) {
        $ltv = $amount*100/$value;
        
        $status = $ltv > 40 ? 'denied' : 'approved';
        
        $this->saveLoan($status, $amount, $value, $ssn);
        
        return $status;
    }
    
    function saveLoan($status, $amount, $value, $ssn) {
        $guid = uniqid();
        $now = date('Y-m-d h:m:s');
        
        $status = $this->db->escape_string($status);
        $amount = $this->db->escape_string($amount);
        $value = $this->db->escape_string($value);
        $ssn = $this->db->escape_string($ssn);
                
        $sql = "INSERT INTO loans (guid, status, amount, property_value, ssn, date_created) ";
        $sql .= "VALUES('$guid', '$status', $amount, $value, '$ssn', '$now')";
        
        $this->db->query($sql);
        
        return $guid;
    }
    
    function getLoanByGuid($guid) {
        $guid = $this->db->escape_string($guid);
        
        $sql = "SELECT guid, status, amount, property_value, ssn, date_created ";
        $sql .= "FROM loans WHERE guid = '$guid'";
        
        $result = $this->db->query($sql);
        
        if(!$result->num_rows) {
            return false;
        }
        
        $row = $result->fetch_assoc();
        
        $result->close();
        
        return $row;
    }
}