<?php

namespace Melp\Cg\Php\Node;

use Melp\Cg\Common\BufferInterface;
use Melp\Cg\Common\NamedNode;

class File extends NamedNode
{
    public function write(BufferInterface $buffer)
    {
        $buffer
            ->appendl('<?php')
        ;
        foreach ($this->childNodes as $child) {
            $child->write($buffer);
        }
    }
}