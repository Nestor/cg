<?php

use Melp\Cg\Common\Builder;
use Melp\Cg\Php\Classx;

$builder = new Builder('Melp\Cg\Php');

return
    $builder
        ->classx()
            ->name('Foo')
            ->extends('Bar')
            ->implements(['i', 'j', 'k'])
            ->attr(['abstract'])
            ->property('FOO_BAR_BAZ')
                ->attr(['private', 'static'])
                ->default("['a', 'b', 'c']")
            ->end()
            ->method()
                ->name('__construct')
                ->attr(['public'])
                ->arg()
                    ->name('foo')
                    ->typehint('array')
                    ->default('[]')
                ->end()
                ->raw('$this->foo = $foo;')->end()
            ->end()
            ->method()
                ->name('setName')
                ->attr(['public', 'final'])
                ->arg()
                    ->name('name')
                ->end()
                ->raw('$this->name = $name;')->end()
            ->end()
        ->peek()
;
