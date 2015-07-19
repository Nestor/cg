<?php

namespace Melp\Cg\Php;

use Melp\Cg\Common\BufferInterface;
use Melp\Cg\Common\Node;

class DocComment extends Node
{
    public function write(BufferInterface $buffer)
    {
        $buffer->appendl('/**');
        foreach ($this->attributes as $key => $value) {
            if (!is_array($value)) {
                $value = array($value);
            }

            foreach ($value as $v) {
                $buffer->appendl(' * @' . $key . ' ' . $v);
            }
        }
        $buffer->appendl(' */');
    }
}