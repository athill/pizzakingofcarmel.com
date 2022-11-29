<?php
namespace App;

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Phpfastcache\Helper\Psr16Adapter;
use Phpfastcache\Config\ConfigurationOption;


class Utils {

    public static function getLogger() {
        $logger = new Logger('andyhill.us');
        $logdir = __DIR__.'/../logs';
        if (!is_dir($logdir)) {
            mkdir($logdir, 0755, true);
        }
        // Now add some handlers
        $logger->pushHandler(new StreamHandler($logdir . '/andyhill.us.log'));  
        return $logger; 
    }

    public static function getCache() {
        $cachedir = __DIR__.'/../cache';
        if (!is_dir($cachedir)) {
            mkdir($cachedir, 0755, true);
        }  
        $defaultDriver = 'Files';
        $cache = new Psr16Adapter($defaultDriver, new ConfigurationOption([ "path" => $cachedir ]));
        return $cache;
    }
}