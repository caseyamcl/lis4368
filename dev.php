<?php

//Check Localhost
if (substr($_SERVER['HTTP_HOST'], 0, strlen('localhost')) != 'localhost') {
    header("HTTP/1.1 403 Forbidden");
    die("Incomplete Installation.");
}

$dev = true;
include(__DIR__ . '/index.php');

/* EOF: dev.php */