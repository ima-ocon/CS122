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
