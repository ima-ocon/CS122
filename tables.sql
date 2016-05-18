/*
note:
/attribute/ <- primary key
-attribute- <- foreign key

warehouse_staff(/staffID/, s_lastname, s_MI, s_firstname,s_address,s_contactno)
agent(/agentno/,alastname,aMI,afirstname,aaddress,acontactno,-clientno-)
client(/clientno/,c_name,-discountID-)
supplier(/supplierno/,s_name)
itemtypes(typename)
item(/itemno/,itemname,price,srp,types)
invoice(/invoiceID/,-agentno-,invoice_date)
delivery_content(/-dbatchID-,-itemno-/,delivery_quantity)
issuance_content(/-ibatchID-,-itemno-/,issuance_quantity)
discountrates(/discountID/,timep_dr,digicam_dr,phones_dr,appliances_dr)
delivery(/dbatchID/,-staffID-,-supplierno-,ddate,dtime)
item_issuance(/ibatchID/,-staffID-,-agentno-,i_date,i_time)
invoice_content(/-invoiceID-,-itemno-/,invoice_quantity)
item_transfer(/itbatchID/,-frombatchID-,-tobatchID-,itdate)
item_return(/rbatchID/,-ibatchID-,r_date)
transfer_content(/-itbatchID-,-itemno-/,transfer_quantity)
return_content(/-rbatchID-,-itemno-/,return_quantity)
*/

DROP TABLE warehouse_staff;
DROP TABLE agent;
DROP TABLE client;
DROP TABLE supplier;
DROP TABLE itemtypes;
DROP TABLE item;
DROP TABLE invoice;
DROP TABLE delivery_content;
DROP TABLE issuance_content;
DROP TABLE user_account;

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

CREATE TABLE supplier
(
	supplierno INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	s_name VARCHAR(255)
);

ALTER TABLE supplier AUTO_INCREMENT=101;

CREATE TABLE client
(
	clientno INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	c_name VARCHAR(255)
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
	Type_ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	typename VARCHAR(255) NOT NULL
);

CREATE TABLE item
(
	itemno INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	itemname VARCHAR(255),
	price INT NOT NULL default '5',
	srp INT NOT NULL default '10',
	type INT NOT NULL,
	FOREIGN KEY (type) REFERENCES itemtypes(Type_ID)
);

CREATE TABLE discountrates
(
	Client_ID INT NOT NULL,
	Type_ID INT NOT NULL,
	PRIMARY KEY(Client_ID,Type_ID),
	Discount FLOAT(2),
	FOREIGN KEY (Client_ID) REFERENCES client(clientno),
	FOREIGN KEY (Type_ID) REFERENCES itemtypes(Type_ID)
);

-----------------------------

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

CREATE TABLE user_account
(
	userID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	staffID INT default '0',
	upassword VARCHAR(255),
	FOREIGN KEY (staffID) REFERENCES warehouse_staff(staffID)
);


INSERT INTO warehouse_staff (s_lastname, s_firstname, s_MI, s_address, s_contactno)
VALUES
('Galace', 'Miguel', 'N.', 'Quezon City', '09171234567');

INSERT INTO warehouse_staff (s_firstname) VALUES ('GUIGI!!!');

INSERT INTO supplier (s_name)
VALUES
('Namae'),
('Ming Tze');

INSERT INTO itemtypes (typename)
VALUES
('Time Pieces'),
('Digital Cameras and Accessories'),
('Mobile Phones'),
('Small Appliances');

INSERT INTO client (c_name)
VALUES
('Flowey'),
('Jormangund');

INSERT INTO discountrates(Client_ID, Type_ID, Discount)
VALUES
(501,3,'0.5'),
(501,4,'0.2'),
(502,1,'0.9'),
(502,2,'0.1');

INSERT INTO agent(alastname,afirstname,aMI,aaddress,acontactno,clientno)
VALUES
('Adajar','Amara','E.','Muntinlupa City','09177654321',501),
('Lacson','Jose Teodoro','<3','Scrub Nation','09369991111',502);

INSERT INTO item (itemname,type)
VALUES
('Beryl Gem',1),
('8 Slot Jute Bag',2),
('Iron Ore',3),
('Seasoned Wood Log',4);

INSERT INTO invoice(invoice_date,agentno)
VALUES
('2013-12-12',20001),
('2013-12-14',20002);

INSERT INTO delivery (staffID,supplierno,ddate,dtime)
VALUES
(10001,102,'2013-11-29','9:30:00'),
(10002,101,'2013-11-20','12:00:00');

INSERT INTO delivery_content(dbatchID,itemno,delivery_quantity)
VALUES
(1001,1,10),
(1001,3,11),
(1001,4,12),
(1002,2,20);

INSERT INTO item_issuance(staffID,agentno,i_date,i_time)
VALUES
(10001,20002,'2013-12-03','1:30:00'),
(10002,20001,'2013-12-05','2:30:00');

INSERT INTO issuance_content(ibatchID,itemno,issuance_quantity)
VALUES
(5001,1,10),
(5001,3,10),
(5001,4,10),
(5002,2,20);

INSERT INTO item_transfer(frombatchID,tobatchID,itdate)
VALUES
(5001,5002,'2013-12-04');

INSERT INTO transfer_content(itbatchID,itemno,transfer_quantity)
VALUES
(1,1,2),
(1,3,2),
(1,4,2);

INSERT INTO invoice_content(invoiceID,itemno,invoice_quantity)
VALUES
(80001,1,5),
(80001,3,2),
(80001,4,1),
(80002,2,10);

INSERT INTO item_return(ibatchID,r_date)
VALUES
(5001,'2013-12-15'),
(5002,'2013-12-15');

INSERT INTO return_content(rbatchID,itemno,return_quantity)
VALUES
(1,1,3),
(1,3,6),
(1,4,7),
(2,1,2),
(2,3,2),
(2,4,2),
(2,2,10);
