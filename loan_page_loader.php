<?php

class LoanPageLoader {
    function loadLoanRequestForm() {
        $action = "https://" . $_SERVER['HTTP_HOST'];
        if(isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI']) {
            $action .= $_SERVER['REQUEST_URI'];
        }
        $html = <<<EOT
<!DOCTYPE html>
<html>
<head>
<title>Loan Application</title>
<script type="text/javascript">
  function validateForm() {
    applicationForm = document.forms["application"];
    
    if(isNaN(applicationForm["amount"].value)) {
      alert("Loan Amount has to be numeric");
      return false;
    }
    
    if(isNaN(applicationForm["value"].value)) {
      alert("Property Value has to be numeric");
      return false;
    }
    
    var ssnReg = /^(\d{3})-(\d{2})-(\d{4})$/;
    if(!ssnReg.test(applicationForm["ssn"].value)) {
      alert("Wrongly formatted SSN");
      return false;
    }
    
  }
</script>
<style type="text/css">
  div.control { 
  margin: 0; 
  padding: 0; 
  padding-bottom: 1.25em; 
} 

div.control label { 
  margin: 0; 
  padding: 0; 
  display: block; 
  font-size: 100%; 
  padding-top: .1em; 
  padding-right: .25em; 
  width: 6em; 
  text-align: right; 
  float: left;
  width: 150px;
} 

div.control input { 
  margin: 0; 
  padding: 0; 
  display: block; 
  font-size: 100%; 
}
div.button input {
  margin-left: 150px;
}
</style>
</head>
<body>
<h1>Loan Application</h1>

<form name="application" method="post" onsubmit="return validateForm()">
  <div class="control"><label>Loan Amount:</label><input type="text" name="amount" required></div>
  <div class="control"><label>Property Value:</label><input type="text" name="value" required></div>
  <div class="control"><label>Social Security N:</label><input type="text" name="ssn" required></div>
  <div class="button"><input type="submit" value="Submit"></div>
 </form>
 </body>
 </html>
EOT;
 
     echo $html;
        
    }
    
    
    function loadLoanProcessedPage($loanId, $status) {
        $Status = ucfirst($status);
        
        $html = <<<EOT
<!DOCTYPE html>
<html>
<head>
<title>Loan $Status</title>
</head>
<body>
<h1>Loan has been $status</h1>
<div><a href="index.php">Apply for another loan</a></div>
<div><a href="loan_status.php?loan_id=$loanId">Check status of your loan</a></div>
</body> 
</html>
EOT;

        echo $html;
    }
    
    function loadLoanStatusPage($loanId) {
        require_once 'loan_handler.php';
        
        $handler = new LoanHandler();
                
        $loanData = $handler->getLoanByGuid($loanId);
        
        if($loanData === false) {
            return $this->loadRecordNotFoundStatusPage();
        }
        
        $guid = $loanData['guid'];
        $status = ucfirst($loanData['status']);
        $amount = $loanData['amount'];
        $propertyValue = $loanData['property_value'];
        $ssn = $loanData['ssn'];
        $dateCreated = $loanData['date_created'];
        
        $html = <<<EOT
<!DOCTYPE html>
<html>
<head>
<title>Loan Data</title>
</head>
<body>
  <h1>Loan Data and Status for Loan # $guid</h1>
  <table border=1>
    <tr>
      <th>Loan Id</th>
      <th>Status</th>
      <th>Amount</th>
      <th>Property Value</th>
      <th>SSN</th>
      <th>Date Created</th>
    </tr>
    <tr>
      <td>$guid</td>
      <td>$status</td>
      <td>$amount</td>
      <td>$propertyValue </td>
      <td>$ssn</td>
      <td>$dateCreated</td>
    </tr>
  </table>
  <div><a href="index.php">Apply for another loan</a></div>
</body>
</html>
EOT;

        echo $html;
        
         
    }
    
    function loadRecordNotFoundStatusPage($loanId) {
        $html = <<<EOT
<!DOCTYPE html>
<html>
<head>
<title>Loan not found</title>
</head>
<body>
<h1>Loan with id $loanId is not found</h1>
<div><a href="index.php">Apply for a loan</a></div>
</body> 
</html>
EOT;
        echo $html;
    }
    
    function loadLoanRequestPage() {
        $html = <<<EOT
<!DOCTYPE html>
<html>
<head>
<style type="text/css">
  div.control { 
  margin: 0; 
  padding: 0; 
  padding-bottom: 1.25em; 
} 

div.control label { 
  margin: 0; 
  padding: 0; 
  display: block; 
  font-size: 100%; 
  padding-top: .1em; 
  padding-right: .25em; 
  width: 6em; 
  text-align: right; 
  float: left;
  width: 150px;
} 

div.control input { 
  margin: 0; 
  padding: 0; 
  display: block; 
  font-size: 100%; 
}
div.button input {
  margin-left: 100px;
}
</style>
<title>Loan Request</title>
</head>
<body>
  <h1>Loan Request Form</h1>
  <form method="post">
    <div class="control"><label>Loan Id:</label><input type="text" name="loan_id" required></div>
    <div class="button"><input type="submit" value="Submit"></div>
  </form>
</body>
</html>
EOT;

        echo $html;
    }
}