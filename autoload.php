<?php

spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/config/' . $class . '.php',
        __DIR__ . '/classes/' . $class . '.php',
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});
