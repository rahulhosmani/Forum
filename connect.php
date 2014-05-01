<?php 
session_start();
//connect.php
$server	    = 'localhost';
$username	= 'root';
$password	= 'root';
$database	= 'WebTechMessageBoard';

if(!($conn=mysqli_connect($server, $username, $password)))
{
 	exit('Error: could not establish database connection');
}
else
{
    mysqli_query($conn,"CREATE DATABASE IF NOT EXISTS WebTechMessageBoard;") or die(mysql_error());
}
if(!mysqli_select_db($conn,$database))
{
 	exit('Error: could not select the database');
}
else
{
    mysqli_query($conn,"CREATE TABLE IF NOT EXISTS Users(UserName VARCHAR(30),FirstName VARCHAR(30) NOT NULL,
        LastName VARCHAR(30) NOT NULL,Level  INT(8) NOT NULL,Passwd VARCHAR(255) NOT NULL,EMail VARCHAR(255) NOT NULL,
        PRIMARY KEY(UserName));") or die(mysql_error());
    
    mysqli_query($conn,"CREATE TABLE IF NOT EXISTS Categories (CategoryID INT(8) NOT NULL AUTO_INCREMENT,
        CategoryName VARCHAR(255) NOT NULL,Description VARCHAR(255) NOT NULL,UNIQUE(CategoryName),
        PRIMARY KEY(CategoryID)); ") or die(mysql_error());
    
    mysqli_query($conn,"CREATE TABLE IF NOT EXISTS Topics (TopicID INT(8) NOT NULL AUTO_INCREMENT,
        Subject VARCHAR(255) NOT NULL,Date DATETIME NOT NULL,Category INT(8) NOT NULL,Author VARCHAR(30) NOT NULL,
        PRIMARY KEY (TopicID),FOREIGN KEY(Category) REFERENCES Categories(CategoryID) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY(Author) REFERENCES Users(UserName) ON DELETE RESTRICT ON UPDATE CASCADE);") or die(mysql_error());
    
    mysqli_query($conn,"CREATE TABLE IF NOT EXISTS Posts (PostID INT(8) NOT NULL AUTO_INCREMENT,
        Content TEXT NOT NULL,Date DATETIME NOT NULL,Topic INT(8) NOT NULL,Author VARCHAR(30) NOT NULL,
        PRIMARY KEY (PostID),FOREIGN KEY(Topic) REFERENCES Topics(TopicID) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY(Author) REFERENCES Users(UserName) ON DELETE RESTRICT ON UPDATE CASCADE);") or die(mysql_error());
    
}
?>