<?php

declare(strict_types=1);

const TEMP_DIR = __DIR__ . '/../temp/';

require __DIR__ . '/../vendor/autoload.php';

\Tester\Environment::setup();
\Tester\Dumper::$maxLength = 512;
