<?php

require_once 'loan_page_loader.php';
    
$loader = new LoanPageLoader();

if(isset($_GET['loan_id']) || isset($_POST['loan_id'])) {
    $guid = isset($_GET['loan_id']) ? $_GET['loan_id'] : $_POST['loan_id'];
    
    $loader->loadLoanStatusPage($guid);
} else {
    $loader->loadLoanRequestPage();
}