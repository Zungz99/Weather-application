<?php
header("Access-Control-Allow-Origin: *");
// Connect to database
$mysqli = new mysqli("localhost","id19488833_nishanjungsuwal","6YxuEnR60F^OdYX#");
if ($mysqli -> connect_errno) {
echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
exit();
}

//creating database if there is noone present
$result = $mysqli -> query("CREATE DATABASE IF NOT EXISTS `id19488833_db_2226697`");
$result = $mysqli -> query("USE `id19488833_db_2226697`");
$result = $mysqli -> query("CREATE TABLE IF NOT EXISTS `weather` (
    `City` varchar(20) DEFAULT NULL,
    `Weather_today` varchar(20) DEFAULT NULL,
    `Temperature` int(3) DEFAULT NULL,
    `Weather_main` varchar(20) DEFAULT NULL,
    `Temperature_min` int(8) DEFAULT NULL,
    `Temperature_max` int(8) DEFAULT NULL,
    `Pressure` int(4) DEFAULT NULL,
    `wind_speed` float DEFAULT NULL,
    `wind_direction` int(3) DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
  ");
// First, check requested data is present and fresh
include('data-import.php');
// Execute SQL query
$sql = "SELECT *
FROM weather
WHERE City = '{$_GET['city']}'
AND weather_today >= DATE_SUB(NOW(), INTERVAL 1 HOUR)
ORDER BY weather_today DESC limit 1";
$result = $mysqli -> query($sql);
// Get data, convert to JSON and print
$row = $result -> fetch_assoc();
print json_encode($row);
// Free result set and close connection
$result -> free_result();
$mysqli -> close();
?>