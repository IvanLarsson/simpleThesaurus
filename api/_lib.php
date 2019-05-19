<?php
define('DEBUG', true);

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_NAME', 'forFun');


// By default require valid IP
if (!isset($_SERVER['REMOTE_ADDR'])) {
    httpErr(401, 'invalid ip');
}

// By default keep DB connection
$mysqli = connect();

/* MySQL connect */
function connect() {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->connect_errno) {
        fail('SQL connect fail');
    }
    if (!$mysqli->set_charset('utf8')) {
        fail('SQL charset fail');
    }    
    return $mysqli;
}

function requirePost() {
    if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
        httpErr(400, 'only post accepted');
    }
}

function requireGet() {
    if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'GET') {
        httpErr(400, 'only get accepted');
    }
}

/* Get body payload as JSON */
function payload() {
    $body = file_get_contents('php://input');
    if (strlen($body) == 0) {
        return json_decode('{}');
    }
    if (!isJSON($body)) {
        httpErr(400, 'invalid json payload');
    }
    $json = json_decode($body, false);
    return $json;
}

/* Return HTTP status error with optional JSON message */
function httpErr($status, $message = null) {
    //	error_log("vad e msg: ". $message);
    http_response_code($status);
    if ($message == null) {
        die();
    } else {
        die('{"status": ' . $status . ', "message": "' . $message . '"}' . "\n");
    }
}

/* Return HTTP JSON */
function httpJson($json) {
    die($json . "\n");
}

/* Return HTTP ok */
function httpOk($message) {
    http_response_code(200);
    die('{"status": 200, "message": ' . json_encode($message) . '}' . "\n");
}

/* Fail with message if DEBUG enable */
function fail($message) {
    if (DEBUG) {
        httpErr(500, $message);
    } else {
        httpErr(500, 'Internal error' . "\n");
    }
}


function allowCors() {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
}


function isJSON($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}