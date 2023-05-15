<?php

//  for security better put thi file outside of this folder like ../
//  This file also establishes a connection to MySQL,
//  selects this database, and sets the encoding.

//  Set the database access information as constants:
DEFINE('DB_USER', 'root');
DEFINE('DB_PASSWORD', 'root');
DEFINE('DB_HOST', 'localhost'); //  ti nefunguje CONSTANTA v PDO
DEFINE('DB_NAME', 'forum2');    //  ti nefunguje CONSTANTA v PDO

//  Make the connection:
//  mysqli connection
//  $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die('Could not connect to MySQL: ' . mysqli_connect_error() );

//  pdo

try {

  echo "
<pre>\n";
  //  $pdo = new PDO('mysql:host=localhost;port=8889;dbname=misc', 'root', 'root');
  //  $pdo = new PDO("mysql:host=$servername;dbname=misc", $username, $password);
  //  $pdo = new PDO("mysql:host=DB_HOST;dbname=DB_NAME; charset=utf8mb4", DB_USER, DB_PASSWORD);
  //  inak PDO nebere CONSTANTY do tej stringy, potom skus do `ticksov`
  $pdo = new PDO("mysql:host=localhost;dbname=forum2; charset=utf8mb4", DB_USER, DB_PASSWORD);
  // set the PDO error mode to exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully to forum2?";
} catch (PDOException $e) {
  //  echo "Connection failed: " . $e->getMessage();
}
// $pdo = new PDO('mysql:host=localhost;port=8889;dbname=misc', 
//    'fred', 'zap');
// See the "errors" folder for details...
//  pre istotu aj toto dopice
//  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//  call is preceded by @ in order to suppress any ugly errors.
//  Set the encoding...
//  mysqli_set_charset($dbc, 'utf8');
