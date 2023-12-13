<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

// Retrieve the GET variables from the POST request

if (isset($_POST['city'])) {
    $city = $_POST['city'];
} else {
    $city = 'No city provided';
}

$cityInfo = json_decode(@file_get_contents('https://geocoding-api.open-meteo.com/v1/search?name='.$city), true);
if ($cityInfo === false) {
    echo json_encode([
        'response' => 'Error retrieving city information',
    ]);
    return;
}

if (isset($cityInfo['results'])) {
    $longitude = $cityInfo['results'][0]['longitude'];
    $latitude = $cityInfo['results'][0]['latitude'];
    $tempInfo = json_decode(@file_get_contents('https://api.open-meteo.com/v1/forecast?latitude='.$latitude.'&longitude='.$longitude.'&hourly=temperature_2m'), true);
    
    if ($tempInfo === false) {
        echo json_encode([
            'response' => 'Error retrieving temperature information',
        ]);
        return;
    }

    if (isset($tempInfo['hourly']['temperature_2m'])) {
        $temperatures = $tempInfo['hourly']['temperature_2m'];
        $max = max($temperatures);
        $min = min($temperatures);
        $avg = array_sum($temperatures) / count($temperatures);

        // Use the retrieved values to make API calls or perform other operations
        // For example, you can use the values to fetch weather data from an API
        echo json_encode([
            'status' => 200,
            'response' => [
                'city' => $city,
                'longitude' => $longitude,
                'latitude' => $latitude,
                'max' => $max,
                'min' => $min,
                'avg' => round($avg, 2),
            ],
        ]);
        return;
    } else {
        echo json_encode([
            'response' => 'Temperature data not found',
        ]);
        return;
    }
} else {
    echo json_encode([
        'status' => 400,
        'response' => 'City not found',
    ]);
    return;
}