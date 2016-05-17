DROP DATABASE dist;
CREATE DATABASE dist;
USE dist;

DROP TABLE user_account;
DROP TABLE warehouse_staff;
DROP TABLE agent;
DROP TABLE client;
DROP TABLE supplier;
DROP TABLE itemtypes;
DROP TABLE item;
DROP TABLE invoice;
DROP TABLE delivery_content;
DROP TABLE issuance_content;

DROP TABLE discountrates;
DROP TABLE delivery;
DROP TABLE item_issuance;
DROP TABLE invoice_content;
DROP TABLE item_transfer;
DROP TABLE item_return;
DROP TABLE transfer_content;
DROP TABLE return_content;

CREATE TABLE warehouse_staff
(
	staffID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	s_lastname VARCHAR(255) default 'galace',
	s_MI VARCHAR(255) default 'n',
	s_firstname VARCHAR(255) default 'guigi',
	s_address VARCHAR(255) default 'quezon city',
	s_contactno VARCHAR(11) default '09120987123'
);

ALTER TABLE warehouse_staff AUTO_INCREMENT=10001;

CREATE TABLE user_account
(
	userID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	staffID INT default '0',
	upassword VARCHAR(255),
	FOREIGN KEY (staffID) REFERENCES warehouse_staff(staffID)
);

CREATE TABLE supplier
(
	supplierno INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	s_name VARCHAR(255)
);

ALTER TABLE supplier AUTO_INCREMENT=101;

CREATE TABLE discountrates
(
	discountID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	timep_dr FLOAT (2) default '0',
	digicam_dr FLOAT (2) default '0',
	phones_dr FLOAT (2) default '0',
	appliances_dr FLOAT (2) default '0'
);

CREATE TABLE client
(
	clientno INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	c_name VARCHAR(255),
	discountID INT NOT NULL,
	FOREIGN KEY (discountID) REFERENCES discountrates(discountID)
);

ALTER TABLE client AUTO_INCREMENT = 501;

CREATE TABLE agent
(
	agentno INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	alastname VARCHAR(255),
	aMI VARCHAR(255),
	afirstname VARCHAR(255),
	aaddress VARCHAR(255),
	acontactno VARCHAR(11),
	clientno INT NOT NULL,
	FOREIGN KEY(clientno) REFERENCES client(clientno)
);

ALTER TABLE agent AUTO_INCREMENT= 20001;

CREATE TABLE invoice
(
	invoiceID INT(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	agentno INT NOT NULL,
	invoice_date DATE,
	FOREIGN KEY(agentno) REFERENCES agent(agentno)
);

ALTER TABLE invoice AUTO_INCREMENT=80001;

CREATE TABLE itemtypes
(
	typename VARCHAR(255) NOT NULL PRIMARY KEY
);

CREATE TABLE item
(
	itemno INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	itemname VARCHAR(255),
	price INT NOT NULL default '5',
	srp INT NOT NULL default '10',
	types VARCHAR(255) NOT NULL,
	CHECK
	 ( types IN (SELECT typename FROM itemtypes))
);

CREATE TABLE delivery
(
	dbatchID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	staffID INT NOT NULL,
	supplierno INT NOT NULL,
	ddate DATE,
	dtime TIME,
	FOREIGN KEY(staffID) REFERENCES warehouse_staff(staffID),
	FOREIGN KEY(supplierno) REFERENCES supplier(supplierno)
);

ALTER TABLE delivery AUTO_INCREMENT=1001;

CREATE TABLE delivery_content
(
	dbatchID INT NOT NULL,
	itemno INT NOT NULL,
	PRIMARY KEY(dbatchID,itemno),
	delivery_quantity INT NOT NULL,
	FOREIGN KEY (itemno) REFERENCES item(itemno),
	FOREIGN KEY (dbatchID) REFERENCES delivery(dbatchID)
);

CREATE TABLE item_issuance
(
	ibatchID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	staffID INT NOT NULL,
	agentno INT NOT NULL,
	i_date DATE,
	i_time TIME,
	FOREIGN KEY (staffID) REFERENCES warehouse_staff(staffID),
	FOREIGN KEY (agentno) REFERENCES agent(agentno)
);

ALTER TABLE item_issuance AUTO_INCREMENT=5001;

CREATE TABLE issuance_content
(
	ibatchID INT NOT NULL,
	itemno INT NOT NULL,
	PRIMARY KEY(ibatchID,itemno),
	issuance_quantity INT NOT NULL,
	FOREIGN KEY (itemno) REFERENCES item(itemno),
	FOREIGN KEY (ibatchID) REFERENCES item_issuance(ibatchID)
);

CREATE TABLE item_transfer
(
	itbatchID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	frombatchID INT NOT NULL,
	tobatchID INT NOT NULL,
	itdate DATE,
	FOREIGN KEY (frombatchID) REFERENCES item_issuance(ibatchID),
	FOREIGN KEY (tobatchID) REFERENCES item_issuance(ibatchID)
);

CREATE TABLE transfer_content
(
	itbatchID INT NOT NULL,
	itemno INT NOT NULL,
	PRIMARY KEY(itbatchID,itemno),
	transfer_quantity INT NOT NULL,
	FOREIGN KEY (itemno) REFERENCES item(itemno),
	FOREIGN KEY (itbatchID) REFERENCES item_transfer(itbatchID)
);

CREATE TABLE item_return
(
	rbatchID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	ibatchID INT NOT NULL,
	r_date DATE,
	FOREIGN KEY (ibatchID) REFERENCES item_issuance(ibatchID)
);

CREATE TABLE return_content
(
	rbatchID INT NOT NULL,
	itemno INT NOT NULL,
	PRIMARY KEY(rbatchID,itemno),
	return_quantity INT NOT NULL,
	FOREIGN KEY (itemno) REFERENCES item(itemno),
	FOREIGN KEY (rbatchID) REFERENCES item_return(rbatchID)
);

CREATE TABLE invoice_content
(
	invoiceID INT NOT NULL,
	itemno INT NOT NULL,
	invoice_quantity INT NOT NULL,
	PRIMARY KEY (invoiceID, itemno),
	FOREIGN KEY (itemno) REFERENCES item(itemno),
	FOREIGN KEY (invoiceID) REFERENCES invoice(invoiceID)
);

INSERT INTO warehouse_staff (s_lastname, s_firstname, s_MI, s_address, s_contactno)
VALUES
('Galace', 'Miguel', 'N.', 'Quezon City', '09171234567');

INSERT INTO warehouse_staff (s_firstname) VALUES ('GUIGI!!!');
