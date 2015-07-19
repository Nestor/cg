<?php

namespace Melp\Cg\Php\Node;

use Melp\Cg\Common\BufferInterface;
use Melp\Cg\Common\NamedNode;

class Arg extends NamedNode
{
    public function write(BufferInterface $buffer)
    {
        if (isset($this['typehint'])) {
            $buffer
                ->append($this['typehint'])
                ->append(' ')
            ;

        }
        if (isset($this['byref']) && $this['byref']) {
            $buffer->append('&');
        }
        $buffer->append('$' . $this['name']);

        if (isset($this['default'])) {
            $buffer
                ->append(' = ')
                ->append($this['default'])
            ;
        }
    }
}