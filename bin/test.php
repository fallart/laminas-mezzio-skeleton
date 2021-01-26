<?php
declare(strict_types=1);

chdir(__DIR__ . '/../');

require 'vendor/autoload.php';

$a = \Api\Routes\Hotels\Oti\RoomCodes\ListAll\Handler::class;
$c = $a . '::DESCRIPTION';

if (defined($c)) {
    var_dump(constant($c));
}

/*
 * [
                'name'       => 'api.degrees.index',
                'path'       => '/api/degrees[/]',
                'middleware' => [
                    CacheControlMiddleware::class,
                    Routes\Index\IndexHandler::class,
                ],
                'methods'    => ['GET'],
            ]
 */