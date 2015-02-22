#create a new mysql user with password 
CREATE USER 'impress'@'localhost' IDENTIFIED BY 'impress';
 
#create a database impress-tutorial
CREATE DATABASE IF NOT EXISTS impress_tutorial;

#grant privilege to the new user
GRANT ALL PRIVILEGES ON impress_tutorial.* TO 'impress'@'localhost';
FLUSH PRIVILEGES;
