<?php
// show error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

// set your default time-zone
date_default_timezone_set('Asia/Jerusalem');


// home page url
$home_url="http://app.barz.co.il/";

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// set number of records per page
$records_per_page = 5;

// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;

function getJWTkey(){
    // variables used for jwt
    return "example_key";
}