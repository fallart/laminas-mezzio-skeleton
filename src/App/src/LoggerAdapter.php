<?php
declare(strict_types=1);

namespace App;

use Psr\Log\AbstractLogger;

class LoggerAdapter extends AbstractLogger
{

    public function log($level, $message, array $context = array())
    {

    }
}