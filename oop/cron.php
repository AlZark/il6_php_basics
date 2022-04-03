<?php

use Service\PriceChangeInformer\Cron;

include 'vendor/autoload.php';
include 'config.php';

$messenger = new Cron;

$messenger->exec();