<?php
$servername = "dragon.kent.ac.uk"; //server name
$username   = "m04_bookit"; // username for server
$password   = "b*asiis"; // password for server
$dbname     = "m04_bookit"; // name of the database on the server
// Create connection
$conn       = mysqli_connect($servername, $username, $password, $dbname); // we're using sqli plz
// Check connection
if (!$conn)
{
	die("Connection failed: " . mysqli_connect_error()); // check for connection error
}
?>

<?php
$test = 30;
?>

<?php

$sql_select = "SELECT * From  Agreement WHERE AgreementUID = $test ";
$result     = mysqli_query($conn, $sql_select);
if (mysqli_num_rows($result) > 0)
{
    while ($row = mysqli_fetch_assoc($result))
    {
        $AgreementUID = $row["AgreementUID"];
        $AgreementDescription   = $row["AgreementDescription"];
        echo "$AgreementUID $AgreementDescription";

        $myfile = fopen("$AgreementDescription", "r") or die("Unable to open file!");
		echo fgets($myfile);
		fclose($myfile);
    }
    
}
?>

<?php

?>