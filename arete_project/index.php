<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="refresh" content="5" >
    <link rel="stylesheet" type="text/css" href="style.css" media="screen"/>

	<title> Sensor Data </title>

</head>

<body>

    <h1>SENSOR DATA</h1>
<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "aretedb";

// Create connection
$conn = new mysqli($hostname, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, temperature, humidity, soilmoisture, datetime, suggestion FROM precision_agriculture ORDER BY id DESC"; /*select items to display from the sensordata table in the data base*/

echo '<table cellspacing="5" cellpadding="5">
      <tr> 
        <th>ID</th>  
        <th>Temperature &deg;C</th> 
        <th>Humidity &#37;</th>
        <th>Soil Moisture &#37;</th> 
        <th>Date & Time</th>
        <th>Suggestion</th>		
      </tr>';
 
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $row_id = $row["id"];
        $row_temperature = $row["temperature"];
        $row_humidity = $row["humidity"]; 
        $row_soilmoisture = $row["soilmoisture"]; 
		$row_datetime = $row["datetime"];
		$row_suggestion = $row["suggestion"];
        
       
      
        echo '<tr> 
                <td>' . $row_id . '</td> 
                <td>' . $row_temperature . '</td> 
                <td>' . $row_humidity . '</td>
                <td>' . $row_soilmoisture . '</td> 
				<td>' . $row_datetime . '</td>
				<td>' . $row_suggestion . '</td>
                
              </tr>';
    }
    $result->free();
}

$conn->close();
?> 
</table>

</body>
</html>

	</body>
</html>