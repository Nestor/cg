<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Melp\Cg\Common\Buffer;
use Melp\Cg\Common\Iterator\Traverser;
use Melp\Cg\Php\Builder;
use Melp\Cg\Php\Visitor\SingleNamespaceVisitor;

$node = (new Builder())
    ->file()
        ->namespacex('foo\\bar')
            ->raw('// This is part of the namespace' . PHP_EOL)->end()
        ->end()
    ->peek();

$buffer = new Buffer();
echo (string)$buffer->append($node);

$traverser = new Traverser();
$traverser->addVisitor(new SingleNamespaceVisitor());
$traverser->traverse($node);

$buffer->reset();
echo (string)$buffer->append($node);
