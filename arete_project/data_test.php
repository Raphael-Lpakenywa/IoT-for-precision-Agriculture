<?php
/*************************************************************************************************
 
 ***********************************************************************************************/
 


$hostname = "localhost";
$username = "root";
$password = "";
$database = "aretedb";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Database connection is OK<br>";

if (isset($_POST["temperature"]) && isset($_POST["humidity"]) && isset($_POST["moisturePercentage"]) && isset ($_POST["suggestion"])) {

    $t = mysqli_real_escape_string($conn, $_POST["temperature"]);
    $h = mysqli_real_escape_string($conn, $_POST["humidity"]);
    $s = mysqli_real_escape_string($conn, $_POST["moisturePercentage"]);
	$stat=mysqli_real_escape_string($conn, $_POST["suggestion"]);

    $sql = "INSERT INTO precision_agriculture (temperature, humidity, soilmoisture, suggestion) VALUES ('$t', '$h', '$s', '$stat')";

    if (mysqli_query($conn, $sql)) {
        echo "\nNew record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

?>
