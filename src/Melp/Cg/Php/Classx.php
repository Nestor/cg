<?php

namespace Melp\Cg\Php;

use Melp\Cg\Common\BufferInterface;
use Melp\Cg\Common\NamedNode;
use Melp\Cg\Common\Node;

class Classx extends NamedNode
{
    public function write(BufferInterface $buffer)
    {
        foreach ($this->attributes['attr'] as $name) {
            $buffer->append($name . ' ');
        }
        $buffer->append('class ' . $this['name']);

        if (isset($this['extends'])) {
            $buffer->append(' extends ' . $this['extends']);
        }
        if (isset($this['implements'])) {
            $buffer->append(' implements ' . join(', ', (array)$this['implements']));
        }

        $buffer
            ->nl()
            ->appendl('{')
            ->indent()
        ;
        foreach ($this->childNodes as $child) {
            $child->write($buffer);
        }
        $buffer
            ->outdent()
            ->appendl('}')
        ;
    }
}