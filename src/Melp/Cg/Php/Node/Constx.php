<?php

namespace Melp\Cg\Php\Node;

use Melp\Cg\Common\BufferInterface;
use Melp\Cg\Common\NamedNode;

class Constx extends NamedNode
{
    public function write(BufferInterface $buffer)
    {
        $buffer
            ->append('const ')
            ->append($this['name'])
            ->append(' = ')
            ->append($this['value'])
            ->appendl(';');
    }
}