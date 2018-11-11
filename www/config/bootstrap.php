<?php
/**
 * @company: hakaton (c) 2018.
 * @project: hakaton.ru
 * @module : framework
 * @author : baster
 * @version: 1
 */

// Turn on debug.
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// Include Composer autoloader.
require_once __DIR__ . '/../vendor/autoload.php';

// Start the session.
session_cache_limiter(false);
session_start();
