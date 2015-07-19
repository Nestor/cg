<?php

namespace Melp\Cg\Php\Node;

use Melp\Cg\Common\BufferInterface;
use Melp\Cg\Common\NamedNode;

class Property extends NamedNode
{
    public function write(BufferInterface $buffer)
    {
        foreach ($this->attributes['attr'] as $name) {
            $buffer->append($name . ' ');
        }

        $buffer->append('$' . $this['name']);
        if (isset($this['default'])) {
            $buffer
                ->append(' = ')
                ->append($this['default'])
            ;
        }
        $buffer->appendl(';');
    }
}