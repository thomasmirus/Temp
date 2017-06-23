<?php
/*
* Gesetze des erstellten Benutzers eintrgen
*
*/
$mysqlhost="localhost";
$mysqluser="Temp";
$mysqlpwd="o4f552pRCw83G6Av";
$mysqldb="Temp";

//Hier muss der Sensor Name eingeragen werden !
$temperatureSensorPath = "/sys/bus/w1/devices/28-0416c1edcaff/w1_slave";


// --- Lese Daten aus ---
$tempSensorRawData = implode('', file($temperatureSensorPath));
//Unnötige dinge, vor der Temperatur werden verworfen
$tempSensorTemperature = substr($tempSensorRawData, strpos($tempSensorRawData, "t=") + 2);
//Kommastelle wird verschoben
$temperature = sprintf("%2.2f", $tempSensorTemperature / 1000);
$timestamp = time();

// --- Schreibe Daten in die Datenbank ---
$connection=mysql_connect($mysqlhost, $mysqluser, $mysqlpwd) or die ("Could not connect to DB!");
mysql_select_db($mysqldb, $connection) or die("Could not select DB!");
// Das ist der Quary zu erstellen der Daten in der Datenbank
$sql_query = "INSERT INTO tbl_Temp VALUES ($timestamp, $temperature);";
//Führe Quary aus.
mysql_query($sql_query);

?>
