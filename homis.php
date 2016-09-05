
<?php
/** homis *
$servername = "100.100.100.253";
$username = "sa";
$password = "\$administrator\$1";
$dbname = "hospital";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    exit();
} 
*/
$server = '100.100.100.253\itrmcserver';
$username = 'sa';
$password = '$administrator$1';
$link = mssql_connect($server, '$username', '$password');
if (!$link) {
    die('Something went wrong while connecting to MSSQL');
}
//resource mssql_connect ([ string $server [, string $username [, string $password [, bool $new_link = false ]]]] )


?>