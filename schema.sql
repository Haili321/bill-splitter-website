DROP TABLE User;
CREATE TABLE User(User_ID integer primary key autoincrement, User_Email text,
   User_name varchar(20), User_password varchar(20),salt text);

DROP TABLE Bill_list;
CREATE TABLE Bill_list(Bill_ID integer primary key autoincrement, User_ID int, Bill_description text, Bill_amount int, People_number int,
FOREIGN KEY (User_ID) REFERENCES User(User_ID));

DROP TABLE Bill_detail;
CREATE TABLE Bill_detail(Bill_ID int,Person_ID int, Person_name text, Person_email text, price int, completeness text,
FOREIGN KEY(Bill_ID) REFERENCES Bill_list(Bill_ID));
