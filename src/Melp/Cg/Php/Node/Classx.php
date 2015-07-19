<?php

namespace Melp\Cg\Php\Node;

use Melp\Cg\Common\BufferInterface;
use Melp\Cg\Common\NamedNode;
use Melp\Cg\Common\Node;

class Classx extends NamedNode
{
    protected $attributes = ['type' => 'class'];

    public function write(BufferInterface $buffer)
    {
        if (isset($this['attr'])) {
            foreach ($this->attributes['attr'] as $name) {
                $buffer->append($name . ' ');
            }
        }
        $buffer->append($this['type'] . ' ' . $this['name']);

        if (isset($this['extends'])) {
            $buffer->append(' extends ' . join(', ', (array)$this['extends']));
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