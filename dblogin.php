<?php 
$servername = "localhost";
$username = "root";
$password = "";


// Create connection
$dbhandle = mysqli_connect($servername, $username, $password);
// Check connection
if ($dbhandle->connect_error) {
  die("Connection failed: " . $dbhandle->connect_error);
}
// zvolenie databazy, ak este neexistuje, vytvori sa
$dbcheck = mysqli_select_db($dbhandle, "sklad");
if(!$dbcheck){
    $sql = "CREATE DATABASE sklad";
    if(mysqli_query($dbhandle, $sql)){
        echo "<script> console.log('Database was created')</script>";
    }
    else {
        echo "Error creating database: " . mysqli_error();
    }
}
// overenie ci v databaze uz existuje table s nazvom items, ak nie, vytvori sa
$checkTable = "SELECT * from items";
$result = mysqli_query($dbhandle, $checkTable);

if($result === false){
    $createTable = "CREATE TABLE items (
        ID INT AUTO_INCREMENT PRIMARY KEY, 
        itemID INT,
        pocetKs INT,
        cenaZaKs DOUBLE 
        )";
       $test = mysqli_query($dbhandle, $createTable);
        if($test){
            echo "<script> console.log('table created')</script>";
        }
        else echo "<script> console.log('table was not created')</script>";
}
else{
    echo "<script> console.log('Table already exist...')</script>";
}

?>