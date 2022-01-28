<?php

namespace CubeBuilder;

class Autoloader {

    public static function autoload($class) {
        $class  = str_replace('CubeBuilder\\', '', $class);
        $prefix = 'class-';

        $sub_directories = [
            '/includes/',
            '/includes/admin/',
            '/includes/editor/',
            '/includes/widgetsmanager/',
            '/includes/widgetsmanager/widgets/',
            '/includes/controls-manager/',
            '/includes/controls-manager/controls/',
        ];

        foreach ($sub_directories as $sub_directory) {
            $fullPath = WN_CUBE_BUILDER_DIR . $sub_directory . $prefix . strtolower($class) . '.php';

            if (!file_exists($fullPath)) {
                continue;
            }

            include_once $fullPath;
        }
    }

    public static function run() {
        spl_autoload_register([__CLASS__, 'autoload']);
    }
    
}
