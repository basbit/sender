<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

// Import all routes from the config.
$modules = require 'modules.php';

foreach ($modules as $module) {
    require ROOT_PATH . 'src/App/Module/' . $module . '/index.php';
}