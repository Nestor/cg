# Code generation library #

This project aims to provide tools for easy code generation and manipulation. Since we're relying on metaprogramming
for a lot of our libraries (Doctrine, Symfony, etc), generating code for this may get a bit tedious. This library aims
to provide easy code generation for:

 * General purpose PHP files and classes
 * Doctrine entities
 * Symfony bundles
 * An alternate implementation for the symfony container builder

Currently, the library is still under development, and if you want to know what's up or would like to help, let me know! You can create issues here, or contact me directly at drm@melp.nl.

## But, Doctrine and Symfony already have code generators, why do I need this one? ##

Melp\Cg provides a document-oriented approach to generating and inflecting code. Applying changes to code can easily
be implemented using the provided visitor implementation. This makes both the generation and the use of the
code generator very easy and understandable.

## Building code ##

A builder pattern is provided for quick structural setup, for example:

````
<?php

echo (string)
    (new Buffer())->append(
        new Builder()
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
    );
;
````

Renders the following code:

````
<?php
/**
 * @author Gerard van Helden <drm@melp.nl>
 */
namespace foo\bar
{
    function div($a, $b)
    {
        return $a / $b;
    }
}
````

## Using visitors ##

There are some default visitors available which help you with the most common of tasks, for example, applying the
`SingleNamespaceVisitor` would cause the namespace to be a single statement on top of the file, if there is only
one namespace configured:

````
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
````
Renders:
````
<?php
namespace foo\bar
{
    // This is part of the namespace
}
<?php
namespace foo\bar;
// This is part of the namespace
````

## Inflection and mutation ##

You can get an inflectable document by using the included parser library which parses the general structure of a
document.


## Applications ##

