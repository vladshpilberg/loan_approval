It's a very basic loan application project. It contains two end points: index.php and loan_status.php, also dbconfig.php where db configuration is encapsulated, dbconfig.php file has to edited so it has working db config data, and two classes: LoanHandler and LoanPageLoader. We also need to create 'loans' table in database, CREATE statement is encapsulated in loans.sql file.

Project contains Loan Application form, Loan Processing Result page, which for this very basic project just informs user whether loan has been approved or denied, Loan Status Request Form (loan id needed), and Loan Status Page. All pages are loaded by object of LoanPageLoader class.

We have just one very basic loan processing rule: if Loan to Value (LTV) is greater than 40%, loan is denied, otherwise it's approved.