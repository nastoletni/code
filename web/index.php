<?php
declare(strict_types=1);

use Nastoletni\Code\Environment;
use Nastoletni\Code\AppKernel;

require '../vendor/autoload.php';

$environment = Environment::createFromGlobals();

$kernel = new AppKernel($environment);

$kernel->handle();
