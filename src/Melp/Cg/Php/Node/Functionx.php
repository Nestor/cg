<?php

namespace Melp\Cg\Php\Node;

use Melp\Cg\Common\NamedNode;
use Melp\Cg\Common\BufferInterface;
use Melp\Cg\Common\NodeInterface;

class Functionx extends NamedNode
{
    protected $attributes = ['args' => []];

    public function write(BufferInterface $buffer)
    {
        $buffer
            ->append('function ' . $this['name'] . '(')
        ;

        $i = 0;
        foreach ($this['args'] as $arg) {
            if ($i ++ > 0) {
                $buffer->append(', ');
            }
            $buffer->append($arg);
        }
        $buffer
            ->appendl(')')
            ->appendl('{')
            ->indent()
        ;

        $this->writeChildNodes($buffer);

        $buffer
            ->nl()
            ->outdent()
            ->appendl('}')
        ;
    }

    public function appendChild(NodeInterface $node)
    {
        if ($node instanceof Arg) {
            $this->attributes['args'][]= $node;
        } else {
            parent::appendChild($node);
        }
    }
}