<?php
//retrive data from database code
$DBHOST='localhost';
$dbuser='bantutra_reporting';
$dbpass='admin@123!';
$dbname='bantutra_reporting';
$connection= new mysqli($DBHOST,$dbuser,$dbpass,$dbname);
if(!$connection)
{die ('Could not connect: ' . mysqli_error());}

?>