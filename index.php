<?php

    if(isset($_GET["q"])) {
        $q = $_GET["q"];
    }
    else {
        $q = $_SERVER['REMOTE_ADDR'];
    }
    // Validate ip
    if (!filter_var($q, FILTER_VALIDATE_IP) === false) {
        /* $ip = IP address */
    } else {
        /* Is it a domain? */
            if("" == "") {
                /* Yes */
                $q = gethostbyname($q);
            }
            else {
                die("Error");
                exit();
            }
        }

    /* Get JSON */
    $jsona = file_get_contents("http://ipinfo.io/".$q);
    $data = json_decode($jsona, TRUE);
    
    $jsonb = file_get_contents("http://country.io/names.json");
    $countrydata = json_decode($jsonb, TRUE);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <!-- Preload -->
        <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com" />
        <link rel="dns-prefetch" href="https://fonts.googleapis.com" />
        <link rel="dns-prefetch" href="https://fonts.gstatic.com" />
        <link rel="dns-prefetch" href="https://cdn.rawgit.com" />
        <!-- Preload (noscript) -->
        <noscript>
            <link rel="dns-prefetch" href="https://maps.googleapis.com/" />
        </noscript>
        
        <!-- Styles & Fonts -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
        <link rel="stylesheet" href="/css/style.css" />
        
        <!-- Other -->
        <title>IPLookup</title>
    </head>
    <body>
        <!-- Logo -->
        <div class="container">
            <div class="text-center" id="logo">
                <h1>IPLookup</h1>
            </div>
        </div>
        
        <!-- Map -->
        <div class="container">
            <div class="text-center" id="map">
                <img src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $data["loc"]; ?>&zoom=9&size=640x200&sensor=false" />
                
                <noscript>
                    <img src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $data["loc"]; ?>&zoom=9&size=640x200&sensor=false" />
                </noscript>
            </div>
        </div>
        
        <!-- Information -->
        <div class="container">
            <table class="table">
              <thead>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">Hostname</th>
                  <td><a href="/?q=<?php echo $data["hostname"]; ?>"><?php echo $data["hostname"]; ?></a></td>
                  <td><b>ISP</b></td>
                  <td>
                      <?php $i = explode(" ", $data["org"]); $x = count($i) - 1; for($y = 1; $y <= $x; $y++) { echo " ".$i[$y]; } ?>
                      (<a href="http://bgp.he.net/<?php echo $i[0]; ?>"><?php echo $i[0]; ?></a>)
                    </td>
                </tr>
                <tr>
                  <th scope="row">Continent</th>
                  <td><a href="https://en.wikipedia.org/wiki/Europe">Europe</a></td>
                  <td><b>Flag</b></td>
                  <td><img src="https://cdn.rawgit.com/linuxmint/iso-country-flags-svg-collection/master/svg/country-4x3/<?php echo strtolower($data["country"]); ?>.svg" alt="<?php echo $data["country"]; ?>" width="27" /></td>
                </tr>
                <tr>
                  <th scope="row">Country</th>
                  <td><a href="https://en.wikipedia.org/wiki/<?php $i = $data["country"]; echo $countrydata[$i]; ?>"><?php echo $countrydata[$i]; unset($i); ?></a></td>
                  <td><b>Country Code</b></td>
                  <td><?php echo $data["country"]; ?></td>
                </tr>
                <tr>
                  <th scope="row">Region</th>
                  <td><a href="https://en.wikipedia.org/wiki/<?php echo $data["region"]; ?>"><?php echo $data["region"]; ?></a></td>
                  <td><b>Local time</b></td>
                  <td>26 Aug 2016 22:29 EEST</td>
                </tr>
                <tr>
                  <th scope="row">Metropolis</th>
                  <td>Unknown</td>
                  <td><b>Postal Code</b></td>
                  <td><?php if (isset($data["postal"])) { echo $data["postal"]; } else { echo "Unknown"; } ?></td>
                </tr>
                <tr>
                  <th scope="row">City</th>
                  <td><a href="https://en.wikipedia.org/wiki/<?php echo $data["city"]; ?>"><?php echo $data["city"]; ?></a></td>
                  <td><b>Latitude</b></td>
                  <td><?php $i = explode(",", $data["loc"], 2); echo $i[0]; ?></td>
                </tr>
                <tr>
                  <th scope="row">IP Address</th>
                  <td><a href="?q=<?php echo $data["ip"]; ?>"><?php echo $data["ip"]; ?></a></td>
                  <td><b>Longtitude</b></td>
                  <td><?php echo $i[1]; unset($i); ?></td>
                </tr>
              </tbody>
            </table>
        </div>
        
        <div class="container">
            <div class="text-center">
                <form action="" method="get">
                    <input type="text" required name="q" placeholder="domain.com or 1.2.3.4" />
                    <input type="submit" />
                </form>
            </div>
        </div>
        
        <div class="container">
            <div class="text-center">
                &copy; <a href="https://theel0ja.info">Elias Ojala</a> 2016 - Powered by <a href="https://ipinfo.io/">ipinfo.io</a>
            </div>
        </div>



        
        
        <!-- Scripts -->
        <!--
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
        -->
    </body>
</html>