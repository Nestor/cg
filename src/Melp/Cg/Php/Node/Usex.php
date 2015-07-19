<?php

namespace Melp\Cg\Php\Node;

use Melp\Cg\Common\BufferInterface;
use Melp\Cg\Common\NamedNode;
use Melp\Cg\Common\Node;

class Usex extends NamedNode
{
    public function write(BufferInterface $buffer)
    {
        $buffer
            ->append('use ')
            ->append($this['name'])
            ;
        if (isset($this['as'])) {
            $buffer
                ->append(' as ')
                ->append($this['as'])
            ;
        }
        $buffer->appendl(';');
    }
}