<?php

namespace Melp\Cg\Php\Patterns\Node;

use Melp\Cg\Common\Node\Raw;
use Melp\Cg\Php\Node\Arg;
use Melp\Cg\Php\Node\Method;

class Mutator extends Method
{
    public function __construct($name)
    {
        parent::__construct('set' . ucfirst($name));

        $this->attributes['args'][]= new Arg($name);

        $this->appendChild(new Raw('$this->' . $name . ' = $' . $name . ';'));
    }
}