<?php

namespace Melp\Cg\Php\Node;

use Melp\Cg\Common\NamedNode;
use Melp\Cg\Common\BufferInterface;
use Melp\Cg\Common\Node\Raw;
use Melp\Cg\Common\NodeInterface;

class Functionx extends NamedNode
{
    protected $attributes = ['args' => []];

    public function write(BufferInterface $buffer)
    {
        $buffer
            ->append('function ');
        if (isset($this['byref'])) {
            $buffer->append('&');
        }
        $buffer->append($this['name'])->append('(');

        $i = 0;
        foreach ($this['args'] as $arg) {
            if ($i ++ > 0) {
                $buffer->append(', ');
            }
            $buffer->append($arg);
        }

        $buffer->append(')');

        if (isset($this['abstract']) && $this['abstract']) {
            $buffer->appendl(';');
        } else {
            $buffer->appendl();
            $buffer->append('{');
            if (count($this->childNodes) === 1 && $this->childNodes[0] instanceof Raw && $this->childNodes[0]['ignoreIndent']) {
                $buffer->append($this->childNodes[0]);
            } else {
                $buffer
                    ->appendl()
                    ->indent()
                ;
                $this->writeChildNodes($buffer);
                $buffer
                    ->nl()
                    ->outdent()
                ;
            }
            $buffer->appendl('}');
        }
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