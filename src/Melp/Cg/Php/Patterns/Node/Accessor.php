<?php

namespace Melp\Cg\Php\Patterns\Node;

use Melp\Cg\Common\Node\Raw;
use Melp\Cg\Php\Node\Method;

class Accessor extends Method
{
    public function __construct($name)
    {
        parent::__construct('get' . ucfirst($name));

        $this->appendChild(new Raw('return $this->' . $name . ';'));
    }
}