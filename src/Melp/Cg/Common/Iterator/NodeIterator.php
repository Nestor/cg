<?php

namespace Melp\Cg\Common\Iterator;

class NodeIterator extends \ArrayIterator implements \RecursiveIterator
{
    /**
     * @{inheritDoc}
     */
    public function hasChildren()
    {
        return count($this->current()) > 0;
    }

    /**
     * @{inheritDoc}
     */
    public function getChildren()
    {
        return new self($this->current()->childNodes);
    }
}