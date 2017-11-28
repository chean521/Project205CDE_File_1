<?php 
include('Base/head.php'); 
?>
<title>Home Page - INTI Voting System (<?php echo ConfigurationData::Site_Version(); ?>)</title>

<link rel="stylesheet" type="text/css" href="CSS/Slideshow.css" />
<link rel="stylesheet" type="text/css" href="CSS/IndexStyle.css" />

<div class="container-fluid text-center" id="container-1">
    <div class="row">
        <div class="col-lg-12" style="height: 700px;">
            <h2 id="cont-1-text">Welcome to Web Based Voting System</h2>
            <p id="cont-desc-1">Are you voted your candidate?</p>
        </div>
    </div>
</div>
<div class="container-fluid text-center" id="container-2">
    <div class="row">
        <div class="col-lg-12" style="height: 700px;">
            <h2 id="cont-2-text">About System</h2>
            <p id="cont-desc-2">Our system is designed to let voters make vote easily. This system contains vote panel, result panel and etc.</p>
        </div>
    </div>
</div>
<div class="container-fluid text-center" id="container-3">
    <div class="row">
        <div class="col-lg-12" style="height: 700px;">
            <h2 id="cont-3-text">Contact Us</h2>
            <div class="container">
                <div class="row" style="margin-top: 10px;">
                    <div class="col-md-6 text-right" id="cont-desc-3">
                        Author Name
                    </div>
                    <div class="col-md-6 text-left" id="cont-desc-3">
                        Oscar Loh
                    </div>
                </div>
                <div class="row" style="margin-top: 10px;">
                    <div class="col-md-6 text-right" id="cont-desc-3">
                        E-Mail
                    </div>
                    <div class="col-md-6 text-left" id="cont-desc-3">
                        <a href="mailto:aabbcc@gmail.com">aabbcc@gmail.com</a>
                    </div>
                </div>
                <div class="row" style="margin-top: 10px;">
                    <div class="col-md-6 text-right" id="cont-desc-3">
                        Contact No
                    </div>
                    <div class="col-md-6 text-left" id="cont-desc-3">
                        +6 04 - 611 6111
                    </div>
                </div>
                <div class="row" style="margin-top: 10px;">
                    <div class="col-md-6 text-right" id="cont-desc-3">
                        Location
                    </div>
                    <div class="col-md-6 text-left" id="cont-desc-3">
                        <a href="#googleMap">(5.341791,100.282081)</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="googleMap" style="width:100%;height:500px;"></div>

<?php require_once('Engines/Config/config.php'); ?>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo ConfigurationData::$GoogleMapKey; ?>&callback=myMap"></script>
<script type="text/javascript" src="js/GoogleMaps.js"></script>

<?php include('Base/foot.php'); ?>
