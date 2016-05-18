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
