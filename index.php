<?php

use LIS4368\App;

/**
 * @file index.php
 * LIS4368.CCI.FSU.EDU Index File
 *
 * @package CaseyMcLaughlin.com
 * @author Casey McLaughlin
 */

//Sanity check
if ( ! is_readable(__DIR__ . '/app/vendor/autoload.php')) {
    header("HTTP/1.1 500 Internal Server Error");
    header("Content-type: text/plain");
    die("App is not installed correctly.  Check back later.");
}

//Autoloader
require(__DIR__ . '/app/vendor/autoload.php');

//Away we go
App::main(isset($dev) ? App::DEVELOPMENT : App::PRODUCTION);

/* EOF: index.php */