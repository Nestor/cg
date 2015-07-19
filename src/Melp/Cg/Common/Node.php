<?php

namespace Melp\Cg\Common;

abstract class Node implements NodeInterface, \ArrayAccess
{
    /**
     * @var NodeInterface[]
     */
    public $childNodes = [];

    protected $attributes = [];

    public function __construct()
    {
    }

    public function offsetExists($offset)
    {
        if (is_int($offset)) {
            return isset($this->childNodes[$offset]);
        } else {
            return isset($this->attributes[$offset]);
        }
    }

    public function offsetGet($offset)
    {
        if (is_int($offset)) {
            return $this->childNodes[$offset];
        } else {
            return $this->attributes[$offset];
        }
    }

    public function offsetSet($offset, $value)
    {
        if (is_int($offset)) {
            $this->childNodes[$offset] = $value;
        } else {
            $this->attributes[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        if (is_int($offset)) {
            unset($this->childNodes[$offset]);
        } else {
            unset($this->attributes[$offset]);
        }
    }

    /**
     * @param BufferInterface $buffer
     */
    protected function writeChildNodes(BufferInterface $buffer)
    {
        foreach ($this->childNodes as $node) {
            $buffer->append($node);
        }
    }


    public function appendChild(NodeInterface $node)
    {
        $this->childNodes[]= $node;
    }
}