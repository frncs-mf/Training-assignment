CREATE SCHEMA IF NOT EXISTS user_project;
USE user_project;

CREATE TABLE customer (
  customer_serial INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(35),
  last_name VARCHAR(35),
  street_address VARCHAR(60),
  city VARCHAR(25),
  phone VARCHAR(15),
  created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM;

CREATE TABLE payment (
  payment_serial INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  customer_serial INT,
  payment_date DATE,
  payment_amount DECIMAL(10,2),
  description VARCHAR(250)
) ENGINE=MyISAM;
