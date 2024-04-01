<?php
    error_reporting(E_ALL);

    $error = "";
    $weather = "";

    if($_GET['city']) {
        
        $_GET['city'] = str_replace(' ', '', $_GET['city']);       
        
        function url_check($url) { 
            $hdrs = @get_headers($url); 
            return is_array($hdrs) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/',$hdrs[0]) : false; 
        };
        
        if(url_check("https://www.weather-forecast.com/locations/".$_GET['city']."/forecasts/latest")) {
            $forecastPage = file_get_contents("http://www.weather-forecast.com/locations/".$_GET['city']."/forecasts/latest");
            $pageArray = explode('3 Day Weather Forecast Summary:</b><span class="read-more-small"><span class="read-more-content"> <span class="phrase">', $forecastPage);
            $secondPageArray = explode('</span></span></span></p><div class="forecast-cont"><div class="units-cont">', $pageArray[0]);
            $weather = $secondPageArray[0];
        } else {
            $error = "City name could not be found.";
        }
    }
?>

<!DOCTYPE html>
<html lang="de">
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>WEATHER API PREDICTION</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

        <style type="text/css">
            html { 
            background: url(background.jpg) no-repeat center center fixed; 
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            }
            body
            {
                background: none;
            }
            .container
            {
                text-align: center;
                margin-top: 200px;
                width: 650px;
            }        
            #wetter
            {    
                margin-top: 20px;    
            }
        </style>
    </head>

    <body>
        <div class="container">
            <h1>How is the weather?</h1>
            <form>
                <div class="form-group">
                    <label for="city">Enter the name of the city:</label>
                    <input type="text" class="form-control" name="city" id="city" placeholder="z.B. New-York, London, Hong-Kong ">
                </div>
                <button type="submit" class="btn btn-primary">Predict the weather</button>
            </form>
            
            <div id="wetter">
                <?php
                    if ($weather)
                    {
                        echo '<div class="alert alert-success" role="alert">'.$weather.'</div>';
                    }
                    else if($error)
                    {
                        echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
                    }
                ?>
            </div>
        </div>
    </body>

</html>
