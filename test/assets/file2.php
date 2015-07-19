<?php

use Melp\Cg\Common\Iterator\Traverser;
use Melp\Cg\Php\Visitor\SingleNamespace;
use Melp\Cg\Php\Builder;

$file =
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

return
    (new Traverser($file))
        ->addVisitor(new SingleNamespace())
        ->traverse()
;
