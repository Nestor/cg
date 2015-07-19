<?php

namespace Melp\Cg\Php\Node;

use Melp\Cg\Common\BufferInterface;
use Melp\Cg\Common\NamedNode;

class Property extends NamedNode
{
    protected $attributes = ['attr' => ['private']];

    public function write(BufferInterface $buffer)
    {
        if (isset($this->attributes['attr'])) {
            foreach ($this->attributes['attr'] as $name) {
                $buffer->append($name)->append(' ');
            }
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