<?php

namespace Melp\Cg\Php;

use Melp\Cg\Common\BufferInterface;
use Melp\Cg\Common\NamedNode;

class Namespacex extends NamedNode
{
    public function write(BufferInterface $buffer)
    {
        $buffer
            ->append('namespace ')
            ->append($this['name'])
        ;

        if (isset($this['single'])) {
            $buffer->appendl(';');
            $this->writeChildNodes($buffer);
        } else {
            $buffer
                ->appendl()
                ->appendl('{')
                ->indent()
            ;
            $this->writeChildNodes($buffer);
            $buffer
                ->outdent()
                ->appendl('}')
            ;
        }
    }

}