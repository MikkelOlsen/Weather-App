<?php
if(isset($_POST['update']))
{
    $city = $_POST['city'];
}
else {
    $city = "Roskilde";
}

    $key = '9ede8f43df6b5ab127fccad5ea2b2bc7';
    $url = 'http://api.openweathermap.org/data/2.5/weather?q='.$city.'&appid='.$key;

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $data = json_decode(curl_exec($ch));

    curl_close($ch);

    $dataTemp = number_format($data->main->temp - 273.15);

    $windForce = number_format($data->wind->speed);

    $wind = $data->wind->deg;

if ($wind<22.5) {
    $direction="N";
}
elseif ($wind>=22.5 && $wind<67.5) {
    $direction="NE";
}
elseif ($wind>=67.5 && $wind<112.5) {
    $direction="E";
}
elseif ($wind>=112.5 && $wind<157.5) {
    $direction="SE";
}
elseif ($wind>=157.5 && $wind<202.5) {
    $direction="S";
} 
elseif ($wind>=202.5 && $wind<247.5) {
    $direction="SW";
}
elseif ($wind>=247.5 && $wind<292.5) {
    $direction="W";
}
elseif ($wind>=292.5 && $wind<337.5) {
    $direction="NW";
}
else {
    $direction="N";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/weather-icons/2.0.9/css/weather-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/weather-icons/2.0.9/css/weather-icons-wind.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="style.css">
    <title>Weather App</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 box">
                <div class="row">
                    <div class="icon-box col-md-12">
                        <i class="wi wi-owm-<?= $data->weather[0]->id; ?>"></i>
                        <?php
                            echo "<h2>There's ".$data->weather[0]->description." in ".$data->name."</h2>";    
                        ?>
                    <form method="post">
                        <div class="form-group" id="city">
                        <input class="form-control city" type="text" name="city" id="city" placeholder="<?= $data->name;?>">
                        </div>
                        <div class="form-group">
                        <button type="submit" id="update" name="update" class="hidden"></button>
                        </div>
                    </form>
                    </div>
                    <div class="container-fluid">
                        <?php
                                echo '<p><i class="wi wi-thermometer fa-fw"></i> '.$dataTemp.'&deg;C Temperature</p>';    
                                echo '<p><i class="wi wi-wind towards-'.$data->wind->deg.'-deg fa-fw"></i> '.$data->wind->deg.'&deg; '.$direction.'</p>';
                                echo '<p><i class="wi wi-wind-beaufort-'.$windForce.' fa-fw"></i> Wind Speed</p>';
                                echo '<p><i class="wi wi-humidity fa-fw"></i> '.$data->main->humidity.' Humidity</p>';
                                echo '<p>'.$data->name.' is located in '.$data->sys->country.'</p>'
                        ?> 
                    </div>           
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                            echo '<pre>',print_r($data),'</pre>';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>