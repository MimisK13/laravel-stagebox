<?php

declare(strict_types=1);

$autoloadPaths = [
    __DIR__.'/../vendor/autoload.php',
    __DIR__.'/../../../../vendor/autoload.php',
];

foreach ($autoloadPaths as $autoloadPath) {
    if (file_exists($autoloadPath)) {
        require_once $autoloadPath;

        return;
    }
}

throw new RuntimeException('Unable to find Composer autoload file for package tests.');
