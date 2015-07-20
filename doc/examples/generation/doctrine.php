<?php

use Melp\Cg\Common\Buffer;
use Melp\Cg\Common\Iterator\Traverser;
use Melp\Cg\Doctrine\Builder;
use Melp\Cg\Doctrine\Visitor\EntityVisitor;
use Melp\Cg\Doctrine\Visitor\FieldVisitor;
use Melp\Cg\Php\Visitor\SingleNamespaceVisitor;

require_once __DIR__ . '/../../vendor/autoload.php';

$node = (new Builder())
    ->file()
        ->namespacex('Foo')
            ->usex('Doctrine\ORM\Mapping')->as('ORM')->end()
            ->entity('MyEntity')
            ->field('id')->id('auto')->type('integer')->generatedValue()->setter(false)->end()
                ->field('title')->type('string')->end()
                ->field('description')->type('text')->end()
                ->field('isPublic')->type('boolean')->nullable(false)->end()
            ->end()
        ->end()
    ->peek()
;


$buffer = new Buffer();
$buffer->append(
    (new Traverser())
        ->addVisitor(new EntityVisitor())
        ->addVisitor(new SingleNamespaceVisitor())
        ->addVisitor(new FieldVisitor())
        ->traverse($node)
);

echo $buffer;