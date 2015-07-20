<?php

require_once __DIR__ . '/../../../vendor/autoload.php';


use Melp\Cg\Common\Buffer;
use Melp\Cg\Php\Builder;

echo (string)
    (new Buffer())->append(
        (new Builder())
            ->file()
                ->docComment()
                    ->author('Gerard van Helden <drm@melp.nl>')
                ->end()
                ->namespacex('foo\\bar')
                    ->functionx('div')
                        ->arg('a')->end()
                        ->arg('b')->default('[]')->end()
                        ->raw('return $a / $b;')->end()
                    ->end()
                ->end()
            ->peek()
    );
