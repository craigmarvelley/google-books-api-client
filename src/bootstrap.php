<?php

namespace CGM\Books;

/**
 * Include this file to bootstrap the library. Registers an SPL autoloader to automatically detect and load library
 * class files at runtime.
 * 
 * @param string $rootDir
 */
function autoload( $rootDir ) 
{
    spl_autoload_register(function( $className ) use ( $rootDir ) {
        $file = sprintf(
            '%s/%s.php',
            $rootDir,
            str_replace( '\\', '/', $className )
        );
                
        if ( file_exists($file) ) {
            require $file;
        }
    });
}

autoload( __DIR__ );