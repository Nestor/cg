<?php

use Melp\Cg\Php\Builder;

return
    (new Builder())
        ->file()
            ->docComment()
                ->author('Gerard van Helden <drm@melp.nl>')
            ->end()
            ->namespacex('foo\\bar')
                ->functionx('div')
                    ->arg()
                        ->name('a')
                    ->end()
                    ->arg()
                        ->name('b')
                    ->end()
                    ->raw('return $a / $b;')->end()
                ->end()
            ->end()
        ->peek()
    ;
