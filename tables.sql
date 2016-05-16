DROP TABLE user_account;

CREATE TABLE user_account
(
	userID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	staffID INT default '0',
	upassword VARCHAR(255),
	FOREIGN KEY (staffID) REFERENCES warehouse_staff(staffID)
);
