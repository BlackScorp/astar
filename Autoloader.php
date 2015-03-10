<?php

class Autoloader {


    public static function load($class, $directory = 'classes') {
        // Transform the class name according to PSR-0
        $class = ltrim($class, '\\');
        $file = '';
        $namespace = '';

        if ($last_namespace_position = strripos($class, '\\')) {
            $namespace = substr($class, 0, $last_namespace_position);
            $class = substr($class, $last_namespace_position + 1);
            $file = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }

        $file .= str_replace('_', DIRECTORY_SEPARATOR, $class);

        if ($path = Autoloader::find_file($directory, $file)) {
            // Load the class file
            require $path;

            // Class has been found
            return TRUE;
        }

        // Class is not in the filesystem
        return FALSE;
    }

    public static function find_file($dir, $file, $ext = NULL, $array = FALSE) {
        $path = $dir . DIRECTORY_SEPARATOR . $file . '.php';
        $found = FALSE;

        if (is_file($path)) {
            $found = $path;
        }
        return $found;
    }

}
