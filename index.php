<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/title.png" type="image/x-icon" />

    <!-- style.css Inclusion -->
    <link rel="stylesheet" href="CSS/style.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Font Style -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Girassol&display=swap" rel="stylesheet">

    <title>COVID Project App</title>
</head>

<body onload="preLoader(); fetch();">
    <!-- Preloader -->
    <div id="loading"></div>

    <!-- PHP Code to Get the IP Address of the User / Client  -->
    <?php
        // Locate IP

        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,"http://ip-api.com/json");
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $result=curl_exec($ch);
        $result=json_decode($result);

        if($result->status=='success'){
            $country = $result->country;
            $region = $result->regionName;
            $city = $result->city;
            if(isset($result->lat) && isset($result->lon)){
                $lat = $result->lat;
                $lon = $result->lon;
            }
            $ip = $result->query;
        }
    ?>

    <!-- Navbar Start -->
    <section>
        <nav class="navbar navbar-expand-md navbar-light bg-light font-weight-bold" id="nav">
        <a href="#" class="navbar-brand">
            <img src="img/title.png" width="45" alt="covid" class="d-inline-block align-middle mr-2" style="border-radius:50%;">
            <span>COVID Project App</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="PHP/stats.php">Covid Stats</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Vaccination</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Oxygen Supply</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Covid Meals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Covid Hospitals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Covid Symptom Tracker</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Stay Healthy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Donate</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">About Us</a>
                    </li>
                </ul>
            </div>
        </nav>
    </section>
    <!-- Navbar End -->

    <!-- COVID Cases in India vs COVID Cases in User's State Start -->
    <section>

    </section>
    <!-- COVID Cases in India vs COVID Cases in User's State End -->
        <div class="container py-5 ">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-5" style="border-radius: 16px; text-align: center;">
                    <h1>GLOBAL CASES</h1>
                    <p style="font-weight: bold; color: red;">New Confirmed: <span id="gNewConfirmed"></span></p>
                    <p style="font-weight: bold; color: red;">Total Confirmed: <span id="gTotalConfirmed"></p>
                    <p style="font-weight: bold; color: red;">New Deaths: <span id="gNewDeaths"></p>
                    <p style="font-weight: bold; color: red;">Total Deaths: <span id="gTotalDeaths"></p>
                    <p style="font-weight: bold; color: green;">New Recovered: <span id="gNewRecovered"></p>
                    <p style="font-weight: bold; color: green;">Total Recovered: <span id="gTotalRecovered"></p>
                    <p style="font-weight: bold; color: blue;">Last Updated On: <span id="gLastUpdated"></p>
                </div>
                <div class="col-12 col-md-5" style="border-radius: 16px; text-align: center;">
                    <h1><?=strtoupper($country)?> CASES</h1>
                    <p style="font-weight: bold; color: red;">Confirmed: <span id="cConfirmed"></span></p>
                    <p style="font-weight: bold; color: red;">Deaths: <span id="cDeaths"></span></p>
                    <p style="font-weight: bold; color: green;">Recovered: <span id="cRecovered"></span></p>
                    <p style="font-weight: bold; color: red;">Active: <span id="cActive"></span></p>
                    <p style="font-weight: bold; color: blue;">Last Updated On: <span id="cLastUpdated"></p>
                </div>
            </div>
        </div>
    <!-- Preloader JS Start -->
    <script>
        var preloader = document.getElementById("loading");

        function preLoader(){
          preloader.style.display = 'none';
        };
    </script>
    <!-- Preloader JS End -->

    <!-- Global and Country Cases Fetching -->
    <script>
        function fetch(){
            $.get("https://api.covid19api.com/summary",
                function (data){
                    document.getElementById("gNewConfirmed").innerHTML = data['Global']['NewConfirmed'];
                    document.getElementById("gTotalConfirmed").innerHTML = data['Global']['TotalConfirmed'];
                    document.getElementById("gNewDeaths").innerHTML = data['Global']['NewDeaths'];
                    document.getElementById("gTotalDeaths").innerHTML = data['Global']['TotalDeaths'];
                    document.getElementById("gNewRecovered").innerHTML = data['Global']['NewRecovered'];
                    document.getElementById("gTotalRecovered").innerHTML = data['Global']['TotalRecovered'];
                    document.getElementById("gLastUpdated").innerHTML = data['Global']['Date'];
                }
            )

            $.get("https://api.covid19api.com/live/country/'<?php echo $country ?>'", 
                function(data){
                    document.getElementById("cConfirmed").innerHTML = data[0]['Confirmed'];
                    document.getElementById("cDeaths").innerHTML = data[0]['Deaths'];
                    document.getElementById("cRecovered").innerHTML = data[0]['Recovered'];
                    document.getElementById("cActive").innerHTML = data[0]['Active'];
                    document.getElementById("cLastUpdated").innerHTML = data[0]['Date'];
                }
            )
        }
    </script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>