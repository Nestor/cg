<?php

namespace Melp\Cg\Common;

abstract class NamedNode extends Node
{
    public function __construct($name = null)
    {
        parent::__construct();
        if (null !== $name) {
            $this['name']= $name;
        }
    }
}