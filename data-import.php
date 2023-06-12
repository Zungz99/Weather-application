<?php
// Select weather data for given parameters
$sql = "SELECT *
FROM weather
WHERE City = '{$_GET['city']}'
AND weather_today >= DATE_SUB(NOW(), INTERVAL 1 HOUR)
ORDER BY weather_today DESC limit 1";
$result = $mysqli -> query($sql);
// If 0 record found
if ($result->num_rows == 0) {
    $url = 'https://api.openweathermap.org/data/2.5/weather?q=' . $_GET['city'] . '&appid=4b34d56dd93fec90c96f2cf71098f3a4&units=metric';
    // Get data from openweathermap and store in JSON object
    $data = file_get_contents($url);
    $json = json_decode($data, true);
    date_default_timezone_set('Asia/Kathmandu');
    // Fetch required fields
    $weather_today = date("Y-m-d H:i:s");
    $city = $json['name'];
    $weather_description = $json['weather'][0]['description'];
    $weather_temperature = $json['main']['temp'];
    $weather_wind = $json['wind']['speed'];
    $weather_when = date("Y-m-d H:i:s"); // now
    $temp_min=$json['main']['temp_min'];
    $temp_max=$json['main']['temp_max'];
    $city = $json['name'];
    $pressure = $json['main']['pressure'];
    $wind_direction=$json['wind']['deg'];

    // Build INSERT SQL statement
    $sql = "INSERT INTO weather (City, Weather_today, Temperature, Weather_main, Temperature_max, Temperature_min, Pressure, wind_speed, wind_direction)
    VALUES('{$city}', '{$weather_today}', {$weather_temperature}, '{$weather_description}', {$temp_min}, {$temp_max}, {$pressure}, {$weather_wind}, {$wind_direction})";
    // Run SQL statement and report errors
    if (!$mysqli->query($sql)) {
        echo ('<h4>SQL error description: ' . $mysqli->error . '</h4>');
    }
}