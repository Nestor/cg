<?php

use Melp\Cg\Common\Builder;
use Melp\Cg\Php\Classx;

$builder = new Builder('Melp\Cg\Php');

return
    $builder
        ->file()
            ->docComment()
                ->author('Gerard van Helden <drm@melp.nl>')
            ->end()
            ->namespacex('foo\\bar')
                ->single(true)

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
