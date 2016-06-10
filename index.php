<?php
    require_once 'loan_page_loader.php';
    
    $loader = new LoanPageLoader();
        
    if(!isset($_POST['amount']) || !isset($_POST['value']) || !isset($_POST['ssn'])) {
        $loader->loadLoanRequestForm();
        exit();
    } else {
        require_once 'loan_handler.php';
        $handler = new LoanHandler();
        
        $amount = $_POST['amount'];
        $value = $_POST['value'];
        $ssn = $_POST['ssn'];
        
        $status = $handler->processLoan($amount, $value, $ssn);
        
        $loader->loadLoanProcessedPage($loanId, $status);
        exit();
    }
?>