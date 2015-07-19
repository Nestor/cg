<?php

namespace Melp\Cg\Php;

use Melp\Cg\Common\BufferInterface;
use Melp\Cg\Common\Node;

class File extends Node
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