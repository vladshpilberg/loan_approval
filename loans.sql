CREATE TABLE loans 
(
  guid VARCHAR(20) NOT NULL,
  status VARCHAR(20) NOT NULL,
  amount DECIMAL(10,2) NOT NULL,
  property_value DECIMAL(10,2) NOT NULL,
  ssn VARCHAR(11) NOT NULL,
  date_created DATE NOT NULL,
  PRIMARY KEY (guid)
);