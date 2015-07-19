<?php

namespace Melp\Cg\Php\Node;

use Melp\Cg\Common\BufferInterface;
use Melp\Cg\Common\Node;

class Comment extends Node
{
    public function write(BufferInterface $buffer)
    {
        switch ($this['type']) {
            case '#':
            case '//':
                $buffer->append($this['type']);
                $this->writeChildNodes($buffer);
                $buffer->appendl();
                break;
            case '/*':
                $buffer->append($this['type']);
                $this->writeChildNodes($buffer);
                $buffer->appendl('*/');
                break;
        }
    }
}